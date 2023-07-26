<header>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary float-right new">
                    <i class="fas fa-plus ml-1"></i> Nuevo
                </button>
                <h1 class="m-0 text-dark">Clientes</h1>
                
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
$(document).ready(function() {
    $('#listTable').DataTable({
        "order": [],
        "lengthChange": false,
        "paginate": false,
        "responsive" : true
    });
});

$(document).on("click", ".new", function() {
    id = $(this).data('id');
    $.post( "?c=Clients&a=New", {id}).done(function( data ) {
        $('#lgModal').modal('toggle');
        $('#lgModal .modal-content').html(data);
    });
});
</script>