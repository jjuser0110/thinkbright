@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@section('body')
<h4 class="font-weight-bolder mb-0">Schools</h4>
<div class="row" style="margin-top:20px">
    <div class="card">
      <div class="card-body p-3">
      <button class="btn btn-sm btn-primary" style="margin-right:10px" onclick="window.location.href='{{ route('school.create') }}'"><i class="mdi mdi-plus-circle-outline"></i>Add School</button>  
      
        <div class="row">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th >Name</th>
                  <th ></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($school as $c)
                  <tr>
                    <td>{{$c->name ??""}}</td>
                    <td>
                      <a style="text-decoration: none; color: inherit;" href="{{ route('school.edit',$c) }}" title="Edit">
                        <i class="fas fa-pencil-alt"></i>
                      </a>
                      &nbsp;&nbsp;
                      @if(Auth::user()->role == "superadmin")
                        <button type="button" style="background: none; padding: 0px; border: none; color: inherit;" onclick="if(confirm('Are you sure you want to delete?')){ window.location.href='{{ route('school.destroy',$c) }}' }"><i class="fas fa-trash-alt"></i></button>
                        @endif
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