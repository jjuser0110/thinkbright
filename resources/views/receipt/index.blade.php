@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@section('body')
<h4 class="font-weight-bolder mb-0">Receipt</h4>
<div class="row" style="margin-top:20px">
    <div class="card">
      <div class="card-body p-3">
          
        <form class="form-inline" method="GET">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-xs-6">
    				<input type="month" class="form-control" name="month_filter" value="{{$month_filter??''}}">
        		</div>
        		<div class="col-lg-3 col-md-6 col-xs-6">
    				<button class="btn" type="submit">Search</button>
        		</div>
    		</div>
		</form>
        <div class="row">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th >Name</th>
                  <th >Month</th>
                  <th >Year</th>
                  <th >Total</th>
                  <th >Latest Print</th>
                  <th >Print Count</th>
                  <th ></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($account as $a)
                  <tr>
                    <td>{{$a->student->name ??""}}</td>
                    <td>{{$a->month->month_name ??""}}</td>
                    <td>{{$a->month->year ??""}}</td>
                    <td>{{$a->total ??""}}</td>
                    <td>{{$a->print_record->created_at ??""}}</td>
                    <td>{{$a->print_records->count() ??""}}</td>
                    <td>
                      <button style="text-decoration: none; color: inherit;"  onclick="openModal({{$a}})">
                      <i class="fa-solid fa-print"></i>
                      </button>
                        
                    </td>
                  </tr>
                  @endforeach
              </tbody>  
            </table>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" onclick="closeModal()">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="text" name="account_id" id="account_id" hidden>
                <input type="checkbox" onClick="toggle(this)" value="select_all"/> Select All<br/>
                <input type="checkbox"  name="selected_field[]"  value="tuition"> Tuition <br>
                <input type="checkbox"  name="selected_field[]"  value="tuition_extra"> Tuition Extra<br>
                <input type="checkbox"  name="selected_field[]"  value="food"> Food <br>
                <input type="checkbox"  name="selected_field[]"  value="transport"> Transport <br>
                <input type="checkbox"  name="selected_field[]"  value="transport_extra"> Transport Extra <br>
                <input type="checkbox"  name="selected_field[]"  value="deposit"> Deposit <br>
                <input type="checkbox"  name="selected_field[]"  value="material"> Material <br>
                <input type="checkbox"  name="selected_field[]"  value="registration"> Registration <br>
                <input type="checkbox"  name="selected_field[]"  value="extra"> Extra <br>
                <input type="text" class="form-control" name="extra_desc" id="extra_desc" placeholder="Extra descriptions"><br>
                <input type="checkbox"  name="selected_field[]"  value="extra_2"> Extra_2 <br>
                <input type="text" class="form-control" name="extra_desc_2" id="extra_desc_2" placeholder="Extra descriptions 2" ><br>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                <button type="button" class="btn btn-primary" onclick="openPDF()">Save changes</button>
              </div>
            </div>
          </div>
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


    function openModal(data){
      $('#exampleModal').modal('show');
      document.getElementById("account_id").value=data.id;
    }
    function closeModal(){
      $('#exampleModal').modal('hide');
    }

    function toggle(source) {
      var  checkboxes = document.getElementsByName('selected_field[]');
      for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = source.checked;
      }
    }

    function openPDF(){
      var array = [];
      var checkboxes = document.querySelectorAll('input[type=checkbox]:checked');

      for (var i = 0; i < checkboxes.length; i++) {
        array.push(checkboxes[i].value);
      }
      var postData = {};
      postData.selected_field = array;
      postData.account_id = document.getElementById("account_id").value;
      postData.extra_desc = document.getElementById("extra_desc").value;
      postData.extra_desc_2 = document.getElementById("extra_desc_2").value;
      postData._token = "{{ csrf_token() }}";
      console.log(postData);
      $.ajax({
        url: "<?php echo route("receipt.pdfDetails") ?>",
        method: "POST",
        data: postData,
        success: function(response){
          console.log(response);
          pdf_generate(response);
        }
      });
    }

    
    var height = 20;
    function pdf_generate(data){
      console.log(data);
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
		  data.item.forEach(function (row) {
        doc.setFontType("normal");
        doc.text(21, height+=8, index.toFixed()+'.');
        doc.text(41, height, row.item_name);
        doc.text(190, height, row.cost.toFixed(2), null, null, 'right');
        index++;
      });
      index-=1;
      //footer
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
      
      // var string = doc.output('datauristring');
      // var iframe = "<iframe width='100%' id='iframe11' height='100%' src='" + string + "'></iframe>"
      // var x = window.open();
      // x.document.open();
      // x.document.write(iframe);
      // x.document.close(); 
      doc.save(data.student_name+'('+data.for+').pdf');
      //location.reload();
    }
  </script>