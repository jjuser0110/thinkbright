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

                    <!-- Responsive Scroll Wrapper -->
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
                                    <th class="text-center">Receipt</th>
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

                                    <td class="text-center">
                                        <button type="button"
                                            id="print~{{$a->id}}"
                                            class="btn btn-sm btn-link p-0 {{ ($a->sent != null && $a->paid != null) ? 'text-primary' : 'text-secondary' }}"
                                            title="Print Receipt"
                                            style="{{ ($a->sent != null && $a->paid != null) ? '' : 'pointer-events:none; opacity:0.35;' }}"
                                            onclick="openModal({{$a}})">
                                            <i class="fas fa-print"></i>
                                        </button>
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
                    <!-- End Responsive Wrapper -->

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="receiptModalLabel">Print Receipt</h5>
                <button type="button" class="close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="text" name="account_id" id="account_id" hidden>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" onclick="toggle(this)" value="select_all" id="select_all">
                    <label class="form-check-label"><strong>Select All</strong></label>
                </div>

                <div class="form-check mb-1">
                    <input class="form-check-input" type="checkbox" name="selected_field[]" value="tuition" id="tuition">
                    <label class="form-check-label">Tuition</label>
                </div>
                <input type="text" class="form-control form-control-sm mb-3" name="tuition_desc" id="tuition_desc" placeholder="Tuition description">

                <div class="form-check mb-1">
                    <input class="form-check-input" type="checkbox" name="selected_field[]" value="tuition_extra" id="tuition_extra">
                    <label class="form-check-label">Tuition Extra</label>
                </div>
                <input type="text" class="form-control form-control-sm mb-3" name="tuition_extra_desc" id="tuition_extra_desc" placeholder="Tuition extra description">

                <div class="form-check mb-1">
                    <input class="form-check-input" type="checkbox" name="selected_field[]" value="food" id="food">
                    <label class="form-check-label">Food</label>
                </div>
                <input type="text" class="form-control form-control-sm mb-3" name="food_desc" id="food_desc" placeholder="Food description">

                <div class="form-check mb-1">
                    <input class="form-check-input" type="checkbox" name="selected_field[]" value="transport" id="transport">
                    <label class="form-check-label">Transport</label>
                </div>
                <input type="text" class="form-control form-control-sm mb-3" name="transport_desc" id="transport_desc" placeholder="Transport description">

                <div class="form-check mb-1">
                    <input class="form-check-input" type="checkbox" name="selected_field[]" value="transport_extra" id="transport_extra">
                    <label class="form-check-label">Transport Extra</label>
                </div>
                <input type="text" class="form-control form-control-sm mb-3" name="transport_extra_desc" id="transport_extra_desc" placeholder="Transport extra description">

                <div class="form-check mb-1">
                    <input class="form-check-input" type="checkbox" name="selected_field[]" value="deposit" id="deposit">
                    <label class="form-check-label">Deposit</label>
                </div>
                <input type="text" class="form-control form-control-sm mb-3" name="deposit_desc" id="deposit_desc" placeholder="Deposit description">

                <div class="form-check mb-1">
                    <input class="form-check-input" type="checkbox" name="selected_field[]" value="material" id="material">
                    <label class="form-check-label">Material</label>
                </div>
                <input type="text" class="form-control form-control-sm mb-3" name="material_desc" id="material_desc" placeholder="Material description">

                <div class="form-check mb-1">
                    <input class="form-check-input" type="checkbox" name="selected_field[]" value="registration" id="registration">
                    <label class="form-check-label">Registration</label>
                </div>
                <input type="text" class="form-control form-control-sm mb-3" name="registration_desc" id="registration_desc" placeholder="Registration description">

                <div class="form-check mb-1">
                    <input class="form-check-input" type="checkbox" name="selected_field[]" value="extra" id="extra">
                    <label class="form-check-label">Extra</label>
                </div>
                <input type="text" class="form-control form-control-sm mb-3" name="extra_desc" id="extra_desc" placeholder="Extra description">

                <div class="form-check mb-1">
                    <input class="form-check-input" type="checkbox" name="selected_field[]" value="extra_2" id="extra_2">
                    <label class="form-check-label">Extra 2</label>
                </div>
                <input type="text" class="form-control form-control-sm mb-3" name="extra_desc_2" id="extra_desc_2" placeholder="Extra 2 description">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                <button type="button" class="btn btn-primary" onclick="openPDF()">
                    <i class="fas fa-print me-1"></i> Print PDF
                </button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

<script>
// ─── Existing save/checkbox functions ───────────────────────────────────────

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

            // Extract account id from field name e.g. "sent~12" -> "12"
            var id = data.name.split('~')[1];
            var sentChecked  = document.getElementById('sent~' + id).checked;
            var paidChecked  = document.getElementById('paid~' + id).checked;
            var printBtn     = document.getElementById('print~' + id);

            if(sentChecked && paidChecked){
                printBtn.classList.remove('text-secondary');
                printBtn.classList.add('text-primary');
                printBtn.style.pointerEvents = 'auto';
                printBtn.style.opacity = '1';
            } else {
                printBtn.classList.remove('text-primary');
                printBtn.classList.add('text-secondary');
                printBtn.style.pointerEvents = 'none';
                printBtn.style.opacity = '0.35';
            }
        }
    });
}

// ─── Receipt / Print functions ───────────────────────────────────────────────

