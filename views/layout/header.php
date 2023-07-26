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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
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
        <div class="modal-dialog modal-xl" role="document">
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
      
            <!-- User Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
            <i class="far fa-user text-dark"></i> 
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="?c=Users&a=Profile" class="dropdown-item">
                <!-- Message Start -->
                <div class="media">
                <i class="far fa-user fa-3x mr-3"></i>
                <div class="media-body">
                    <h3 class="dropdown-item-title">
                    <?php echo $user->username ?>
                    </h3>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?php echo $user->createdAt ?></p>
                </div>
                </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="?c=Login&a=Logout" class="dropdown-item dropdown-footer float-rigt"><i class="fa fa-times"></i> Logout</a>
            </div>

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
                        $permissionsTitle[] = $this->init->get('*','permissions',$p)->title;
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

        <div class="content-wrapper">

<script>
// $(document).ready(function(){
//     alerts();
//     setInterval(function(){ 
//         alerts();; 
//  }, 5000);
// });    

// function alerts() {
//     $.post('?c=Init&a=Alerts', { 'id': true },function(data) {
//         if(data.trim() != ''){
//         $("#task-counter").html(`<i class="far fa-bell"></i><span class="badge bg-danger navbar-badge alert">${data}</span>`);
//         } else {
//             $("#task-counter").html(`<i class="far fa-bell"></i>`);
//         }
//     }); 
// }

// $('#task-dropdown').on('show.bs.dropdown', function () {
//     $.post("?c=Init&a=Alerts", function(data) {
//         $("#task-alerts").html( data );
//     });
// });
</script>