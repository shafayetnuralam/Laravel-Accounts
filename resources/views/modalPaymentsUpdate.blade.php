{{-- Payment Update Modal --}}
@php
    $payment = isset($payment) ? $payment : null;
    $isUpdate = $payment !== null;
@endphp

{{-- Payment Update Modal --}}
<div class="card-body">
  <form id="paymentUpdateForm">
 @csrf
    @if($isUpdate)
    @method('PUT')
    @endif
    <input type="hidden" id="payment_id" name="payment_id" value="{{ $payment ? $payment->id : '' }}">
    <div class="row">
     
    <div class="col-md-6">
      <div class="form-group">
        <label class="col-form-label" for="accounts_id">Account Info</label>
        <select name="accounts_id" id="accounts_id" class="form-control select2" required 
          <option value="">Select Account info</option>

          <!-- Accounts will be loaded via AJAX -->
        </select>
        <div class="invalid-feedback">
          Account is required.
        </div>
      </div>
    </div>

      <div class="col-md-6">
        <div class="form-group">
          <label class="col-form-label" for="pay_mode">Pay Mode</label>
          <select id="pay_mode" name="pay_mode" class="form-control select2" required>
            <option value="">Select Pay Mode</option>
            <option value="Cash">Cash</option>
            <option value="Bank">Bank</option>
            <option value="Cheque">Cheque</option>
            <option value="Online">Online</option>
          </select>
          <div class="invalid-feedback">
            Pay mode is required.
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="col-form-label" for="amount">Amount</label>
          <input type="number" class="form-control" id="amount" name="amount" value="{{ $payment ? $payment->amount : '' }}"
                 placeholder="Enter Amount" step="0.01" min="0" required>
          <div class="invalid-feedback">
            Amount must be a positive number.
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label class="col-form-label" for="entry_date">Entry Date</label>
          <input type="date" class="form-control" id="entry_date" name="entry_date" value="{{ $payment ? $payment->entry_date : date('Y-m-d') }}" required>
          <div class="invalid-feedback">
            Entry date is required.
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="col-form-label" for="invoice_no">Invoice No</label>
          <input type="text" class="form-control" id="invoice_no" name="invoice_no"
                 placeholder="Enter Invoice Number" value="{{ $payment ? $payment->invoice_no : '' }}">
        </div>
      </div>

    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label class="col-form-label" for="remarks">Remarks</label>
          <textarea class="form-control" id="remarks" name="remarks" rows="3"
                    placeholder="Enter Remarks">{{ $payment ? $payment->remarks : '' }}</textarea>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  <button type="button" id="savePaymentBtn" class="btn btn-success">
    <i class="fas fa-save"></i> Save Payment
  </button>
</div>


<script>
$(document).ready(function() {
  const isUpdate = {{ $isUpdate ? 'true' : 'false' }};
  // Initialize Select2
  $('.select2').select2({
    allowClear: false,
    theme: 'bootstrap4',
    placeholder: 'Select an option'
  });

  // Fetch and populate accounts
  $.ajax({
    url: "{{ route('accounts.paymentInfo') }}",
    type: 'GET',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(response) {
      const accounts = response.data || response; // Adjust based on API response structure
      accounts.forEach(function(account) {
          $('#accounts_id').append('<option value="' + account.id + '">' + account.accounts_name + ' - ' + account.sector_name + ' (' + account.category + ')</option>');
      });

      // Populate fields if updating
      if (isUpdate) {
        $('#accounts_id').val('{{ $payment->accounts_id }}').trigger('change');
        $('#pay_mode').val('{{ $payment->pay_mode }}').trigger('change');
      }
    },
    error: function(xhr) {
      console.error('Error fetching accounts:', xhr);
      toastr.error('Failed to load accounts.');
    }
  });


  
  // Check for duplicate account name + sector name
  function checkDuplicate() {
    const invoice_no = $('#invoice_no').val().trim();
  

    if (invoice_no) {
      // Remove previous duplicate error
      $('#invoice_no').removeClass('is-invalid');
      $('.duplicate-error').remove();

      $.ajax({
        url: "{{ route('payments.check-duplicate') }}",
        type: 'POST',
        data: {
          invoice_no: invoice_no,
          payment_id: isUpdate ? '{{ $payment->id }}' : '',
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          if (response.exists) {
            $('#invoice_no').addClass('is-invalid');
            if (!$('.duplicate-error').length) {
              $('#invoice_no').after('<div class="invalid-feedback duplicate-error">This Invoice No already exists</div>');
            }
          }
        }
      });
    }
  }

  // Form validation
  function validateForm() {
    let isValid = true;
    const requiredFields = ['accounts_id', 'pay_mode', 'amount', 'entry_date'];

    requiredFields.forEach(field => {
      const element = $('#' + field);
      const value = element.val().trim();

      if (!value) {
        element.addClass('is-invalid');
        isValid = false;
      } else {
        element.removeClass('is-invalid');

        // Additional validation for amount
        if (field === 'amount' && (isNaN(value) || parseFloat(value) <= 0)) {
          element.addClass('is-invalid');
          isValid = false;
        }
      }
    });

    return isValid;
  }

  // Save payment function
  window.savePayment = function() {
    if (!validateForm()) {
      toastr.error('Please fill in all required fields correctly.');
      return;
    }

    const paymentData = {
      accounts_id: $('#accounts_id').val(),
      pay_mode: $('#pay_mode').val(),
      amount: parseFloat($('#amount').val()),
      entry_date: $('#entry_date').val(),
      invoice_no: $('#invoice_no').val().trim(),
      remarks: $('#remarks').val().trim()
    };

    $('#savePaymentBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

    $.ajax({
      url: isUpdate ? "{{ route('payments.update', $payment->id) }}" : "{{ route('payments.store') }}",
      type: 'POST',
      data: {
        ...paymentData,
        _method: isUpdate ? 'PUT' : 'POST'
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response) {
        toastr.success(isUpdate ? 'Payment updated successfully!' : 'Payment created successfully!');
        $('#modal-default1').modal('hide');
        $('#paymentView').DataTable().ajax.reload();

        // Reset form
        $('#paymentUpdateForm')[0].reset();
        $('.select2').val(null).trigger('change');
      },
      error: function(xhr) {
        let errorMessage = 'An error occurred while saving the payment.';

        if (xhr.responseJSON && xhr.responseJSON.errors) {
          const errors = Object.values(xhr.responseJSON.errors).flat();
          errorMessage = errors.join('<br>');
        } else if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMessage = xhr.responseJSON.message;
        }
        // Duplicate Check Error Handling
          if (xhr.responseJSON && xhr.responseJSON.exists) {
            errorMessage = xhr.responseJSON.message;
          }
        toastr.error(errorMessage);
      },
      complete: function() {
        $('#savePaymentBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Save Payment');
      }
    });
  };

  //Get Auto Generate Invoice Number



  // Bind save button click
  $('#savePaymentBtn').click(function() {
    savePayment();
  });

  // Form input validation on keyup
  $('#paymentUpdateForm input, #paymentUpdateForm select, #paymentUpdateForm textarea').on('keyup change', function() {
    const field = $(this);
    const value = field.val().trim();

    if (field.prop('required') && !value) {
      field.addClass('is-invalid');
    } else {
      field.removeClass('is-invalid');

      // Specific validations
      if (field.attr('id') === 'amount' && value && (isNaN(value) || parseFloat(value) <= 0)) {
        field.addClass('is-invalid');
      }

            window.duplicateCheckTimeout = setTimeout(checkDuplicate, 500);
    }
  });
});
</script>