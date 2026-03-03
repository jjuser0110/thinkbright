@extends('layouts.app')
@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Report </span></h4>


        <div class="card">
            <div class="card-header flex-column flex-md-row">
                <div class="head-label" style="margin-bottom:10px">
                    <h5 class="card-title mb-0">Worker KPI Report</h5>
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <form method="GET">
                        <div class="input-group input-daterange" >
                            <input type="date" class="form-control" name="date_from" value="{{$date_from??''}}"/>
                            <span class="input-group-text">to</span>
                            <input type="date" class="form-control" name="date_to" value="{{$date_to??''}}"/>
                            <button class="btn btn-primary" type="submit" >Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="table table-bordered" id="mytable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Driver Name</th>
                            <th>Role</th>
                            <th>Total Cleaning</th>
                            <th>Total Sales</th>
                            <th>Total Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($drivers as $index => $row)
                            <tr>
                                <td>{{ $index+1??'' }}</td>
                                <td>{{ $row->name??'' }}</td>
                                <td>{{ $row->role->title??'' }}</td>
                                <td>{{ $row->total_cleaning??'' }}</td>
                                <td>{{ number_format($row->total_sales, 2) }}</td>
                                <td>{{ number_format($row->driver_salary??0, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="table table-bordered" id="mytable2">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Cleaner Name</th>
                            <th>Role</th>
                            <th>Working Days</th>
                            <th>Total Cleaning</th>
                            <th>Total Duration</th>
                            <th>Total KPI</th>
                            <th>Total Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total_salary = 0 @endphp
                        @foreach($cleaners as $index => $row)
                            <tr>
                                <td>{{ $index+1??'' }}</td>
                                <td>
                                    <a href="{{ route('worker_kpi_report.index', [
                                        'date_from' => $date_from,
                                        'date_to' => $date_to,
                                        'user_id' => $row->id
                                    ]) }}" target="_blank">
                                        {{ $row->name??'' }}
                                    </a>
                                </td>
                                <td>{{ $row->role->title??'' }}</td>
                                <td>{{ $row->total_day_work ??'' }}</td>
                                <td>{{ $row->total_cleaning ??'' }}</td>
                                <td>{{ $row->cleaner_duration ??'' }}</td>
                                <td>{{ $row->cleaner_score ??'' }}</td>
                                <td>{{ number_format($row->cleaner_salary??0, 2) }}</td>
                            </tr>
                        @php $total_salary += $row->cleaner_salary @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th colspan="7">Total</th>
                        <th>{{number_format($total_salary??0, 2)??0}}</th>
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
            
            var table2 = $('#mytable2').DataTable({
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                paging: false,       
                info: false,          
                ordering: false,      
                searching: true,
            });
        });
  </script>
    @endsection