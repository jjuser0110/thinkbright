@extends('layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 px-5 mt-5">

    <h4 class="py-2 breadcrumb-wrapper mb-3">
        <a class="text-muted fw-light" href="{{route('account_month.index')}}">Add Month Account</a>
    </h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Add Account Month</h5>

                <div class="card-body p-3">

                    <!-- 🔥 Responsive Scroll Wrapper -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-nowrap align-middle">
                            
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Student</th>
                                    <th class="text-center">Tuition</th>
                                    <th class="text-center">TT Add</th>
                                    <th class="text-center">B&L</th>
                                    <th class="text-center">Trans</th>
                                    <th class="text-center">Trans Add</th>
                                    <th class="text-center">Deposit</th>
                                    <th class="text-center">Material</th>
                                    <th class="text-center">Register</th>
                                    <th class="text-center">Extra</th>
                                    <th class="text-center">Extra 2</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Sent</th>
                                    <th class="text-center">Paid</th>
                                    <th>Remarks</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $index=1; ?>
                                @foreach ($account_month->accounts as $a)
                                <tr id="tr~{{$a->id}}" 
                                    {{ $a->paid != null ? 'style=background-color:lightgreen' : '' }}>
                                    
                                    <td class="text-center">{{$index}}</td>
                                    <td>{{$a->student->name ?? ""}}</td>

                                    <!-- 🔥 Small Input Style -->
                                    @php
                                        $fields = [
                                            'tuition','tuition_extra','food','transport',
                                            'transport_extra','deposit','material',
                                            'registration','extra','extra_2'
                                        ];
                                    @endphp

                                    @foreach($fields as $field)
                                    <td class="text-center">
                                        <input type="number"
                                            step="0.01"
                                            class="form-control form-control-sm text-center"
                                            style="width:65px; margin:auto"
                                            name="{{$field}}~{{$a->id}}"
                                            id="{{$field}}~{{$a->id}}"
                                            value="{{$a->$field ?? ''}}"
                                            onchange="saveData(this)">
                                    </td>
                                    @endforeach

                                    <td class="text-center">
                                        <input type="number"
                                            step="0.01"
                                            class="form-control form-control-sm text-center"
                                            style="width:75px; margin:auto"
                                            name="total~{{$a->id}}"
                                            id="total~{{$a->id}}"
                                            value="{{$a->total ?? ''}}"
                                            readonly>
                                    </td>

                                    <td class="text-center">
                                        <input type="checkbox"
                                            name="sent~{{$a->id}}"
                                            id="sent~{{$a->id}}"
                                            onclick="checkboxClick(this)"
                                            {{$a->sent != null ? 'checked' : ''}}>
                                    </td>

                                    <td class="text-center">
                                        <input type="checkbox"
                                            name="paid~{{$a->id}}"
                                            id="paid~{{$a->id}}"
                                            onclick="checkboxClick(this)"
                                            {{$a->paid != null ? 'checked' : ''}}>
                                    </td>

                                    <td>
                                        <input type="text"
                                            class="form-control form-control-sm"
                                            style="width:120px"
                                            name="remarks~{{$a->id}}"
                                            id="remarks~{{$a->id}}"
                                            value="{{$a->remarks ?? ''}}"
                                            onchange="saveData(this)">
                                    </td>

                                    <td class="text-center">
                                        <button type="button"
                                            class="btn btn-sm btn-link text-danger p-0"
                                            onclick="if(confirm('Are you sure you want to delete?')){
                                                window.location.href='{{ route('account_month.destroy_specific_acc',$a) }}'
                                            }">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>

                                </tr>
                                <?php $index++; ?>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    <!-- 🔥 End Responsive Wrapper -->

                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>

<script>
function saveData(data){
    var value = data.value;
    if(value == ""){
        value = 'z';
    }

    $.ajax({
        url: "{{ url('/account_month/update') }}/" + data.name + "/" + value,
        method: 'GET',
        success: function(response) {
            document.getElementById(response.column_name).value = response.total;
        }
    });
}

function checkboxClick(data){
    var check = document.getElementById(data.name).checked ? "yes" : "no";

    $.ajax({
        url: "{{ url('/account_month/update') }}/" + data.name + "/" + check,
        method: 'GET',
        success: function(response) {
            if(response.account.paid != null){
                document.getElementById(response.column_name).style.backgroundColor = 'lightgreen';
            }
        }
    });
}
</script>

@endsection

@section('scripts')
@endsection