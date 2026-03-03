@extends('layouts.app')

@section('content')
<style>
    #mytable {
        font-size: 11px;
        border-collapse: collapse;
    }

    #mytable th,
    #mytable td {
        padding: 5px;
        font-size: 11px;
    }

    #mytable th {
        font-weight: 600; 
        text-align: center;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <a class="text-muted fw-light" href="{{route('daily_activity.index')}}">Daily ZP Activity /</a> 
         @if (isset($daily_activity)) Edit @else Create @endif
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Daily ZP Activity Details</h5>
                <div class="card-body">
                    @if (!isset($daily_activity))
                    <form enctype="multipart/form-data" method="post" action="{{ route('daily_activity.store') }}"  onsubmit="showLoading()">
                    @csrf
                    @endif
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Daily Activity No.</label>
                            <input
                                type="text"
                                class="form-control"
                                name="daily_activity_no"
                                value="{{ $daily_activity->daily_activity_no ?? $daily_activity_no ?? '' }}"
                                required
                                readonly
                            />
                            <input type="hidden" name="code" value="{{ $code ?? '' }}">
                            <input type="hidden" name="year" value="{{ $year ?? '' }}">
                            <input type="hidden" name="month" value="{{ $month ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date</label>
                            <input
                                type="date"
                                class="form-control"
                                name="daily_activity_date"
                                value="{{ $daily_activity->daily_activity_date ?? date('Y-m-d') }}"
                                required
                                @if(isset($daily_activity)) readonly @endif
                            />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Line</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="G07"
                                name="line"
                                value="{{ $daily_activity->line ?? Auth::user()->line ?? '' }}"
                                required
                                @if(isset($daily_activity)) readonly @endif
                            />
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="select2Basic" class="form-label">Leader</label>
                            <select id="select2Basic" name="leader_id" class="select2 form-select" data-allow-clear="true" @if(isset($daily_activity)) disabled @endif>
                                @foreach($leader as $leader)
                                    <option value="{{$leader->id}}" @if(isset($daily_activity) && $daily_activity->leader_id == $leader->id) selected @endif>{{$leader->name??''}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="select2Multiple" class="form-label">Operators</label>
                            <select id="select2Multiple" name="operator_ids[]" class="select2 form-select" multiple @if(isset($daily_activity)) disabled @endif>
                                @foreach($operator as $operator)
                                    <option value="{{$operator->id}}" @if(isset($daily_activity) && in_array($operator->id, $daily_activity->operator_ids)) selected @endif>{{$operator->name??''}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(isset($daily_activity))
                        <div class="col-md-6 mb-4">
                            <label  class="form-label">Status</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $daily_activity->status ?? 'pending' }}" readonly>
                                <a class="btn btn-outline-primary" onclick="if(confirm('Are you sure you want to complete this ZP?')){showLoading();window.location.href='{{ route('daily_activity.complete',$daily_activity) }}'}">Complete This ZP</a>
                            </div>
                        </div>
                        @endif
                        <hr>
                        @if(!isset($daily_activity))
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
                        @else
                            <div class="col-12">
                                <div class="flex-column flex-md-row" style="margin-bottom:10px">
                                    <div class="head-label">
                                        <h5 class="card-title mb-0">Today's Activity</h5>
                                    </div>
                                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                                        <div class="dt-buttons"> 
                                            <a class="dt-button create-new btn btn-primary" type="button" style="color:white" data-bs-toggle="modal"
                                            data-bs-target="#activityModal">
                                                Add New Record
                                            </a> 
                                        </div>
                                    </div>
                                </div>
                                <div class="card-datatable text-nowrap">
                                    <table class="table table-bordered" id="mytable">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>No Job Street</th>
                                                <th>Nama Product</th>
                                                <th>Kod Product</th>
                                                <th>Kelompok No</th>
                                                <th>Masa Mula</th>
                                                <th>Masa Tamat</th>
                                                <th>Kod Kerja</th>
                                                <th>Quantity</th>
                                                <th>Cost</th>
                                                <th>Grand Cost</th>
                                                @if(Auth::user()->role_id != 4 && Auth::user()->role_id != 3)
                                                <th>Price</th>
                                                <th>Grand Price</th>
                                                <!-- <th>Profit</th> -->
                                                @endif
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($daily_activity->items as $index=>$row)
                                            <tr>
                                                <td>{{$index+1??""}}</td>
                                                <td>{{$row->no_job_sheet??""}}</td>
                                                <td>{{$row->nama_product??""}}</td>
                                                <td>{{$row->kod_product??""}}</td>
                                                <td>{{$row->kelompok_no??""}}</td>
                                                <td align="center">{{$row->start_time??""}}</td>
                                                <td align="center">{{$row->end_time??""}}</td>
                                                <td align="center">{{$row->kod_kerja->code??""}}</td>
                                                <td align="center">{{$row->quantity??""}}</td>
                                                <td align="center">{{$row->cost??""}}</td>
                                                <td align="center">{{$row->grand_cost??""}}</td>
                                                @if(Auth::user()->role_id != 4 && Auth::user()->role_id != 3)
                                                <td align="center">{{$row->price??""}}</td>
                                                <td align="center">{{$row->grand_price??""}}</td>
                                                <!-- <td align="center">{{$row->profit??""}}</td> -->
                                                @endif
                                                <td>
                                                    <a style="color:orange;cursor:pointer" onclick="if(confirm('Are you sure you want to duplicate this?')){showLoading();window.location.href='{{ route('daily_activity.duplicateActivityItem',$row) }}'}" title="Duplicate"><i class="fa-solid fa-clone"></i></a>
                                                    <a onclick='openModal(@json($row))' title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a style="color:red;cursor:pointer" onclick="if(confirm('Are you sure you want to delete?')){showLoading();window.location.href='{{ route('daily_activity.destroyActivityItem',$row) }}'}" title="Delete"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="10" style="text-align:right">Total:</th>
                                                <th>{{ $daily_activity->items->sum('grand_cost') ?? 0 }}</th>
                                                @if(Auth::user()->role_id != 4 && Auth::user()->role_id != 3)
                                                <th></th>
                                                <th>{{ $daily_activity->items->sum('grand_price') ?? 0 }}</th>
                                                <!-- <th>{{ $daily_activity->items->sum('profit') ?? 0 }}</th> -->
                                                @endif
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                <div class="col-12">
                                    <p>Operation Salary ~ {{$daily_activity->expenses_total??0}}/{{$daily_activity->number_of_worker??0}} ={{$daily_activity->expenses_total_per_pax??0}}</p>
                                    <p>Sales ~ {{$daily_activity->sales_total??0}}</p>
                                    <p>Worker Total Salary ~ {{$daily_activity->salary??0}}</p>
                                    <p>Profit ~ {{$daily_activity->profit??0}}</p>
                                </div>
                                <div class="col-12">
                                    <div class="flex-column flex-md-row" style="margin-bottom:10px">
                                        <div class="head-label">
                                            <h5 class="card-title mb-0">Worker's Salary</h5>
                                        </div>
                                    </div>
                                    <div class="card-datatable text-nowrap">
                                        <table class="table table-bordered" id="mytable2">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Worker</th>
                                                    <th>Salary Type</th>
                                                    <th>Normal</th>
                                                    <th>OverTime</th>
                                                    <th>Salary Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($daily_activity->salaries as $ree=>$row2)
                                                <tr>
                                                    <td>{{$ree+1??""}}</td>
                                                    <td>{{$row2->worker->name??''}}</td>
                                                    <td>{{$row2->salary_type??''}}</td>
                                                    <td>{{$row2->normal??''}}</td>
                                                    <td>{{$row2->overtime??''}}</td>
                                                    <td>{{$row2->salary_amount??''}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(isset($daily_activity))
    <div class="modal fade" id="activityModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="activityForm" enctype="multipart/form-data" method="post" action="{{ route('daily_activity.addActivityItem',$daily_activity) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"  id="modalTitle">Add Daily Activity</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label class="col-form-label">No Job Sheet</label>
                            <input class="form-control" type="text" name="no_job_sheet" id="no_job_sheet" placeholder="No Job Sheet.." required>
                        </div>
                        <div class="col-12">
                            <label class="col-form-label">Name Product</label>
                            <input class="form-control" type="text" name="nama_product" id="nama_product" placeholder="Name Product.." required>
                        </div>
                        <div class="col-12">
                            <label class="col-form-label">Kod Product</label>
                            <input class="form-control" type="text" name="kod_product" id="kod_product" placeholder="Kod Product.." required>
                        </div>
                        <div class="col-12">
                            <label class="col-form-label">Kelompok No</label>
                            <input class="form-control" type="text" name="kelompok_no" id="kelompok_no" placeholder="Kelompok No.." required>
                        </div>
                        <div class="col-12">
                            <label class="col-form-label">Masa Mula</label>
                            <input class="form-control" type="time" name="start_time" id="start_time" required>
                        </div>
                        <div class="col-12">
                            <label class="col-form-label">Masa Tamat</label>
                            <input class="form-control" type="time" name="end_time" id="end_time" required>
                        </div>
                        <div class="col-12">
                            <label class="col-form-label">Kod</label>
                            <select id="kod_kerja_id" name="kod_kerja_id" class="select2 form-select" data-allow-clear="true" required>
                                @foreach($kod as $kd)
                                    <option value="{{$kd->id}}">{{$kd->code??''}} @if($kd->description !=null) ({{$kd->description??''}}) @endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="col-form-label">Quantity</label>
                            <input class="form-control" type="number" step="0.0001" min="0" name="quantity" id="quantity" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
<!-- / Content -->
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
            var table = $('#mytable2').DataTable({
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                paging: false,       
                info: false,          
                ordering: false,      
                searching: false,
            });
        });

        function openModal(row) {
            // Update modal title
            $('#modalTitle').text('Edit Daily Activity');

            // Fill modal fields
            $('#no_job_sheet').val(row.no_job_sheet);
            $('#nama_product').val(row.nama_product);
            $('#kod_product').val(row.kod_product);
            $('#kelompok_no').val(row.kelompok_no);
            $('#start_time').val(row.start_time);
            $('#end_time').val(row.end_time);
            $('#kod_kerja_id').val(row.kod_kerja_id).trigger('change');
            $('#quantity').val(row.quantity);

            // Change form action to update route
            const updateUrl = "{{ route('daily_activity.updateActivityItem', ':id') }}"
                .replace(':id', row.id);
            $('#activityForm').attr('action', updateUrl);

            // Change submit button text
            $('#modalSubmitBtn').text('Update');

            // Show the modal
            $('#activityModal').modal('show');
        }
        @if(isset($daily_activity))
        $('#activityModal').on('hidden.bs.modal', function () {
            $('#modalTitle').text('Add Daily Activity');
            $('#activityForm')[0].reset();
            $('#modalSubmitBtn').text('Save');
            $('#activityForm').attr('action', "{{ route('daily_activity.addActivityItem',$daily_activity) }}");
        });
        @endif
    </script>
@endsection
