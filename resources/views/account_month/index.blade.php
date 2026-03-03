@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Account</span></h4>

        <div class="card">
            <div class="card-header flex-column flex-md-row">
                <div class="head-label" style="margin-bottom:10px">
                    <h5 class="card-title mb-0">Account</h5>
                </div>
                <div class="dt-action-buttons text-end pt-3 pt-md-0">
                    <div class="dt-buttons"> 
                        <a class="dt-button create-new btn btn-primary" type="button" href="{{route('account_month.create')}}" onclick="showLoading()">
                            <span><i class="bx bx-plus me-sm-1"></i> 
                                <span class="d-none d-sm-inline-block">Add New Record</span>
                            </span>
                        </a> 
                    </div>
                </div>
            </div>
            <div class="row">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th >Month</th>
                    <th >Year</th>
                    <th >Total (RM)</th>
                    <th >Paid (RM)</th>
                    
                    @if(Auth::user()->role=='admin')
                    <!--<th >Extra (RM)</th>-->
                    <!--<th >Payment (RM)</th>-->
                    <!--<th >Food (RM)</th>-->
                    <!--<th >Salary (RM)</th>-->
                    <th >Oustanding (RM)</th>
                    @endif
                    <th ></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($account_month as $c)
                    <tr>
                      <td>{{$c->month_name ??""}}</td>
                      <td>{{$c->year ??""}}</td>
                      <td>{{$c->total ??""}}</td>
                      <td>{{$c->paid ??""}}</td>
                      
                    @if(Auth::user()->role=='admin')
                      <!--<td>{{$c->extra_received ??""}}</td>-->
                      <!--<td>{{$c->payment ??""}}</td>-->
                      <!--<td>{{$c->food ??""}}</td>-->
                      <!--<td>{{$c->salary ??""}}</td>-->
                      <td>{{$c->outstanding ??""}}</td>
                      @endif
                      <td>
                        <a style="text-decoration: none; color: inherit;" href="{{ route('account_month.sync',$c) }}" >
                        <i class="fa fa-refresh"></i>
                        </a>
                        &nbsp;&nbsp;
                        <a style="text-decoration: none; color: inherit;" href="{{ route('account_month.edit',$c) }}" title="Edit">
                          <i class="fas fa-pencil-alt"></i>
                        </a>
                        &nbsp;&nbsp;
                          <button type="button" style="background: none; padding: 0px; border: none; color: inherit;" onclick="if(confirm('Are you sure you want to delete?')){ window.location.href='{{ route('account_month.destroy',$c) }}' }"><i class="fas fa-trash-alt"></i></button>
                          
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
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        pageLength: 10,
        displayLength: 5,
        ordering:false,
        lengthMenu: [5, 10, 25, 50, 75, 100],
      });
    });
  </script>

  <script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "order": [], // Disable auto-ordering
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
    @endsection

