
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
              <h1 class="m-0">Added Menu</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Added Menu</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title"> Setup Menu</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <!-- Info boxes -->
              <div class="row">
       <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-md-3">
                  <a href="{{ route('accountSetupView') }}" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Account Setup View</h3>

                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Active Package 
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>

                   <div class="col-md-3">
                  <a href="{{ route('receiveView') }}" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Receive View</h3>

                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Active Package 
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                
                <div class="col-md-3">
                  <a href="{{ route('paymentView') }}" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Payment View</h3>

                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Active Package 
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>

                <!-- /.col -->
              </div>
              <!-- /.row -->

            </div>
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

</body>
</html>
