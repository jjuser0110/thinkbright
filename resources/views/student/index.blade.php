@extends('layouts.app')
@section('content')
<style>
  #example1 {
      border-left: 1px solid #e0e0e0;
      border-right: 1px solid #e0e0e0;
  }

  #example1 thead th,
  #example1 tbody td {
      padding: 12px 15px !important;
  }

  .dataTables_wrapper {
      padding: 10px;
  }
</style>
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Student</span></h4>

        <div class="card">
            <div class="card-header flex-column flex-md-row" style="padding-bottom:0px;">
                <div class="head-label">
                    <h5 class="card-title mb-0">Student</h5>
                </div>
                <div class="dt-action-buttons text-end pt-3 pt-md-0">
                    <div class="dt-buttons"> 
                        <a class="dt-button create-new btn btn-primary" type="button" href="{{route('student.create')}}" onclick="showLoading()">
                            <span><i class="bx bx-plus me-sm-1"></i> 
                                <span class="d-none d-sm-inline-block">Add Student</span>
                            </span>
                        </a> 
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-12">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th >Name</th>
                    <th >Chinese Name</th>
                    <th >DoB</th>
                    <!-- <th >IC</th> -->
                    <th >Deposit</th>
                    <th >School</th>
                    <th >Level</th>
                    <th >Class</th>
                    <th >Parent</th>
                    <th >Parent Contact</th>
                    <th >Status</th>
                    <th ></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($student as $s)
                    <tr>
                      <td>{{$s->name ??""}}</td>
                      <td>{{$s->c_name ??""}}</td>
                      <td>{{$s->dob ??""}}</td>
                      <!-- <td>{{$s->ic ??""}}</td> -->
                      <td>{{$s->deposit ??""}}</td>
                      <td>{{$s->school->name ??""}}</td>
                      <td>{{$s->level ??""}}</td>
                      <td>{{$s->class ??""}}</td>
                      <td>{{$s->parent_name ??""}}</td>
                      <td>{{$s->parent_contact ??""}}</td>
                      <td><?php echo $s->is_active == 1?'<span style="color:green">Active</span>':'<span style="color:red">Inactive</span>' ?></td>
                      <td>
                        <a style="text-decoration: none; color: inherit;" href="{{ route('student.edit',$s) }}" title="Edit">
                          <i class="fas fa-pencil-alt"></i>
                        </a>
                        &nbsp;&nbsp;
                          <!-- <button type="button" style="background: none; padding: 0px; border: none; color: inherit;" onclick="if(confirm('Are you sure you want to delete?')){ window.location.href='{{ route('student.destroy',$s) }}' }"><i class="fas fa-trash-alt"></i></button> -->
                          
                      </td>
                    </tr>
                    @endforeach
                </tbody>  
              </table>
            </div>
          </div>
        </div>
    </div>
    <!-- / Content -->


    @endsection
    @section('page-js')
    @endsection
    @section('scripts')
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
        "responsive": true, "lengthChange": false, "autoWidth": false,
  // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
    @endsection

