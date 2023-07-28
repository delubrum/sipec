<form method="post" id="form">
    <div class="modal-header">
        <h5 class="modal-title"><?php echo (isset($id)) ? 'Editar' : 'Nuevo'; ?> Producto</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>* Nombre:</label>
                    <div class="input-group">
                        <input class="form-control" name="name" value="<?php echo isset($id) ? $id->name : '' ?>" required>
                        <input type="hidden" name="id" value="<?php echo isset($id) ? $id->id : '' ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><?php echo (isset($id)) ? 'Actualizar' : 'Guardar'; ?></button>
    </div>
</form>

<script>
$(document).on('submit', '#form', function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    if (document.getElementById("form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=Products&a=Save", $( "#form" ).serialize()).done(function(res) {
            if (isNaN(res)) {
                toastr.error(res);
                $("#loading").hide();
            } else {
                location.reload();
            }
        });
    }
});
</script>