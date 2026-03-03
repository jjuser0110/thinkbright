@extends('layouts.app')
@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Customer</span></h4>

        <!-- DataTable with Buttons -->
        <div class="card">
            <div class="card-header flex-column flex-md-row">
                <div class="head-label">
                    <h5 class="card-title mb-0">Customer Listing</h5>
                </div>
                <div class="dt-action-buttons text-end pt-3 pt-md-0">
                    <div class="dt-buttons"> 
                        @if(Auth::user()->role_id != 6 && Auth::user()->role_id != 3)
                        <a class="dt-button create-new btn btn-primary" type="button" href="{{route('customer.create')}}" onclick="showLoading()">
                            <span><i class="bx bx-plus me-sm-1"></i> 
                                <span class="d-none d-sm-inline-block">Add New Record</span>
                            </span>
                        </a> 
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="dt-column-search table table-bordered" id="mytable">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Contact No</th>
                            <th>Address</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer as $row)
                        <tr>
                            <td>{{$row->customer_name??""}}</td>
                            <td>{{$row->customer_contact??""}}</td>
                            <td>{{$row->address??""}}</td>
                            <td>{{$row->created_at??""}}</td>
                            <td>
                                @if(Auth::user()->role_id != 6 && Auth::user()->role_id != 3)
                                <a href="{{ route('customer.edit',$row) }}" onclick="showLoading()"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a style="color:red;cursor:pointer" onclick="if(confirm('Are you sure you want to delete?')){showLoading();window.location.href='{{ route('customer.destroy',$row) }}'}"><i class="fa-solid fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
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
        responsive: true,
        pageLength: 10,
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100],
      });
    });
  </script>
    @endsection