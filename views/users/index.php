<header>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary float-right new btn-lg">
                    <i class="fas fa-plus"></i> 
                </button>
                <h2 class="m-0 text-dark">Usuarios</h2>
                
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card p-4 listTable"> 
            <?php require_once 'list.php' ?>
        </div>
    </div>
</div>
</div>
</div>

<script>
$(document).on("click", ".new", function() {
    $.post( "?c=Users&a=New").done(function( data ) {
        $('#lgModal').modal('toggle');
        $('#lgModal .modal-content').html(data);
    });
});
</script>