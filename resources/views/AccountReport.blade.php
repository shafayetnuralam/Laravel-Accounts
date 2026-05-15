
<!DOCTYPE html>
<html lang="en">
 @include('header')
<body class="hold-transition layout-top-nav">
<div class="wrapper">


  <!-- Navbar -->
@include('navbar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Report Menu</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Report Menu</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
   
        <div class="container-fluid">
          <!-- Info boxes -->
          <form action="{{ route('AccountReportViewData') }}" method="get" target="_blank">
            <div class="card card-default">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                Challan Summary Report
                </h3>
             
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><span class="material-icons"
                              title="Required Field">error</span>Report Type </span>
                        </div>

                        <select class="form-control select2" name="type" required>
                          <option value="Summary Wise">Summary Wise</option>
                        </select>
                      </div>
                    </div>
                  </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><span class="material-icons"
                                    title="Required Field">error</span>Accounts Info</span>
                            </div>
                            <select class="form-control select2" id="accounts_id" name="accounts_id" required>
                                <option value="All">All Accounts</option>
                            </select>
                            </div>
                            </div>
                            </div>


                            

                </div>



                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">

                        <div class="input-group date" id="start_date" data-target-input="nearest">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><span class="material-icons"
                                title="Required Field">error</span>Start Date </span>
                          </div>
                          <input type="text" required class="form-control datetimepicker-input" name="start_date"
                            value="" data-target="#start_date"
                            data-toggle="datetimepicker" />

                        </div>
                      </div>
                    </div>
                  </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        <div class="input-group mb-3">

                            <div class="input-group date" id="end_date" data-target-input="nearest">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><span class="material-icons"
                                    title="Required Field">error</span>End Date</span>
                            </div>
                            <input type="text" required class="form-control datetimepicker-input" name="end_date"
                                value="" data-target="#end_date"
                                data-toggle="datetimepicker" />

                            </div>
                        </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                <div class="col-md-12">
                <input type="submit" class="btn btn-success float-right" name="submit" value="Search Data">
                </div>
                </div>

              </div>

            </div>
            <!-- /.row -->
            </form>

        </div>

    </div>
    <!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    @include('controlSidebar')
    </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
    @include('footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
 @include('RequiredFotterContext')

<script>
$(document).ready(function() {
  // Initialize Select2
  $('.select2').select2({
    allowClear: false,
    theme: 'bootstrap4',
    placeholder: 'Select an option'
  });

  // Fetch and populate accounts
  $.ajax({
    url: "{{ route('accounts.allAccountsInfo') }}",
    type: 'GET',
    // headers: {
    //   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    // },
    success: function(response) {
      const accounts = response.data || response; // Adjust based on API response structure
      accounts.forEach(function(account) {
        $('#accounts_id').append('<option value="' + account.id + '">' + account.accounts_name + ' - ' + account.sector_name + ' (' + account.category + ')</option>');
      });
    },
    error: function(xhr) {
      console.error('Error fetching accounts:', xhr);
      toastr.error('Failed to load accounts.');
    }
  });

});
</script>

</body>
</html>
