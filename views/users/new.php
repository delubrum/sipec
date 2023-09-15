<form id="form" autocomplete="off">
    <?php if ($a != 'Profile') { ?>
    <div class="modal-header">
        <h5 class="modal-title">Nuevo Usuario</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
    <?php } ?>
    <?php if ($a == 'Profile') { ?>
        <div class="card p-2">
            <div class="card-body">
            <?php } ?>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Tipo</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <input type="hidden" name="userId" value="<?php echo (isset($id) and $a == 'Profile') ? $id->id : '';  ?>">
                        <select class="form-control" name="type" id="type" required>
                            <option value=''></option>
                            <option value='Usuario' <?php echo (isset($id) and $id->type == 'Usuario') ? 'selected' : '' ?>>Usuario</option>
                            <option value='Cliente' <?php echo (isset($id) and $id->type == 'Cliente') ? 'selected' : '' ?>>Cliente</option>
                            <option value='Operario' <?php echo (isset($id) and $id->type == 'Operario') ? 'selected' : '' ?>>Operario</option>

                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Nombre</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" name="name" value="<?php echo (isset($id->id) and $a == 'Profile') ? $id->username : '';  ?>" required>

                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="email" class="form-control" name="email" value="<?php echo (isset($id->id) and $a == 'Profile') ? $id->email : ''  ?>" required>
                    </div>
                </div>
                 <!--
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Language</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <select class="form-control" name="lang">
                            <option value="en" <?php echo (isset($id->id) and $id->lang == 'en') ? 'selected' : '' ?>><?php echo $lang['English'] ?></option>
                            <option value="es" <?php echo (isset($id->id) and $id->lang == 'es') ? 'selected' : '' ?>><?php echo $lang['Spanish'] ?></option>
                        </select>
                    </div>
                </div>

                -->
                <input type="hidden" name="lang" value="es">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Nueva Contraseña</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="password" minlength="4" id="newpass" name="newpass" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Confirmación Nueva Contraseña</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="password" minlength="4" id="cpass" name="cpass" class="form-control" required>
                    </div>
                </div>

                <div id="clientForm" <?php if(!isset($id) or (isset($id) and $id->type != 'Cliente')) { ?> style="display: none" <?php } ?>>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Empresa</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input class="form-control" name="company" value="<?php echo isset($id) ? $id->company : '' ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Tel</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input class="form-control" name="phone" value="<?php echo isset($id) ? $id->phone : '' ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Ciudad</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input class="form-control" name="city" value="<?php echo isset($id) ? $id->city : '' ?>">
                        </div>
                    </div>

                    <div class="col-sm-12">
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



                <?php if ($a == 'Profile') { ?>
                <div class="row">
                    <div class="col-12 text-center mt-4">
                        <input type="submit" class="btn btn-primary" value="Guardar">
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    <?php if ($a != 'Profile') { ?>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
    <?php } ?>
</form>

<script>
$(document).on('submit', '#form', function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    if ($("#type").val() === 'Cliente') {
        if ($('.btn-info').length < 1) {
            toastr.error('Seleccione almenos un producto');
            return
        }
    }
    if (document.getElementById("form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=Users&a=Save", $( "#form" ).serialize()).done(function(res) {
            if (isNaN(res)) {
                toastr.error(res);
                $("#loading").hide();
            } else {
                window.location = '?c=Users&a=Profile&id='+res;
            }
        });
    }
});


$(document).on('click', '.products', function() {
    $(this).toggleClass('btn-info btn-secondary');
	if ($(this).hasClass("btn-secondary")) {
		$(this).find('input').prop( "disabled", true );
    } else {
		$(this).find('input').prop( "disabled", false );
    }
});

$(document).on('change', '#type', function(e) {
    if ($(this).val() === 'Cliente') {
        $("#clientForm").show();
    } else {
        $("#clientForm").hide();
    }
});
</script>