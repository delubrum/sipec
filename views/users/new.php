<form id="user_form" autocomplete="off">
    <?php if ($a != 'Profile') { ?>
    <div class="modal-header">
        <h5 class="modal-title">New User</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
    <?php } ?>
    <?php if ($a == 'Profile') { ?>
        <div class="card">
            <div class="card-body">
            <?php } ?>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Nombre</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" name="name" value="<?php echo (isset($user->id) and $a == 'Profile') ? $user->username : '';  ?>">
                        <input type="hidden" name="userId" value="<?php echo (isset($user->id) and $a == 'Profile') ? $user->id : '';  ?>">

                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="email" class="form-control" name="email" value="<?php echo (isset($user->id) and $a == 'Profile') ? $user->email : ''  ?>">
                    </div>
                </div>
                 <!--
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Language</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <select class="form-control" name="lang">
                            <option value="en" <?php echo (isset($user->id) and $user->lang == 'en') ? 'selected' : '' ?>><?php echo $lang['English'] ?></option>
                            <option value="es" <?php echo (isset($user->id) and $user->lang == 'es') ? 'selected' : '' ?>><?php echo $lang['Spanish'] ?></option>
                        </select>
                    </div>
                </div>

                -->
                <input type="hidden" name="lang" value="es">
                <!-- <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Email Password</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="password" name="emailpass" id="epass" class="form-control" value="<?php echo (isset($user->id) and $a == 'Profile') ? $user->emailPassword : ''  ?>" required>
                    </div>
                </div> -->
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Nueva Contraseña</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="password" minlength="4" id="newpass" name="newpass" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Confirmación Nueva Contraseña</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="password" minlength="4" id="cpass" name="cpass" class="form-control">
                    </div>
                </div>
                <?php if ($a == 'Profile') { ?>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="submit" class="btn btn-primary px-4 float-right" value="Save">
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
$(document).on('submit','#user_form', function(e) {
    e.preventDefault();
    if (document.getElementById("user_form").checkValidity()) {
        if ($("#cpass").val() != '' && $("#newpass").val() != $("#cpass").val()) {
            toastr.error('New Password do not match');
        } else {
            $("#loading").show();
            $.post( "?c=Users&a=UserSave", $("#user_form").serialize()).done(function( res ) {
                if (isNaN(res.trim())) {
                    toastr.error(res.trim());
                    $("#loading").hide();
                } else {
                    id = res.trim();
                    if (res.trim() != <?php echo $user->id ?>) {
                        $.post( "?c=Users&a=UserEdit", { id }).done(function( data ) {
                            $('#xlModal').modal('toggle');
                            $('#xlModal .modal-content').html(data);
                            $("#loading").hide();
                            $('#lgModal').modal('toggle');
                        });
                    } else {
                        location.reload();
                    }
                }
            });
        }
    }
});

// $(document).on('input','#epass', function(e) {
//     $(this).attr('type', '');
// });

// $(document).on('blur','#epass', function(e) {
//     $(this).attr('type', 'password');
// });
</script>