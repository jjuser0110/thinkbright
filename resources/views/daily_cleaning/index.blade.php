@extends('layouts.app')
@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Daily Cleaning </span></h4>


        <div class="card">
            <div class="card-header flex-column flex-md-row">
                <div class="head-label" style="margin-bottom:10px">
                    <h5 class="card-title mb-0">Daily Cleaning Listing</h5>
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
                        <a class="dt-button create-new btn btn-primary" type="button" href="{{route('daily_cleaning.create')}}" onclick="showLoading()">
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
                            <th>Daily Cleaning No</th>
                            <th>Cleaning Date</th>
                            <th>Driver</th>
                            <th>Cleaners</th>
                            <th>Customer Name</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Durations</th>
                            <th>Sales</th>
                            @if(Auth::user()->role_id != 6 && Auth::user()->role_id != 3)
                            <th>SST Amount</th>
                            <th>Profit</th>
                            @endif
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($daily_cleaning as $row)
                        <tr>
                            <td>{{$row->daily_cleaning_no??""}}</td>
                            <td>{{$row->daily_cleaning_date??""}}</td>
                            <td>{{$row->driver->name??""}}</td>
                            <td>{{$row->cleaner_names ??""}}</td>
                            <td>{{$row->customer_name ??""}}</td>
                            <td>{{$row->start_time ??""}}</td>
                            <td>{{$row->end_time ??""}}</td>
                            <td>{{$row->duration_hours ??""}}</td>
                            <td>{{number_format($row->sales ??0,2)}}</td>
                            @if(Auth::user()->role_id != 6 && Auth::user()->role_id != 3)
                            <td>{{number_format($row->sst_amount ??0,2)}}</td>
                            <td>{{number_format($row->profit ??0,2)}}</td>
                            @endif
                            <td>
                                <a href="{{ route('daily_cleaning.edit',$row) }}" onclick="showLoading()"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a style="color:red;cursor:pointer" onclick="if(confirm('Are you sure you want to delete?')){showLoading();window.location.href='{{ route('daily_cleaning.destroy',$row) }}'}"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="8" style="text-align:right">Total:</th>
                            <th>{{number_format($daily_cleaning->sum('sales') ??0,2)}}</th>
                            @if(Auth::user()->role_id != 6 && Auth::user()->role_id != 3)
                            <th>{{number_format($daily_cleaning->sum('sst_amount') ??0,2)}}</th>
                            <th>{{number_format($daily_cleaning->sum('profit') ??0,2)}}</th>
                            @endif
                            <th></th>
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