<div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionModalLabel">Transaction</h5>
                <button type="button" class="close" onclick="$('#transactionModal').modal('hide');" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="transactionForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="bank_account_id" id="bankAccountId">
                    <input type="hidden" name="transaction_id" id="transactionId">
                    <div class="form-group">
                        <label for="bankName">Bank Name</label>
                        <input type="text" class="form-control" id="bankName" readonly>
                    </div>

                    <div class="form-group">
                        <label for="accountName">Account Name</label>
                        <input type="text" class="form-control" id="accountName" readonly>
                    </div>

                    <div class="form-group">
                        <label for="accountNo">Account Number</label>
                        <input type="text" class="form-control" id="accountNo" readonly>
                    </div>

                    <div class="form-group">
                        <label for="amount">Enter Amount</label>
                        <input type="number" class="form-control" name="amount" id="amount" required>
                    </div>

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" name="date" id="date" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" name="remarks" id="remarks"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="$('#transactionModal').modal('hide');">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="transactionSubmitBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
