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

            <div class="card-body pb-0">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Category</label>
                        <select id="filter_category" class="form-select form-select-sm">
                            <option value="">All Categories</option>
                            @foreach($category as $cat)
                                <option value="{{$cat->name}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select id="filter_status" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-sm btn-secondary" onclick="resetFilters()">Reset</button>
                    </div>
                </div>
            </div>

            <div class="row">
              <div class="col-12">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Chinese Name</th>
                    <th>DoB</th>
                    <th>Deposit</th>
                    <th>School</th>
                    <th>Category</th>
                    <th>Level</th>
                    <th>Class</th>
                    <th>Parent</th>
                    <th>Parent Contact</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($student as $s)
                    <tr>
                      <td>{{$s->name ??""}}</td>
                      <td>{{$s->c_name ??""}}</td>
                      <td>{{$s->dob ??""}}</td>
                      <td>{{$s->deposit ??""}}</td>
                      <td>{{$s->school->name ??""}}</td>
                      <td>{{$s->category->name ??""}}</td>
                      <td>{{$s->level ??""}}</td>
                      <td>{{$s->class ??""}}</td>
                      <td>{{$s->parent_name ??""}}</td>
                      <td>{{$s->parent_contact ??""}}</td>
                      <td>
                        @if($s->is_active == 1)
                            <span style="color:green">Active</span>
                        @else
                            <span style="color:red">Inactive</span>
                        @endif
                      </td>
                      <td>
                        <a style="text-decoration: none; color: inherit;" href="{{ route('student.edit',$s) }}" title="Edit">
                          <i class="fas fa-pencil-alt"></i>
                        </a>
                      </td>
                    </tr>
                    @endforeach
                </tbody>  
              </table>
            </div>
          </div>
        </div>
    </div>

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
        var table;
        $(function () {
            table = $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            });

            table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $('#filter_category').on('change', function(){
                table.column(5).search(this.value).draw();
            });

            $('#filter_status').on('change', function(){
                table.column(10).search(this.value).draw();
            });
        });

        function resetFilters(){
            $('#filter_category').val('');
            $('#filter_status').val('');
            table.column(5).search('').column(10).search('').draw();
        }
    </script>
@endsection