@extends('admin.layouts.app')

@section('title')
    Photovoltaic Components
@endsection

@section('css-header')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Toast Notification -->
        <div id="toastNotification"
            class="toast align-items-center text-bg-warning border-0 position-fixed bottom-0 end-0 p-2" style="z-index: 1050;"
            role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <span id="toastMessage">No data found for the selected filters.</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>

        <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h1 class="h3 mb-0 text-gray-800">Photovoltaic Components Monitoring</h1>
        </div>

        <div class="row">
            <!-- Grafik dan dropdown sensor -->
            <div class="col-xl-8 col-md-7 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body text-center">
                        <input type="text" id="datePicker" class="form-control" placeholder="Pilih Tanggal" readonly />
                        <input type="hidden" id="selectedDate" value="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <div class="dropdown mb-3">
                                <label for="sensorSelect">Energy Flow:</label>
                                <select id="sensorSelect" class="form-control">
                                    <option>Select Energy Flow</option>
                    <option value="pv_voltage">PV Voltage</option>
                            <option value="pv_current">PV Current</option>
                            <option value="pv_power">PV Power</option>
                                    <option value="battery_voltage">Battery Voltage</option>
                                    <option value="battery_current">Battery Current</option>
                                    <option value="battery_power">Battery Power</option>
                                    <option value="load_voltage">Load Voltage</option>
                                    <option value="load_current">Load Current</option>
                                    <option value="load_power">Load Power</option>
                                </select>
                            </div>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tanggal Input -->
            <div class="col-xl-4 col-md-5 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5>Deskripsi Data</h5>
                        <ul>
                            <li><strong>Tanggal:</strong> <span id="descDate">{{ now()->format('Y-m-d') }}</span></li>
                            <li><strong>Energy Flow:</strong> <span id="descSensor">N</span></li>
                        </ul>
                        <h6>Data Summary:</h6>
                        <ul id="dataSummary">
                            <li>No data available.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-footer')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Default values
            let selectedSensor = 'pv_voltage';
            let selectedDate = $('#selectedDate').val();

            // Initialize chart
            const ctx = document.getElementById('myChart').getContext('2d');
            let chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: []
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Time (Hours)'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Energy Flow Value'
                            }
                        },
                    },
                },
            });

            // Initialize Datepicker
            $('#datePicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
            }).on('changeDate', function(e) {
                selectedDate = e.format();
                $('#selectedDate').val(selectedDate);
                fetchData();
            });

            // Toast Notification Function
            function showToast(message, variant = 'warning', mode = 'dismissable') {
                const toast = document.getElementById('toastNotification');
                const toastMessage = document.getElementById('toastMessage');

                // Update toast message
                toastMessage.textContent = message;

                // Update toast variant
                toast.classList.remove('text-bg-success', 'text-bg-info', 'text-bg-warning', 'text-bg-danger');
                if (variant === 'success') toast.classList.add('text-bg-success');
                else if (variant === 'info') toast.classList.add('text-bg-info');
                else if (variant === 'danger' || variant === 'error') toast.classList.add('text-bg-danger');
                else toast.classList.add('text-bg-warning');

                // Show toast
                const bsToast = new bootstrap.Toast(toast, {
                    autohide: mode !== 'sticky',
                    delay: mode === 'pester' ? 3000 : 5000,
                });
                bsToast.show();
            }

            // Reset Description
            function resetDescription() {
                $('#descDate').text(selectedDate);
                $('#descSensor').text(selectedSensor);
                $('#dataSummary').html('<li>No data available.</li>');

                // Reset chart data
                chart.data.labels = [];
                chart.data.datasets = [];
                chart.update();
            }


            // Fetch Data
            function fetchData() {
                $.ajax({
                    url: '{{ route('component.data') }}',
                    method: 'GET',
                    data: {
                        date: selectedDate,
                        sensor: selectedSensor
                    },
                    success: function(response) {
                        if (response.labels.length === 0) {
                            resetDescription();
                            showToast('No data found for the selected filters.', 'warning');
                            return;
                        }

                        // Update chart
                        chart.data.labels = response.labels;
                        chart.data.datasets = [{
                            label: `${selectedSensor} data`,
                            data: response.values,
                            borderColor: '#4c74dc',
                            fill: false,
                        }];
                        chart.update();

                        // Update description
                        let dataSummary = response.values.map((value, index) =>
                            `<li><strong>${response.labels[index]}:</strong> ${value}</li>`).join(
                            '');
                        $('#dataSummary').html(dataSummary);

                        // Toast success
                        showToast('Data successfully generated!', 'success');
                    },
                    error: function() {
                        showToast('Failed to fetch data. Please check your inputs or try again later.',
                            'danger');
                    },
                });
            }

            $('#sensorSelect').on('change', function() {
                selectedSensor = $(this).val();
                fetchData();
            });

            fetchData();
        });
    </script>
@endsection
