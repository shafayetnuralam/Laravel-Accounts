
<nav class="main-header navbar navbar-expand-md navbar-light bg-secondary">
  <div class="container">
    <a href="{{ route('dashboard') }}" class="navbar-brand">
      <!-- <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-light">Development</span>
    </a>

    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
      aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="{{ route('added') }}" class="nav-link">Added Menu</a>        </li>
        
      </ul>

    </div>

    <!-- Right navbar links -->
    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
      

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          
          <span class="material-icons">
            power_settings_new
            
          </span>
          
        </a>
        
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
   
           
                <div class="card-body pt-0">
                   <h2 class="lead"><b>{{ Auth ::user()->name }}</b></h2>
                  <div class="row">
                    <div class="col-7">
                    
                      <p class="text-muted text-sm"><b>Designation: </b> OperatorDesignation </p>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> OperatorAddress </p>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-Phone"></i></span> OperatorPhone </li>
                      </ul>
                    
                    </div>
                    <div class="col-5 text-center">
                      <img src="OperatorPicture" alt="User image" class="img-circle img-fluid">
                    </div>
                  </div>
        
                </div>
                <div class="card-footer">
                  <div class="text-right">
                
                    <a  class="btn btn-primary" data-toggle="modal" data-target="#modal-lg" Title="User Information View/Update" >Change </a>
                     <a  class="btn btn-danger"  href="{{ route('logout') }}">Sign out</a>
                  </div>
                </div>
             
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
<i class="fas fa-question-circle"></i>
</a>
</li>

    </ul>
  </div>
</nav>
<!-- /.navbar -->
