
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
              <h1 class="m-0"> Account Setup View</h1>

            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><button class="btn btn-success" data-toggle="modal" data-target="#modal-default1" data-backdrop='static' data-keyboard='false'
                  data-whatever="Account">Add New</button></li>
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('added') }}">Added Menu</a></li>
                  <li class="breadcrumb-item active">Account Setup View</li>
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
              <div class="card-body" id="LoadCart_list">
            
                @include('accountsList')
               
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
            <h4 class="modal-title"> Account Add </h4>

          </div>
          <div class="modal-body">

            <div class="dash">
              <!-- Content goes in here -->
            </div>

          </div>

        </div>
      </div>
    </div>
<!-- Custom JS -->
<script src="Insert.js"></script>
<script src="Update.js"></script>


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
  $('#accountsView').DataTable({
    "fnCreatedRow": function(nRow, aData, iDataIndex) {
      $(nRow).attr('id', aData[0]);
    },
    'serverSide': true,
    'processing': true,
    'responsive': true,
    'paging': true,
    'order': [],
    'ajax': {
      'url': "{{ route('accounts.data') }}",
      'type': 'post',
      'headers': {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    },
    "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [0, 9]
    }]
  });

  //Account Add
      $('#modal-default1').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var ID = button.data('whatever') // Extract info from data-* attributes
        var modal = $(this);
        var dataString = 'id=' + ID;
        modal.find('.dash').html('');

        if(ID =='Account'){

          modal.find('.modal-title').text('Account Add');
       
        $.ajax({
          type: "GET",
          url: "{{ route('accounts.create') }}",
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

      }else if (ID !='Account'){

          modal.find('.modal-title').text('Account Update');
          $.ajax({
          type: "GET",
          url: "/accounts/" + ID + "/edit",
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
          alert(400);
        }

      });

    </script>

</html>
