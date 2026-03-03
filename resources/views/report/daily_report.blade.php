@extends('layouts.app')
@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Report </span></h4>


        <div class="card">
            <div class="card-header flex-column flex-md-row">
                <div class="head-label" style="margin-bottom:10px">
                    <h5 class="card-title mb-0">Daily Report</h5>
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
                <table class="dt-column-search table table-bordered" id="mytable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Cleaning Count</th>
                            <th>Sale</th>
                            <th>SST</th>
                            <th>After SST</th>
                            <th>Cleaning Tool</th>
                            <th>Expenses</th>
                            <th>Salary</th>
                            <th>Profit</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                        $grand = [
                            'total_customer' => 0,
                            'total_cleaning' => 0,
                            'total_sales' => 0,
                            'total_sst' => 0,
                            'total_after_sst' => 0,
                            'total_cleaning_tool' => 0,
                            'total_expenses' => 0,
                            'total_salary' => 0,
                            'final_profit' => 0,
                        ];
                        @endphp

                        @foreach($data as $row)
                            <tr>
                                <td>
                                    <a href="{{ route('driver_daily_report.index', [
                                        'date' => $row['date'],
                                    ]) }}" target="_blank">
                                        {{ $row['date'] }}
                                    </a>
                                </td>
                                <td>{{ $row['total_customer'] }}</td>
                                <td>{{ $row['total_cleaning'] }}</td>
                                <td>{{ number_format($row['total_sales'], 2) }}</td>
                                <td>{{ number_format($row['total_sst'], 2) }}</td>
                                <td>{{ number_format($row['total_profit'], 2) }}</td>
                                <td>{{ number_format($row['total_cleaning_tool'], 2) }}</td>
                                <td>{{ number_format($row['total_expenses'], 2) }}</td>
                                <td>{{ number_format($row['total_salary'], 2) }}</td>
                                <td>{{ number_format($row['final_profit'], 2) }}</td>
                            </tr>

                            @php 
                                $grand['total_customer'] += $row['total_customer'];
                                $grand['total_cleaning'] += $row['total_cleaning'];
                                $grand['total_sales'] += $row['total_sales'];
                                $grand['total_sst'] += $row['total_sst'];
                                $grand['total_after_sst'] += $row['total_profit']; // this is after SST
                                $grand['total_cleaning_tool'] += $row['total_cleaning_tool'];
                                $grand['total_expenses'] += $row['total_expenses'];
                                $grand['total_salary'] += $row['total_salary'];
                                $grand['final_profit'] += $row['final_profit'];
                            @endphp
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th>Total:</th>
                            <th>{{ $grand['total_customer'] }}</th>
                            <th>{{ $grand['total_cleaning'] }}</th>
                            <th>{{ number_format($grand['total_sales'], 2) }}</th>
                            <th>{{ number_format($grand['total_sst'], 2) }}</th>
                            <th>{{ number_format($grand['total_after_sst'], 2) }}</th>
                            <th>{{ number_format($grand['total_cleaning_tool'], 2) }}</th>
                            <th>{{ number_format($grand['total_expenses'], 2) }}</th>
                            <th>{{ number_format($grand['total_salary'], 2) }}</th>
                            <th>{{ number_format($grand['final_profit'], 2) }}</th>
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