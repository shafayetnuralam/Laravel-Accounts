{{-- Account Insert Modal --}}
<div class="card-body">
  <form id="accountInsertForm">
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="col-form-label" for="accounts_name">Account Name</label>
          <input type="text" class="form-control" id="accounts_name" name="accounts_name"
                 placeholder="Enter Account Name" required>
          <div class="invalid-feedback">
            Account name is required.
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label class="col-form-label" for="sector_name">Sector Name</label>
          <input type="text" class="form-control" id="sector_name" name="sector_name"
                 placeholder="Enter Sector Name" required>
          <div class="invalid-feedback">
            Sector name is required.
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="col-form-label" for="mobile_no">Mobile Number</label>
          <input type="text" class="form-control" id="mobile_no" name="mobile_no"
                 placeholder="Enter Mobile Number" value="0" pattern="[0-9]{0,10,15}" >
          <div class="invalid-feedback">
            Please enter a valid mobile number (10-15 digits).
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label class="col-form-label" for="credit_limit">Credit Limit</label>
          <input type="text" class="form-control" id="credit_limit" name="credit_limit"
                 placeholder="Enter Credit Limit" value="0" required>
          <div class="invalid-feedback">
            Credit limit must be a positive number.
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="col-form-label" for="category">Category</label>
          <select id="category" name="category" class="form-control select2" required>
            <option value="">Select Category</option>
            <option value="Receive">Receive</option>
            <option value="Payment">Payment</option>
            <option value="Both">Both</option>
           
          </select>
          <div class="invalid-feedback">
            Please select a category.
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label class="col-form-label" for="opening_balance">Opening Balance</label>
          <input type="text" class="form-control" id="opening_balance" name="opening_balance"
                 placeholder="Enter Opening Balance" value="0" required>
          <div class="invalid-feedback">
            Opening balance is required.
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="col-form-label" for="Status">Status</label>
          <select id="Status" name="Status" class="form-control" required>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
          </select>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  <button type="button" id="saveAccountBtn" class="btn btn-success">
    <i class="fas fa-save"></i> Save Account
  </button>
</div>

<script>
$(document).ready(function() {
  // Initialize Select2
  $('.select2').select2({
    allowClear: false,
    theme: 'bootstrap4',
    placeholder: 'Select an option'
  });

  // Check for duplicate account name + sector name
  function checkDuplicate() {
    const accountsName = $('#accounts_name').val().trim();
    const sectorName = $('#sector_name').val().trim();

    if (accountsName && sectorName) {
      // Remove previous duplicate error
      $('#accounts_name').removeClass('is-invalid');
      $('.duplicate-error').remove();

      $.ajax({
        url: "{{ route('accounts.check-duplicate') }}",
        type: 'POST',
        data: {
          accounts_name: accountsName,
          sector_name: sectorName,
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          if (response.exists) {
            $('#accounts_name').addClass('is-invalid');
            if (!$('.duplicate-error').length) {
              $('#accounts_name').after('<div class="invalid-feedback duplicate-error">An account with this name already exists in the selected sector.</div>');
            }
          }
        }
      });
    }
  }

  // Form validation
  function validateForm() {
    let isValid = true;
    const requiredFields = ['accounts_name', 'sector_name', 'mobile_no', 'credit_limit', 'category', 'opening_balance', 'Status'];

    requiredFields.forEach(field => {
      const element = $('#' + field);
      const value = element.val().trim();

      if (!value) {
        element.addClass('is-invalid');
        isValid = false;
      } else {
        element.removeClass('is-invalid');

        // // Additional validation for mobile number
        // if (field === 'mobile_no' && !/^[0-9]{10,15}$/.test(value)) {
        //   element.addClass('is-invalid');
        //   isValid = false;
        // }

        // Additional validation for credit limit
        if (field === 'credit_limit' && (isNaN(value) || parseFloat(value) < 0)) {
          element.addClass('is-invalid');
          isValid = false;
        }
      }
    });

    return isValid;
  }

  // Save account function
  window.saveAccount = function() {
    // Check for duplicate errors before submitting
    if ($('.duplicate-error').length > 0) {
      toastr.error('Please fix the duplicate account error before saving.');
      return;
    }

    if (!validateForm()) {
      toastr.error('Please fill in all required fields correctly.');
      return;
    }

    const formData = new FormData(document.getElementById('accountInsertForm'));
    const accountData = {
      accounts_name: $('#accounts_name').val().trim(),
      sector_name: $('#sector_name').val().trim(),
      mobile_no: $('#mobile_no').val().trim(),
      credit_limit: parseFloat($('#credit_limit').val()),
      category: $('#category').val(),
      opening_balance: parseFloat($('#opening_balance').val()),
      Status: $('#Status').val()
    };

    $('#saveAccountBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

    $.ajax({
      url: "{{ route('accounts.store') }}",
      type: 'POST',
      data: accountData,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response) {
        toastr.success('Account created successfully!');
        $('#modal-default1').modal('hide');
        $('#accountsView').DataTable().ajax.reload();

        // Reset form
        $('#accountInsertForm')[0].reset();
        $('.select2').val(null).trigger('change');
      },
      error: function(xhr) {
        let errorMessage = 'An error occurred while saving the account.';

        if (xhr.responseJSON && xhr.responseJSON.errors) {
          const errors = Object.values(xhr.responseJSON.errors).flat();
          errorMessage = errors.join('<br>');
        } else if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMessage = xhr.responseJSON.message;
        }

        toastr.error(errorMessage);
      },
      complete: function() {
        $('#saveAccountBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Save Account');
      }
    });
  };

  // Bind save button click
  $('#saveAccountBtn').click(function() {
    saveAccount();
  });

  // Form input validation on keyup
  $('#accountInsertForm input, #accountInsertForm select').on('keyup change', function() {
    const field = $(this);
    const value = field.val().trim();

    if (field.prop('required') && !value) {
      field.addClass('is-invalid');
    } else {
      field.removeClass('is-invalid');

      // Specific validations
      if (field.attr('id') === 'mobile_no' && value && !/^[0-9]{10,15}$/.test(value)) {
        field.addClass('is-invalid');
      }

      if (field.attr('id') === 'credit_limit' && value && (isNaN(value) || parseFloat(value) < 0)) {
        field.addClass('is-invalid');
      }
    }

    // Check for duplicates when account name or sector name changes
    if (field.attr('id') === 'accounts_name' || field.attr('id') === 'sector_name') {
      // Debounce the duplicate check
      clearTimeout(window.duplicateCheckTimeout);
      window.duplicateCheckTimeout = setTimeout(checkDuplicate, 500);
    }
  });
});
</script>