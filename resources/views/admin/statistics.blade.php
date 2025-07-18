@extends('admin.layouts.app')

@section('title')
    Statistics
@endsection

@section('css-header')
    <link href="{{ asset('assets/admin/css/statistics.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h1 class="h3 mb-0 text-gray-800">Statistics</h1>
        </div>

        <!-- Node Buttons -->
        <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <div>
                <button class="btn btn-sm" style="background-color: #4c74dc; color: white;">Node 1</button>
                <button class="btn btn-sm" style="background-color: #4c74dc; color: white;">Node 2</button>
                <button class="btn btn-sm" style="background-color: #4c74dc; color: white;">Node 3</button>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Chart and Sensor Dropdown -->
            <div class="col-xl-8 col-md-7 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="chart-container">
                            <!-- Sensor Dropdown -->
                            <div class="dropdown mb-3">
                                <label for="sensorSelect">Jenis Sensor:</label>
                                <select id="sensorSelect" class="form-control">
                                    <option value="npk">N</option>
                                    <option value="npk">P</option>
                                    <option value="npk">K</option>
                                    <option value="temperature">Temperature</option>
                                    <option value="ph">pH</option>
                                    <option value="humidity">Humidity</option>
                                </select>
                            </div>

                            <!-- Time Categories -->
                            <div class="d-sm-flex align-items-center justify-content-between mb-2">
                                <div>
                                    <button class="btn btn-sm" style="background-color: #4c74dc; color: white;"
                                        id="1day" onclick="loadData('1day')">1 Hari</button>
                                    <button class="btn btn-sm" style="background-color: #4c74dc; color: white;"
                                        id="1week" onclick="loadData('1week')">1 Minggu</button>
                                    <button class="btn btn-sm" style="background-color: #4c74dc; color: white;"
                                        id="1month" onclick="loadData('1month')">1 Bulan</button>
                                    <button class="btn btn-sm" style="background-color: #4c74dc; color: white;"
                                        id="1year" onclick="loadData('1year')">1 Tahun</button>
                                </div>
                            </div>

                            <!-- Chart.js Canvas -->
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kalender -->
            <div class="col-xl-4 col-md-5 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body text-center">
                        <div class="calendar-container">
                            <!-- Year Navigation -->
                            <div class="year-navigation d-flex justify-content-between align-items-center mb-2">
                                <button id="prevYear" class="btn btn-sm btn-outline-secondary">&lt;</button>
                                <span id="year" class="h5">2024</span>
                                <button id="nextYear" class="btn btn-sm btn-outline-secondary">&gt;</button>
                            </div>

                            <!-- Month Navigation -->
                            <div class="month-navigation d-flex justify-content-between align-items-center mb-2">
                                <button id="prevMonth" class="btn btn-sm btn-outline-secondary">&lt;</button>
                                <span id="month" class="h6">April</span>
                                <button id="nextMonth" class="btn btn-sm btn-outline-secondary">&gt;</button>
                            </div>

                            <!-- Days of the month -->
                            <div id="days" class="days-grid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js-footer')
    <script src = "{{ asset('assets/admin/js/chartst.js') }}"></script>
    <script src = "{{ asset('assets/admin/js/calendarst.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".dashboard-menu-link").addClass("active");

            initializeChart();
            initializeCalendar();
        })
    </script>
@endsection
