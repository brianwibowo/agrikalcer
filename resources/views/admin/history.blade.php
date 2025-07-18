@extends('admin.layouts.app')

@section('title', 'History')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Riwayat</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Node</th>
                                <th>Date</th>
                                <th>N(mg/kg)</th>
                                <th>P(mg/kg)</th>
                                <th>K(mg/kg)</th>
                                <th>Temperature(&deg;C)</th>
                                <th>pH</th>
                                <th>Humidity(%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>1</td>
                                <td>12-04-2004 18.30</td>
                                <td>2.5</td>
                                <td>7.2</td>
                                <td>11.8</td>
                                <td>35</td>
                                <td>7.6</td>
                                <td>20</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection

@section('scripts')
    <!-- Import Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
