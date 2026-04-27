<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--Wallet Control-->
    <meta http-equiv="case-control" content="no-cache">
    <meta http-equiv="exoires" content="0">
    <meta http-equiv="pragma" content="0">
  <title>Account Management</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="{{ asset('plugins/bs-stepper/css/bs-stepper.min.css') }}">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- jquery Ui  style -->
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.css') }}">
   <!-- DataTables -->
   <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/jstable.css') }}" />
<script src="{{ asset('js/jstable.min.js') }}" type="text/javascript"></script>
<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
<style>
  input[type=text] {
  text-transform: capitalize;
  }

  textarea{
    text-transform: capitalize;
  }
  [data-title]:hover:after {
        opacity: 1;
        transition: all 0.1s ease 0.5s;
        visibility: visible;
      }
      [data-title]:after {
        content: attr(data-title);
        position: absolute;
        bottom: -1.6em;
        left: 100%;
        padding: 4px 4px 4px 8px;
        color: #666;
        white-space: nowrap;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        -moz-box-shadow: 0px 0px 4px #666;
        -webkit-box-shadow: 0px 0px 4px #666;
        box-shadow: 0px 0px 4px #666;
        background-image: -moz-linear-gradient(top, #f0eded, #bfbdbd);
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #f0eded), color-stop(1, #bfbdbd));
        background-image: -webkit-linear-gradient(top, #f0eded, #bfbdbd);
        background-image: -moz-linear-gradient(top, #f0eded, #bfbdbd);
        background-image: -ms-linear-gradient(top, #f0eded, #bfbdbd);
        background-image: -o-linear-gradient(top, #f0eded, #bfbdbd);
        opacity: 0;
        z-index: 99999;
        visibility: hidden;
      }
      [data-title] {
        position: relative;
      }
      
</style>
</head>
