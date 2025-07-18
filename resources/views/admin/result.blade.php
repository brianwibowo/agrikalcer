@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Prediction Result</h6>
            </div>
            <div class="card-body">
                @if(isset($prediction))
                    <h4 class="text-success">Predicted Crop: {{ $prediction['Crop'] }}</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Value</th>
                                <th>Mean</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prediction['Parameters'] as $key => $param)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ $param['value'] }}</td>
                                    <td>{{ $param['mean'] }}</td>
                                    <td>
                                        @if($param['status'] === 'Optimal')
                                            <span class="badge badge-success">{{ $param['status'] }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ $param['status'] }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Tombol download -->
                    <div class="mt-3">
                        <a href="{{ route('admin.recommender.downloadImage') }}" class="btn btn-sm btn-primary">Download Image</a>
                        <a href="{{ route('admin.generateReport') }}" class="btn btn-sm btn-success">Download Excel</a>
                    </div>

                @else
                    <p class="text-danger">No prediction result available.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
