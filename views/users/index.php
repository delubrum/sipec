<header>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script> -->
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary float-right new">
                    <i class="fas fa-plus"></i> Nuevo
                </button>
                <h1 class="m-0 text-dark">Usuarios</h1>
                
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card p-4 listTable">
            <?php require_once 'list_row.php' ?>        
        </div>
    </div>
</div>
</div>
</div>

<script>

$(document).on("click", ".new", function() {
    id = $(this).data('id');
    $.post( "?c=Users&a=UserForm", { id }).done(function( data ) {
        $('#lgModal').modal('toggle');
        $('#lgModal .modal-content').html(data);
    });
});

$(document).on("click", ".edit", function() {
    id = $(this).data('id');
    if (id == <?php echo $user->id ?>) {
        window.location = "?c=Users&a=Profile"
    } else {
        $.post( "?c=Users&a=UserEdit", { id }).done(function( data ) {
            $('#xlModal').modal('toggle');
            $('#xlModal .modal-content').html(data);
        });
    }
});

$(document).ready(function() {
    $('table').DataTable({
        "lengthChange": false,
        "paginate": false,
        // rowReorder: true,
    });
});
</script>