function openModal(data){
    // Reset all checkboxes and text fields each time modal opens
    var checkboxes = document.getElementsByName('selected_field[]');
    for(var i = 0; i < checkboxes.length; i++){
        checkboxes[i].checked = false;
    }
    var textFields = document.querySelectorAll('#receiptModal input[type=text]:not([hidden])');
    textFields.forEach(function(f){ f.value = ''; });

    document.getElementById("account_id").value = data.id;
    $('#receiptModal').modal('show');
}

function closeModal(){
    $('#receiptModal').modal('hide');
}

function toggle(source){
    var checkboxes = document.getElementsByName('selected_field[]');
    for(var i = 0, n = checkboxes.length; i < n; i++){
        checkboxes[i].checked = source.checked;
    }
}

function openPDF(){
    var array = [];
    var checkboxes = document.querySelectorAll('input[name="selected_field[]"]:checked');

    for(var i = 0; i < checkboxes.length; i++){
        array.push(checkboxes[i].value);
    }

    var postData = {};
    postData.selected_field        = array;
    postData.account_id            = document.getElementById("account_id").value;
    postData.tuition_desc          = document.getElementById("tuition_desc").value;
    postData.tuition_extra_desc    = document.getElementById("tuition_extra_desc").value;
    postData.food_desc             = document.getElementById("food_desc").value;
    postData.transport_desc        = document.getElementById("transport_desc").value;
    postData.transport_extra_desc  = document.getElementById("transport_extra_desc").value;
    postData.deposit_desc          = document.getElementById("deposit_desc").value;
    postData.material_desc         = document.getElementById("material_desc").value;
    postData.registration_desc     = document.getElementById("registration_desc").value;
    postData.extra_desc            = document.getElementById("extra_desc").value;
    postData.extra_desc_2          = document.getElementById("extra_desc_2").value;
    postData._token                = "{{ csrf_token() }}";

    $.ajax({
        url: "<?php echo route('receipt.pdfDetails') ?>",
        method: "POST",
        data: postData,
        success: function(response){
            pdf_generate(response);
        }
    });
}

var height = 20;
function pdf_generate(data){
    height = 20;
    var doc = new jsPDF("p", "mm", "a4");
    doc.setFontSize("15");
    doc.setFontType("bold");
    doc.text(105, height, "PUSAT TUISYEN THINK BRIGHT", null, null, 'center');
    doc.setFontSize("10");
    doc.setFontType("normal");
    doc.text(105, height+=4, "Level 2 & 3, No. 58,", null, null, 'center');
    doc.text(105, height+=4, "Block C2, Saradise Kuching,", null, null, 'center');
    doc.text(105, height+=4, "93350 Kuching,", null, null, 'center');
    doc.text(105, height+=4, "Sarawak, Malaysia", null, null, 'center');
    doc.text(105, height+=4, "Contact : 019-429 1906, 019-816 1906", null, null, 'center');
    doc.setFontSize("18");
    doc.setFontType("bold");
    doc.text(105, height+=18, "OFFICIAL RECEIPT", null, null, 'center');
    doc.setFontSize("12");
    doc.text(20, height+=13, "Receipt No", null, null, '');
    doc.setFontType("normal");
    doc.text(80, height, ":    "+data.receipt_no, null, null, '');
    doc.setFontType("bold");
    doc.text(20, height+=8, "Receipt Date", null, null, '');
    doc.setFontType("normal");
    doc.text(80, height, ":    "+data.date_print, null, null, '');
    doc.setFontType("bold");
    doc.text(20, height+=8, "Received From", null, null, '');
    doc.setFontType("normal");
    doc.text(80, height, ":    "+data.student_name, null, null, '');
    doc.setFontType("bold");
    doc.text(20, height+=8, "For", null, null, '');
    doc.setFontType("normal");
    doc.text(80, height, ":    "+data.for, null, null, '');

    doc.setDrawColor(0);
    doc.setFontSize("10");
    doc.setFontType("bold");
    doc.line(20, height+=10, 191, height);
    doc.text(21, height+=7, 'No.');
    doc.text(41, height, 'Item');
    doc.text(190, height, 'Amount (RM)', null, null, 'right');
    doc.line(20, height+=6, 191, height);

    var index = 1;
    data.item.forEach(function(row){
        doc.setFontType("normal");
        doc.text(21, height+=8, index.toFixed()+'.');
        doc.text(41, height, row.item_name);
        doc.text(190, height, row.cost.toFixed(2), null, null, 'right');
        index++;
    });
    index -= 1;

    // footer
    height = 225;
    doc.setFontSize("10");
    doc.setFontType("bold");
    doc.text(21, height, data.total_english);
    doc.line(20, height+=2, 191, height);
    doc.line(20, height+=1, 191, height);
    doc.setFontSize("12");
    doc.text(21, height+=6, 'Item Total :  ' + index.toFixed());
    doc.text(155, height, "Subtotal :", null, null, 'right');
    doc.text(190, height, "RM "+ data.total.toFixed(2), null, null, 'right');
    doc.line(135, height+=2, 191, height);
    doc.line(135, height+=1, 191, height);
    doc.setFontSize("10");
    doc.text(21, 280, "This is computer generated receipt no signature required.");

    doc.save(data.student_name+'('+data.for+').pdf');
}
</script>

@endsection

@section('scripts')
@endsection