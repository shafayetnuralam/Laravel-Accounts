
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
              <h1 class="m-0"> Receive View Last 100 Entrys</h1>

            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><button class="btn btn-success" data-toggle="modal" data-target="#modal-default1" data-backdrop='static' data-keyboard='false'
                  data-whatever="Receive">Add New</button></li>
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('added') }}">Added Menu</a></li>
                  <li class="breadcrumb-item active">Receive View</li>
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
          <div class="card card-default">

            <div class="card">
    
              <!-- /.card-header -->
              <div class="card-body">
            
                @include('ReceiveList')
               
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!--/. container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <div class="modal fade" id="modal-default1" role="dialog">
      <div class="modal-dialog modal-xl">

        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> Receive Add </h4>

          </div>
          <div class="modal-body">

            <div class="dash">
              <!-- Content goes in here -->
            </div>

          </div>

        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete the Receive Invoice"<strong id="deleteReceiveName"></strong>"?</p>
            <!-- <p class="text-danger">This action cannot be undone.</p> -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
          </div>
        </div>
      </div>
    </div>


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


  </div>
</body>
<script>
  $('#receiveView').DataTable({
    "fnCreatedRow": function(nRow, aData, iDataIndex) {
      $(nRow).attr('id', aData[0]);
    },
    'serverSide': true,
    'processing': true,
    'responsive': true,
    'paging': true,
    'order': [],
    'ajax': {
      'url': "{{ route('receives.data') }}",
      'type': 'post',
      'headers': {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    },
    "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [0, 8]
    }]
  });

  let currentModalId = null;

  // Handle edit button click
  $('#receiveView').on('click', '.edit-btn', function() {
    const id = $(this).data('id');
    currentModalId = id;
    $('#modal-default1').modal('show');
  });

  // Handle delete button click
  $('#receiveView').on('click', '.delete-btn', function() {
    const id = $(this).data('id');
    const row = $(this).closest('tr');
    const invoiceNo = row.find('td:nth-child(2)').text(); // Assuming invoice_no is in second column
    confirmDelete(id, invoiceNo);
  });

  
  // Function to show delete confirmation
  window.confirmDelete = function(id, name) {
    $('#deleteReceiveName').text(name);
    $('#deleteModal').modal('show');
    $('#confirmDelete').data('id', id);
  };

  // Handle delete confirmation
  $('#confirmDelete').click(function() {
    const id = $(this).data('id');
    $.ajax({
      url: "{{ route('receives.destroy', ':id') }}".replace(':id', id),
      type: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response) {
        toastr.success('Receive deleted successfully!');
        $('#deleteModal').modal('hide');
        $('#receiveView').DataTable().ajax.reload();
      },
      error: function(xhr) {
        let errorMessage = 'An error occurred while deleting the receive.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMessage = xhr.responseJSON.message;
        }
        toastr.error(errorMessage);
      }
    });
  });

  //Receive Add
      $('#modal-default1').on('show.bs.modal', function (event) {
        var button = event.relatedTarget ? $(event.relatedTarget) : null; // Button that triggered the modal
        var ID = button && button.data('whatever') ? button.data('whatever') : currentModalId; // Use currentModalId if no button
        currentModalId = null; // Reset
        var modal = $(this);
        var dataString = 'id=' + ID;
        modal.find('.dash').html('');

        if(ID =='Receive'){

          modal.find('.modal-title').text('Receive Add');
       
        $.ajax({
          type: "GET",
          url: "{{ route('receives.create') }}",
          cache: false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (data) {
            console.log(data);
            modal.find('.dash').html(data);
            
            // Fetch last invoice number for new receives
            $.ajax({
              url: "{{ route('receives.getLastInvoice') }}",
              type: 'GET',
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(response) {
                $('#invoice_no').val(response.last_invoice_no);
              },
              error: function(xhr) {
                console.error('Error fetching last invoice number:', xhr);
              }
            });
          },
          error: function (err) {
            console.log(err);
          }
        });

      }else if (ID && ID !='Receive'){

          modal.find('.modal-title').text('Receive Update');
          $.ajax({
          type: "GET",
          url: "{{ route('receives.edit', ':id') }}".replace(':id', ID),
          cache: false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (data) {
            console.log(data);
            modal.find('.dash').html(data);
          },
          error: function (err) {
            console.log(err);
          }
        });
        }else{
          alert('No ID provided '+ID);
          // alert('Invalid ID');
        }

      });

    </script>

</html>
