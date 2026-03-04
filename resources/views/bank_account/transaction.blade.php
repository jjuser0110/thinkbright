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
        <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Bank Accounts Detail</span></h4>

        <div class="card">
            <div class="card-header flex-column flex-md-row" style="padding-bottom:0px;">
                <div class="head-label">
                    <h5 class="card-title mb-3">{{ $bankAccount->bank->name ?? '' }} - {{ $bankAccount->account_name }} ({{ $bankAccount->account_no }}) > Transactions</h5>
                </div>
                <button class="btn btn-sm btn-success" onclick="openTransactionModal('deposit', {{ $bankAccount->id }}, '{{ $bankAccount->bank->name ?? '' }}', '{{ $bankAccount->account_name ?? '' }}', '{{ $bankAccount->account_no ?? '' }}')">
                    Deposit
                </button>
                <button class="btn btn-sm btn-danger" onclick="openTransactionModal('withdraw', {{ $bankAccount->id }}, '{{ $bankAccount->bank->name ?? '' }}', '{{ $bankAccount->account_name ?? '' }}', '{{ $bankAccount->account_no ?? '' }}')">
                    Withdraw
                </button>
            </div>
            <div class="row">
              <div class="col-12">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Date</th>
                  <th>Description</th>
                  <th>Amount (RM)</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($bankAccount->transactions as $transaction)
                  <tr>
                    <td>{{ $transaction->date }}</td>
                    <td>{{ $transaction->description }}<br>
                        <span class="text-small"><i>{{ $transaction->remarks }}</i></span>

                    </td>
                    <td style="text-align: right;">
                        @if (in_array($transaction->type, ['capital', 'deposit']))
                            <span class="text-success">{{ $transaction->amount }}</span>
                        @else
                            <span class="text-danger">{{ $transaction->amount }}</span>
                        @endif
                    </td>
                    <td>
                        <a style="text-decoration: none; color: inherit;" onclick="openTransactionModal('{{ $transaction->type }}', {{ $bankAccount->id }}, '{{ $bankAccount->bank->name ?? '' }}', '{{ $bankAccount->account_name ?? '' }}', '{{ $bankAccount->account_no ?? '' }}', {{ $transaction->id }}, {{ $transaction->amount }}, '{{ $transaction->date }}', '{{ $transaction->remarks }}')" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        &nbsp;&nbsp;
                        @if(Auth::user()->role == "superadmin")
                            <button type="button" style="background: none; padding: 0px; border: none; color: inherit;" onclick="if(confirm('Are you sure you want to delete?')){ window.location.href='{{ route('bank_account.transaction.destroy', $transaction) }}' }"><i class="fas fa-trash-alt"></i></button>
                        @endif
                    </td>
                  </tr>
                  @endforeach
              </tbody>
              <tfoot>
                <td colspan="2"></td>
                <td style="text-align: right;"><strong>{{ $bankAccount->amount }}</strong></td>
                <td>
                    <a style="text-decoration: none; color: inherit;" href="{{ route('bank_account.recalculate', $bankAccount) }}" title="Recalculate">
                        <i class="fas fa-refresh"></i>
                    </a>
                </td>
              </tfoot>
              </table>
            </div>
          </div>
        </div>
    </div>
    <!-- / Content -->
    @include('bank_account.transaction_modal')

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
<script>
    function openTransactionModal(type, bankAccountId, bankName, accountName, accountNo, transactionId = null, amount = null, date = null, remarks = null) {
        $('#bankAccountId').val(bankAccountId);
        $('#bankName').val(bankName);
        $('#accountName').val(accountName);
        $('#accountNo').val(accountNo);
        let actionUrl = type === 'deposit' ? "{{ route('bank_account.transaction.deposit') }}" : "{{ route('bank_account.transaction.withdraw') }}";
        let buttonLabel = type === 'deposit' ? 'Deposit' : 'Withdraw';

        if (transactionId !== null) {
            $('#transactionId').val(transactionId);
            actionUrl = "{{ route('bank_account.transaction.update') }}";
            buttonLabel = 'Update';
        }
        if (amount !== null) {
            let positiveAmount = Math.abs(amount);
            $('#amount').val(positiveAmount);
        }
        if (date !== null) {
            $('#date').val(date);
        }
        if (remarks !== null) {
            $('#remarks').val(remarks);
        }

        $('#transactionForm').attr('action', actionUrl);
        $('#transactionSubmitBtn').text(buttonLabel);

        $('#transactionModalLabel').text(buttonLabel);
        $('#transactionModal').modal('show');
    }
</script>
    @endsection

