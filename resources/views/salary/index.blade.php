@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@section('body')
<h4 class="font-weight-bolder mb-0">Salary</h4>
<div class="row" style="margin-top:20px">
    <div class="card">
      <div class="card-body p-3">
      <button class="btn btn-sm btn-primary" style="margin-right:10px" onclick="window.location.href='{{ route('salary.create') }}'"><i class="mdi mdi-plus-circle-outline"></i>Add Salary</button>  
      
        <div class="row">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th >Teacher Name</th>
                  <th >Payment Month</th>
                  <th >Payment Date</th>
                  <th >Gross Pay</th>
                  <th >Deduction</th>
                  <th >Addition</th>
                  <th >Net Pay</th>
                  <th >Contribution</th>
                  <th >Total</th>
                  <th ></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($salary as $c)
                  <tr>
                    <td>{{$c->user->name ??""}}</td>
                    <td>{{$c->year_month ??""}}</td>
                    <td>{{$c->payment_date ??""}}</td>
                    <td>{{$c->gross_pay ??""}}</td>
                    <td>{{$c->total_deduction ??""}}</td>
                    <td>{{$c->total_additions ??""}}</td>
                    <td>{{$c->net_pay ??""}}</td>
                    <td>{{$c->total_contribution ??""}}</td>
                    <td>{{$c->employer_total_paid ??""}}</td>
                    <td>
                      <a style="text-decoration: none; color: inherit;" href="{{ route('salary.edit',$c) }}" title="Edit">
                        <i class="fas fa-pencil-alt"></i>
                      </a>
                      &nbsp;&nbsp;
                        <button type="button" style="background: none; padding: 0px; border: none; color: inherit;" onclick="if(confirm('Are you sure you want to delete?')){ window.location.href='{{ route('salary.destroy',$c) }}' }"><i class="fas fa-trash-alt"></i></button>
                        
                      &nbsp;&nbsp;
                      <button style="text-decoration: none; color: inherit;"  onclick="openPDF({{$c}})">
                      <i class="fa fa-file-pdf-o"></i>
                      </button>
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

    function openPDF(data){
      
      var postData = {};
      postData.salary_id = data.id;
      postData._token = "{{ csrf_token() }}";
      console.log(postData);
      $.ajax({
        url: "<?php echo route("salary.pdfDetails") ?>",
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
      var total_gross = 0;
      var total_deduction = 0;
      var total_pay = 0;
      console.log(data);
      height = 20;
      var doc = new jsPDF("p", "mm", "a4");
      doc.setFontSize("15");
      doc.setFontType("bold");
      doc.text(105, height, "PUSAT TUISYEN PRESTIJ", null, null, 'center');
      doc.setFontSize("10");
      doc.setFontType("normal");
      doc.text(105, height+=4, "Level 2 & 3, No. 58,", null, null, 'center');
      doc.text(105, height+=4, "Block C2, Saradise Kuching,", null, null, 'center');
      doc.text(105, height+=4, "93350 Kuching,", null, null, 'center');
      doc.text(105, height+=4, "Sarawak, Malaysia", null, null, 'center');
      doc.text(105, height+=4, "Contact : 017-861 8018, 012-895 0818", null, null, 'center');
      doc.setFontSize("18");
      doc.setFontType("bold");
      doc.text(20, height+=18, "Pay Slip", null, null);
      doc.setFontSize("12");
      doc.text(190, height, "Pay Day", null, null,'right');
      doc.setFontType("normal");
      doc.text(190, height+=5, data.payment_date, null, null,'right');
      doc.text(20, height+=5, data.user.name, null, null);
      doc.text(20, height+=5, data.user.ic, null, null);
      
      doc.setFontType("bold");
      doc.text(190, height-=3, "Pay Month", null, null,'right');
      doc.setFontType("normal");
      doc.text(190, height+=5, data.year_month, null, null,'right');

      right_hand_height = height + 20;
      left_hand_height = height+20;

      doc.setFontSize("14");
      doc.setFontType("bold");
      doc.text(20, right_hand_height, "Earnings", null, null, '');
      doc.text(150, right_hand_height, "Amount MYR", null, null, 'right');
      doc.setDrawColor(0);
      doc.line(20, right_hand_height+=2, 150, right_hand_height);
      doc.setFontSize("11");
      doc.setFontType("normal");
      if(data.basic>0){
        doc.text(20, right_hand_height+=5, "Basic", null, null, '');
        doc.text(150, right_hand_height, data.basic.toFixed(2), null, null, 'right');
      }
      if(data.overtime>0){
        doc.text(20, right_hand_height+=5, "OT", null, null, '');
        doc.text(150, right_hand_height, data.overtime.toFixed(2), null, null, 'right');
      }
      if(data.commission>0){
        doc.text(20, right_hand_height+=5, "Commissions", null, null, '');
        doc.text(150, right_hand_height, data.commission.toFixed(2), null, null, 'right');
      }
      if(data.allowances>0){
        doc.text(20, right_hand_height+=5, "Allowances", null, null, '');
        doc.text(150, right_hand_height, data.allowances.toFixed(2), null, null, 'right');
      }
      if(data.reimbursement>0){
        doc.text(20, right_hand_height+=5, "Reimbursement", null, null, '');
        doc.text(150, right_hand_height, data.reimbursement.toFixed(2), null, null, 'right');
      }
      if(data.extra>0){
        doc.text(20, right_hand_height+=5, "Extra", null, null, '');
        doc.text(150, right_hand_height, data.extra.toFixed(2), null, null, 'right');
      }

      doc.setDrawColor(0);
      doc.line(20, right_hand_height+=2, 150, right_hand_height);
      
      doc.setFontType("bold");
      if(data.gross_pay>0 || data.total_additions>0){
        total_gross = data.gross_pay+ +data.total_additions;
        doc.text(20, right_hand_height+=5, "Total Earnings", null, null, '');
        doc.text(150, right_hand_height, total_gross.toFixed(2), null, null, 'right');
      }

      
      doc.setFontSize("14");
      doc.setFontType("bold");
      doc.text(20, right_hand_height+=20, "Deductions", null, null, '');
      doc.text(150, right_hand_height, "Amount MYR", null, null, 'right');
      doc.setDrawColor(0);
      doc.line(20, right_hand_height+=2, 150, right_hand_height);
      doc.setFontSize("11");
      doc.setFontType("normal");
      if(data.epf>0){
        doc.text(20, right_hand_height+=5, "EPF", null, null, '');
        doc.text(150, right_hand_height, data.epf.toFixed(2), null, null, 'right');
      }
      if(data.socso>0){
        doc.text(20, right_hand_height+=5, "Socso", null, null, '');
        doc.text(150, right_hand_height, data.socso.toFixed(2), null, null, 'right');
      }
      if(data.advance>0){
        doc.text(20, right_hand_height+=5, "Advance", null, null, '');
        doc.text(150, right_hand_height, data.advance.toFixed(2), null, null, 'right');
      }
      if(data.income_tax>0){
        doc.text(20, right_hand_height+=5, "PCB", null, null, '');
        doc.text(150, right_hand_height, data.income_tax.toFixed(2), null, null, 'right');
      }
      if(data.employee_s_p>0){
        doc.text(20, right_hand_height+=5, "SIP Contribution", null, null, '');
        doc.text(150, right_hand_height, data.employee_s_p.toFixed(2), null, null, 'right');
      }
      doc.setFontType("bold");
      doc.setDrawColor(0);
      doc.line(20, right_hand_height+=2, 150, right_hand_height);
      if(data.total_deduction>0){
        total_deduction = data.total_deduction;
        doc.text(20, right_hand_height+=5, "Total Deductions", null, null, '');
        doc.text(150, right_hand_height, data.total_deduction.toFixed(2), null, null, 'right');
      }

      doc.setFontSize("14");
      doc.setFontType("normal");
      doc.setDrawColor(0);
      doc.line(20, right_hand_height+=15, 150, right_hand_height);
      doc.text(20, right_hand_height+=8, "TAKE HOME PAY", null, null, '');
      doc.text(150, right_hand_height, data.net_pay.toFixed(2), null, null, 'right');
      doc.setDrawColor(0);
      doc.line(20, right_hand_height+=5, 150, right_hand_height);
      doc.setFontSize("11");


      
      if(data.employer_epf>0){
        doc.text(20, right_hand_height+=15, "Employers Provident Fund", null, null, '');
        doc.text(150, right_hand_height, data.employer_epf.toFixed(2), null, null, 'right');
        doc.setDrawColor(0.5);
        doc.line(20, right_hand_height+=2, 150, right_hand_height);
      }
      if(data.employer_socso>0){
        doc.text(20, right_hand_height+=6, "Socso (Employer)", null, null, '');
        doc.text(150, right_hand_height, data.employer_socso.toFixed(2), null, null, 'right');
        doc.setDrawColor(0.5);
        doc.line(20, right_hand_height+=2, 150, right_hand_height);
      }
      if(data.employer_s_p>0){
        doc.text(20, right_hand_height+=6, "SIP Employer's Contribution", null, null, '');
        doc.text(150, right_hand_height, data.employer_s_p.toFixed(2), null, null, 'right');
        doc.setDrawColor(0.5);
        doc.line(20, right_hand_height+=2, 150, right_hand_height);
      }
      // doc.setFontType("normal");
      // doc.text(80, height, ":    "+data.receipt_no, null, null, '');
      // doc.setFontType("bold");
      // doc.text(20, height+=8, "Receipt Date", null, null, '');
      // doc.setFontType("normal");
      // doc.text(80, height, ":    "+data.date_print, null, null, '');
      // doc.setFontType("bold");
      // doc.text(20, height+=8, "Received From", null, null, '');
      // doc.setFontType("normal");
      // doc.text(80, height, ":    "+data.student_name, null, null, '');
      // doc.setFontType("bold");
      // doc.text(20, height+=8, "For", null, null, '');
      // doc.setFontType("normal");
      // doc.text(80, height, ":    "+data.for, null, null, '');
      
      // doc.setDrawColor(0);
      // doc.setFontSize("10");
      // doc.setFontType("bold");
      // doc.line(20, height+=10, 191, height);
      // doc.text(21, height+=7, 'No.');
      // doc.text(41, height, 'Item');
      // doc.text(190, height, 'Amount (RM)', null, null, 'right');
      // doc.line(20, height+=6, 191, height);
      // var index = 1;
		  // data.item.forEach(function (row) {
      //   doc.setFontType("normal");
      //   doc.text(21, height+=8, index.toFixed()+'.');
      //   doc.text(41, height, row.item_name);
      //   doc.text(190, height, row.cost.toFixed(2), null, null, 'right');
      //   index++;
      // });
      // index-=1;
      //footer
      // height = 225;
      // doc.setFontSize("10");
      // doc.setFontType("bold");
      // doc.text(21, height, data.total_english);
      // doc.line(20, height+=2, 191, height);
      // doc.line(20, height+=1, 191, height);
      // doc.setFontSize("12");
      // doc.text(21, height+=6, 'Item Total :  ' + index.toFixed());
      // doc.text(155, height, "Subtotal :", null, null, 'right');
      // doc.text(190, height, "RM "+ data.total.toFixed(2), null, null, 'right');
      // doc.line(135, height+=2, 191, height);
      // doc.line(135, height+=1, 191, height);
      // doc.setFontSize("10");
      // doc.text(21, 280, "This is computer generated receipt no signature required.");
      
      // var string = doc.output('datauristring');
      // var iframe = "<iframe width='100%' id='iframe11' height='100%' src='" + string + "'></iframe>"
      // var x = window.open();
      // x.document.open();
      // x.document.write(iframe);
      // x.document.close(); 
      doc.save(data.user.name+'('+data.year_month+').pdf');
      //location.reload();
    }
  </script>