<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" sizes="192x192" href="assets/img/logo.png">
    <title>SIPEC</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
    <!-- Header -->
    <link rel="stylesheet" href="assets/css/header.css?v=1">
    <!-- REQUIRED SCRIPTS -->
    <noscript>This Site requires JavaScript! Este sitio require JavaScript!
        <style>
        .wrapper {display:none;}
        </style>
    </noscript>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <!-- Bootstrap 4 -->
    <script src="https://adminlte.io/themes/v3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <script>
        setInterval(function(){$.post('?c=Init&a=SessionRefresh');},600000); //refreshes the session every 10 minutes
    </script>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse text-sm layout-fixed layout-navbar-fixed">

    <!-- Modals -->
    <div class="modal fade" id="xlModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="min-width:90%">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div class="modal fade" id="lgModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div class="modal fade" id="defModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div class="modal fade" id="xsModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div id="loading"></div>

    <div class="wrapper">
    
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white text-sm">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars text-dark"></i></a>
                </li>
            </ul>


            <!-- Right navbar links -->

            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu 
                
                <li class="nav-item dropdown" id="task-dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false" id="task-counter">
                        <i class="far fa-bell"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="task-alerts" style="max-height:500px;overflow:auto"></div>
                </li>
                
            -->
                <li class="nav-item">
                    <span  class="dropdown-item float-rigt"><?php echo $user->username ?> </span>
                </li>
      
                <li class="nav-item">
                   <a href="?c=Login&a=Logout" class="dropdown-item float-rigt"><i class="fa fa-times"></i></a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <!-- Brand Logo -->
            <a href="?c=Init&a=Index" class="brand-link">
                <img src="assets/img/logo.png" style="width:37px; margin-left:0.7rem !important" class="brand-image">
                <span class="brand-text font-weight-dark pl-2 h6">SIPEC</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent text-sm" data-widget="treeview" role="menu" data-accordion="false">
                    <?php 
                    $permissionsTitle = array();
                    foreach($permissions as $p) { 
                        $filters = "and id = " . $p;
                        $permissionsTitle[] = $this->init->get('*','permissions',$filters)->title;
                    };
                    foreach($this->init->navTitleList() as $t) { 
                    if (in_array($t->title, $permissionsTitle)) {
                    ?>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link <?php echo ($t->c == $_REQUEST['c']) ? 'active' : '' ?>">
                                <?php echo $t->icon ?>
                                <p>
                                    <?php echo isset($lang[$t->title]) ? $lang[$t->title] : $t->title?>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                            
                            <?php foreach($this->init->navSubtitleList($t->title) as $s) {
                            if (in_array($s->id, $permissions)) { ?>
                                <li class="nav-item">
                                    <a href="?c=<?php echo $s->c ?>&a=<?php echo $s->a ?>" <?php echo $s->attributes ?>
                                        class="nav-link <?php echo ($s->c == $_REQUEST['c'] and $s->a == $_REQUEST['a']) ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo isset($lang[$s->subtitle]) ? $lang[$s->subtitle] : $s->subtitle ?></p>
                                    </a>
                                </li>
                            <?php }} ?>
                            </ul>
                        </li>
                        <?php }} ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->

        <div class="content-wrapper" style="background-image: url('assets/img/bubbles.png');background-repeat: no-repeat;background-size:600px;">