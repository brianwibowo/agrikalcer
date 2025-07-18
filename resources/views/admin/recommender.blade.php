@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/recommender.css') }}">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">AI Crop Recommendations</h6>
            </div>
            <div class="card-body">
                <div class="form-inline mb-3">
                    <select class="form-control mr-2" id="nodeFilter">
                        <option value="">Select Node</option>
                        <option value="node1">Node 1</option>
                        <option value="node2">Node 2</option>
                        <option value="node3">Node 3</option>
                    </select>
                    <input type="date" class="form-control mr-2" id="dateFilter">
                    <button class="btn btn-primary" id="applyFilter">Apply</button>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Node</th>
                            <th>Crop</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody id="aiResults">
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->node }}</td>
                                <td>{{ $item->crop }}</td>
                                <td>
                                    <button class="btn btn-info"
                                        onclick="showDetails({{ $item->parameters }})">View</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            function showDetails(data) {
                alert(JSON.stringify(data, null, 2));
            }
        </script>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Crop Recommender</h6>
            </div>
            <div class="d-flex justify-content-around py-3">
                <button class="btn btn-sm btn-primary shadow-sm mx-3" data-toggle="modal" data-target="#cropModal">
                    <i class="fas fa-leaf fa-sm text-white-50"></i> Crop Recommender
                </button>
            </div>
        </div>

        <!-- Crop Recommender Modal -->
        <div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="cropModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cropModalLabel">Crop Recommender</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="cropForm" method="POST" action="{{ route('predict') }}">
                            @csrf
                            <div class="form-group">
                                <label for="nitrogen" class="form-label">Amount of Nitrogen in Soil</label>
                                <input type="text" name="N" class="form-control input-placeholder" id="nitrogen"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="phosphorous" class="form-label">Amount of Phosphorous in Soil</label>
                                <input type="text" name="P" class="form-control input-placeholder" id="phosphorous"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="potassium" class="form-label">Amount of Potassium in Soil</label>
                                <input type="text" name="K" class="form-control input-placeholder" id="potassium"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="temperature" class="form-label">Temperature (in Celsius)</label>
                                <input type="text" name="Temperature" class="form-control input-placeholder"
                                    id="temperature" required>
                            </div>
                            <div class="form-group">
                                <label for="humidity" class="form-label">Humidity (in %)</label>
                                <input type="text" name="Humidity" class="form-control input-placeholder" id="humidity"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="phValue" class="form-label">pH value of Soil</label>
                                <input type="text" name="ph" class="form-control input-placeholder" id="phValue"
                                    required>
                            </div>
                            <button id="predictBtn" class="btn-predict">Predict Crop</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/admin/js/recommender.js') }}"></script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
