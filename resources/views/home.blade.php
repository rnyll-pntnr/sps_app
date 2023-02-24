@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (Auth::user()->is_admin)
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Date From</label>
                                <input type="date" name="" id="fromDate" class="form-control" value="<?php echo $requestData->from ?>"}}>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Date To</label>
                                <input type="date" name="" id="toDate" class="form-control" value="<?php  echo $requestData->to ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <a class="btn btn-primary" id="filterList">
                                    Filter List
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table" width='100%'>
                                <thead>
                                    <tr>
                                        <th>Temperature (Celcius)</th>
                                        <th>Temperature (Fahrenheit)</th>
                                        <th>Location</th>
                                        <th>Local Time</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($responseData as $data)
                                        <tr>
                                            <td key={{ $data->id }}>{{ $data->temperature }}&#8451</td>
                                            <td>{{ round((($data->temperature * 1.8) + 32), 2) }}&#8457</td>
                                            <td>{{ json_decode($data->location)->name }}, {{ json_decode($data->location)->country }}</td>
                                            <td>{{$data->local_time}}</td>
                                            <td>
                                                @if ($data->temperature <= 16)
                                                    Cold
                                                @else
                                                    Hot
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{ $responseData->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
