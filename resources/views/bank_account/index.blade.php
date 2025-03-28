@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@section('body')
<h4 class="font-weight-bolder mb-0">Bank Accounts</h4>
<div class="row" style="margin-top:20px">
    <div class="card">
      <div class="card-body p-3">
      <button class="btn btn-sm btn-primary" style="margin-right:10px" onclick="window.location.href='{{ route('bank_account.create') }}'"><i class="mdi mdi-plus-circle-outline"></i>Add Bank Account</button>

        <div class="row">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Bank Name</th>
                  <th>Account Name</th>
                  <th>Account No</th>
                  <th>Amount</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($bankAccounts as $bankAccount)
                  <tr>
                    <td>{{ $bankAccount->bank->name ?? "" }}</td>
                    <td>{{ $bankAccount->account_name ?? "" }}</td>
                    <td>{{ $bankAccount->account_no ?? "" }}</td>
                    <td>{{ $bankAccount->amount ?? "" }}</td>
                    <td>
                        <button class="btn btn-sm btn-success" onclick="openTransactionModal('deposit', {{ $bankAccount->id }}, '{{ $bankAccount->bank->name ?? '' }}', '{{ $bankAccount->account_name ?? '' }}', '{{ $bankAccount->account_no ?? '' }}')">
                            Deposit
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="openTransactionModal('withdraw', {{ $bankAccount->id }}, '{{ $bankAccount->bank->name ?? '' }}', '{{ $bankAccount->account_name ?? '' }}', '{{ $bankAccount->account_no ?? '' }}')">
                            Withdraw
                        </button>
                        <button class="btn btn-sm btn-primary" onclick="window.location.href='{{ route('bank_account.transaction', $bankAccount) }}'">View Log</button>
                    </td>
                    <td>
                      <a style="text-decoration: none; color: inherit;" href="{{ route('bank_account.edit', $bankAccount) }}" title="Edit">
                        <i class="fas fa-pencil-alt"></i>
                      </a>
                      &nbsp;&nbsp;
                      @if(Auth::user()->role == "superadmin")
                        <button type="button" style="background: none; padding: 0px; border: none; color: inherit;" onclick="if(confirm('Are you sure you want to delete?')){ window.location.href='{{ route('bank_account.destroy', $bankAccount) }}' }"><i class="fas fa-trash-alt"></i></button>
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

@include('bank_account.transaction_modal')

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
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
<script>
    function openTransactionModal(type, bankAccountId, bankName, accountName, accountNo) {
        $('#bankAccountId').val(bankAccountId);
        $('#bankName').val(bankName);
        $('#accountName').val(accountName);
        $('#accountNo').val(accountNo);

        let actionUrl = type === 'deposit' ? "{{ route('bank_account.transaction.deposit') }}" : "{{ route('bank_account.transaction.withdraw') }}";
        $('#transactionForm').attr('action', actionUrl);

        let buttonLabel = type === 'deposit' ? 'Deposit' : 'Withdraw';
        $('#transactionSubmitBtn').text(buttonLabel);

        $('#transactionModalLabel').text(buttonLabel);
        $('#transactionModal').modal('show');
    }
</script>
@endsection
