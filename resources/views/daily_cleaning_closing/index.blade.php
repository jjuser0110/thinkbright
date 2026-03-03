@extends('layouts.app')
@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Daily Cleaning Closing </span></h4>


        <div class="card">
            <div class="card-header flex-column flex-md-row">
                <div class="head-label" style="margin-bottom:10px">
                    <h5 class="card-title mb-0">Daily Cleaning Closing Listing</h5>
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
                <div class="dt-action-buttons text-end pt-3 pt-md-0">
                    <div class="dt-buttons"> 
                        <a class="dt-button create-new btn btn-primary" type="button" href="{{route('daily_cleaning_closing.create')}}" onclick="showLoading()">
                            <span><i class="bx bx-plus me-sm-1"></i> 
                                <span class="d-none d-sm-inline-block">Add New Record</span>
                            </span>
                        </a> 
                    </div>
                </div>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="dt-column-search table table-bordered" id="mytable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>New Customer</th>
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
                        @foreach($daily_cleaning_closing as $row)
                        <tr>
                            <td><a href="{{ route('driver_daily_report.index', [
                                'date' => $row->closing_date,
                            ]) }}" target="_blank">
                                {{ $row->closing_date ??"" }}
                            </a></td>
                            <td>{{$row->no_of_customer ??""}}</td>
                            <td>{{$row->new_customer ??""}}</td>
                            <td>{{$row->cleaning_count ??""}}</td>
                            <td>{{$row->total_sales ??""}}</td>
                            <td>{{$row->total_sst ??""}}</td>
                            <td>{{$row->after_sst ??""}}</td>
                            <td>{{$row->cleaning_tool ??""}}</td>
                            <td>{{$row->expenses ??""}}</td>
                            <td>{{$row->salary ??""}}</td>
                            <td>{{$row->profit ??""}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="10" style="text-align:right">Total:</th>
                            <th>{{$daily_cleaning_closing->sum('profit') ??""}}</th>
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
        pageLength: 10,
        displayLength: 5,
        ordering:false,
        lengthMenu: [5, 10, 25, 50, 75, 100],
      });
    });
  </script>
    @endsection