@extends('layouts.app')
@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Report </span></h4>


        <div class="card">
            <div class="card-header flex-column flex-md-row">
                <div class="head-label" style="margin-bottom:10px">
                    <h5 class="card-title mb-0">Worker KPI Details Report</h5>
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <form method="GET">
                        <div class="input-group input-daterange" >
                            <input type="date" class="form-control" name="date_from" value="{{$date_from??''}}"/>
                            <span class="input-group-text">to</span>
                            <input type="date" class="form-control" name="date_to" value="{{$date_to??''}}"/>
                            <select id="select2Basic" name="user_id" class="select2 form-select" data-allow-clear="true">
                                <option value="">-- Select Worker --</option>
                                @foreach($allWorker as $worker)
                                    <option value="{{ $worker->id }}" {{ $user_id == $worker->id ? 'selected' : '' }}>
                                        {{ $worker->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary" type="submit" >Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-datatable text-nowrap">
                @php
                    $totalDuration = collect($data)->sum('duration');
                    $totalScore = collect($data)->sum('score');
                @endphp

                <table class="table table-bordered" id="mytable">
                    <thead>
                        <tr>
                            <th>Daily Cleaning No</th>
                            <th>Date</th>
                            <th>Cleaner Name</th>
                            <th>Time From</th>
                            <th>Time To</th>
                            <th>Duration (hrs)</th>
                            <th>No of Workers</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $row)
                            <tr>
                                <td>{{ $row['daily_cleaning_no'] }}</td>
                                <td>{{ $row['date'] }}</td>
                                <td>{{ $row['worker_name'] }}</td>
                                <td>{{ $row['time_from'] }}</td>
                                <td>{{ $row['time_to'] }}</td>
                                <td>{{ $row['duration'] }}</td>
                                <td>{{ $row['no_of_worker'] }}</td>
                                <td>{{ $row['score'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-end">Total</th>
                            <th>{{ $totalDuration }}</th>
                            <th></th>
                            <th>{{ $totalScore }}</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
    <!-- / Content -->


    @endsection
    @section('page-js')
    @endsection
    @section('scripts')
      <script>
    $(function(){
      var table = $('#mytable').DataTable({
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            paging: false,       
            info: false,          
            ordering: false,      
            searching: true,
      });
    });
  </script>
    @endsection