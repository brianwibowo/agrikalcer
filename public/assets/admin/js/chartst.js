document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['00:00', '02:00', '04:00', '06:00', '08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00'],
            datasets: [{
                label: 'Data Sensor',
                data: [16.5, 18.8, 20, 22.5, 22.6, 23, 20, 19.6, 24.2, 23.9, 20, 23.3], // Contoh data dalam interval 10-40
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            scales: {
                x: {
                    beginAtZero: true,
                    min: 10, // Set minimal untuk sumbu X
                    max: 40, // Set maksimal untuk sumbu X
                    ticks: {
                        stepSize: 5 // Set langkah per 5 unit di sumbu X
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    // Handle sensor selection change
    document.getElementById('sensorSelect').addEventListener('change', function() {
        updateChart();
    });

    // Load data based on time category
    window.loadData = function(category) {
        document.querySelectorAll('.category a').forEach(function(el) {
            el.classList.remove('active');
        });
        document.getElementById(category).classList.add('active');
        updateChart();
    }

    function updateChart() {
        var sensorType = document.getElementById('sensorSelect').value;
        var category = document.querySelector('.category a.active').id;

        // Dummy data for example
        var data = {
            n: {
                '1day': [22.5, 28.8, 30, 7],
                '1week': [25, 27, 29, 30, 31, 26, 28],
                '1month': [27, 28, 29, 30, 31, 26, 28, 29, 30, 32, 31, 30],
            },
            p: {
                '1day': [15, 16, 17, 18],
                '1week': [10, 20, 15, 25, 30, 35, 25],
                '1month': [25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35],
            },
            // Add data for other sensors
            temperature: {
                '1day': [30, 31, 32, 33],
                '1week': [25, 26, 27, 28, 29, 30, 31],
                '1month': [20, 25, 30, 35, 40],
            },
            humidity: {
                '1day': [40, 45, 50, 55],
                '1week': [30, 35, 40, 45, 50, 55, 60],
                '1month': [50, 55, 60, 65, 70, 75],
            },
            ph: {
                '1day': [6.5, 6.8, 7.1, 7.2],
                '1week': [6.7, 7.0, 7.3, 7.4, 6.9],
                '1month': [7.0, 7.2, 7.3, 7.1, 6.8],
            }
        };

        var newData = data[sensorType][category];
        myChart.data.datasets[0].data = newData;
        myChart.update();
    }

    // Initialize chart with default data
    loadData('1day');
});
