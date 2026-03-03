@extends('layouts.app')
@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Report </span></h4>


        <div class="card">
            <div class="card-header flex-column flex-md-row">
                <div class="head-label" style="margin-bottom:10px">
                    <h5 class="card-title mb-0">Worker Daily Report</h5>
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <form method="GET">
                        <div class="input-group input-daterange" >
                            <input type="date" class="form-control" name="date_from" value="{{$date_from??''}}"/>
                            <span class="input-group-text">to</span>
                            <input type="date" class="form-control" name="date_to" value="{{$date_to??''}}"/>
                            <select id="select2Basic" name="user_id" class="select2 form-select" data-allow-clear="true">
                                <option value="">-- Select Worker --</option>
                                @foreach($allWorker as $worker)
                                    <option value="{{ $worker->id }}" {{ $user_id == $worker->id ? 'selected' : '' }}>
                                        {{ $worker->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary" type="submit" >Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="table table-bordered" id="mytable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Total Activities</th>
                            <th>Total Items</th>
                            <th>Total Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grand_salary = 0;
                        $grand_activity = 0;
                        $grand_item = 0;
                         @endphp
                        @foreach($data as $row)
                            @php $grand_salary += $row['total_salary'];
                            $grand_activity += $row['total_activity'];
                            $grand_item += $row['total_activity_items'];
                             @endphp
                            <tr>
                                <td>{{ $row['date'] }}</td>
                                <td>{{ $row['worker_name'] }}</td>
                                <td>{{ $row['total_activity'] }}</td>
                                <td>{{ $row['total_activity_items'] }}</td>
                                <td>{{ number_format($row['total_salary'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th></th>
                            <th>{{ number_format($grand_activity) }}</th>
                            <th>{{ number_format($grand_item) }}</th>
                            <th>{{ number_format($grand_salary, 2) }}</th>
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