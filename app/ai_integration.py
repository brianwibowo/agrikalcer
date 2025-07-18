import requests
import datetime
import time
import json

# Konfigurasi API Laravel
LARAVEL_API_URL = "https://greenhouse-iot.unnes.id/api/ai-data"
CHECK_AI_API_URL = "https://greenhouse-iot.unnes.id/api/ai-results"

# Konfigurasi API AI
AI_SERVER_URL = "http://10.2.16.100:4430/predict/"

def fetch_ai_data(date_str):
    start_of_day = f"{date_str} 00:00:00"  
    end_of_day = f"{date_str} 23:59:59"    
    response = requests.get(f"{LARAVEL_API_URL}?start={start_of_day}&end={end_of_day}")
    if response.status_code == 200:
        return response.json().get('data', [])
    else:
        print(f"Gagal mengambil data: {response.status_code}")
        return []

def process_data(data):
    processed_results = []
    for entry in data:
        payload = {
            "N": entry['n'],
            "P": entry['p'],
            "K": entry['k'],
            "Temperature": entry['temperature'],
            "Humidity": entry['humidity'],
            "ph": entry['ph']
        }
        node = entry.get('node', 'default_node')  # Mendapatkan node dari data
        response = requests.post(AI_SERVER_URL, json=payload)
        if response.status_code == 200:
            result = response.json()
            processed_results.append(format_check_ai_data(result, entry['id'], node))  # Mengirim node ke format_check_ai_data
        else:
            print(f"Gagal memproses data ID {entry['id']}")
    return processed_results

def format_check_ai_data(result, record_id, node): 
    formatted_data = []

    # Memproses setiap parameter dan menyesuaikan dengan format tabel check_ai
    for param_name, value in result.get('Parameters', {}).items():
        if isinstance(value, dict):
            formatted_data.append({
                "Crop": result.get('Crop', 'unknown'),
                "ai_data_id": record_id,
                "node": node,
                "parameter_name": param_name,
                "value": value.get('value', 0),
                "mean": value.get('mean', 0),
                "status": value.get('status', 'Unknown'),
            })

    return formatted_data

def send_ai_result(data):
    for record in data:
        print(f"Record type: {type(record)}")  # Menambahkan print untuk memeriksa tipe data
        print(f"Record content: {json.dumps(record, indent=2)}")  # Menambahkan print untuk memeriksa isi data
        if isinstance(record, dict) and 'parameter_name' in record:  # Pastikan bahwa record adalah dictionary
            try:
                response = requests.post(CHECK_AI_API_URL, json=record)
                if response.status_code == 201:
                    print(f"Berhasil mengirim data")
                elif response.status_code == 200:
                    print(f"Gagal mengirim data, response: {response.text}")
                elif response.status_code == 500:
                    print(f"Error 500: Server internal error")
                    time.sleep(5)
                elif response.status_code == 429:
                    print(f"Error 429: Terlalu banyak permintaan")
                    retry_after = int(response.headers.get('Retry-After', 5)) 
                    time.sleep(retry_after)
                else:
                    print(f"Gagal mengirim data dengan status {response.status_code}")
            except requests.exceptions.RequestException as e:
                print(f"Terjadi kesalahan saat mengirim data: {e}")
        else:
            print(f"Data tidak sesuai, type: {type(record)}")

def main():
    today = datetime.datetime.now().strftime('%Y-%m-%d')  # Tanggal hari ini
    data = fetch_ai_data(today)
    if data:
        processed_results = process_data(data)
        for result in processed_results:
            send_ai_result(result)
    else:
        print("Tidak ada data untuk diproses.")

if __name__ == "__main__":
    main()
