<form method="post" id="form">
    <div class="modal-header">
        <h5 class="modal-title"><?php echo (isset($id)) ? 'Editar' : 'Nuevo'; ?> Cliente</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Representante:</label>
                    <div class="input-group">
                        <input class="form-control" name="name" value="<?php echo isset($id) ? $id->name : '' ?>" required>
                        <input type="hidden" name="id" value="<?php echo isset($id) ? $id->id : '' ?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Empresa:</label>
                    <div class="input-group">
                    <input class="form-control" name="company" value="<?php echo isset($id) ? $id->company : '' ?>" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Email:</label>
                    <div class="input-group">
                    <input type="email" class="form-control" name="email" value="<?php echo isset($id) ? $id->email : '' ?>" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Tel:</label>
                    <div class="input-group">
                    <input class="form-control" name="tel" value="<?php echo isset($id) ? $id->tel : '' ?>" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Products:</label>
                    <div>
                        <?php foreach ($this->init->list('*','products',' and status = 1') as $p) { ?>
                        <label type="button" class="btn <?php echo (isset($id->products) and in_array($p->id,json_decode($id->products))) ? 'btn-info' : 'btn-secondary'; ?> products">
                            <?php echo $p->name ?>
                            <input type="hidden" name="products[]" value="<?php echo $p->id ?>" <?php echo (isset($id->products) and in_array($p->id,json_decode($id->products))) ? '' : 'disabled'; ?>>
                        </label>
                        <?php } ?>                            
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
    if ($('.btn-info').length < 1) {
        toastr.error('Seleccione almenos un producto');
        return
    }
    if (document.getElementById("form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=Clients&a=Save", $( "#form" ).serialize()).done(function(res) {
            if (isNaN(res)) {
                toastr.error(res);
                $("#loading").hide();
            } else {
                location.reload();
            }
        });
    }
});

$('.products').on('click', function() {
    $(this).toggleClass('btn-info btn-secondary');
	if ($(this).hasClass("btn-secondary")) {
		$(this).find('input').prop( "disabled", true );
    } else {
		$(this).find('input').prop( "disabled", false );
    }
});
</script>