@extends('layouts.app')
@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Report </span></h4>


        <div class="card">
            <div class="card-header flex-column flex-md-row">
                <div class="head-label" style="margin-bottom:10px">
                    <h5 class="card-title mb-0">Sale Report</h5>
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
                            <th>Total Activities</th>
                            <th>Total Items</th>
                            <th>Total Sale</th>
                            <th>Total Expenses</th>
                            <th>Total Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grand_activity = 0;
                            $grand_items = 0;
                            $grand_sales = 0;
                            $grand_expenses = 0;
                            $grand_profit = 0;
                        @endphp

                        @foreach($data as $row)
                            @php
                                $grand_activity += $row['total_activity'];
                                $grand_items += $row['total_activity_items'];
                                $grand_sales += $row['total_sale'];
                                $grand_expenses += $row['total_expenses'];
                                $grand_profit += $row['total_profit'];
                            @endphp

                            <tr>
                                <td>{{ $row['date'] }}</td>
                                <td>{{ $row['total_activity'] }}</td>
                                <td>{{ $row['total_activity_items'] }}</td>
                                <td>{{ number_format($row['total_sale'], 2) }}</td>
                                <td>{{ number_format($row['total_expenses'], 2) }}</td>
                                <td>{{ number_format($row['total_profit'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th>{{ $grand_activity }}</th>
                            <th>{{ $grand_items }}</th>
                            <th>{{ number_format($grand_sales, 2) }}</th>
                            <th>{{ number_format($grand_expenses, 2) }}</th>
                            <th>{{ number_format($grand_profit, 2) }}</th>
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