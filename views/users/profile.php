<style>
	.profilepic:hover {opacity:0.8}
</style>

<?php if ($b == 'Edit') { ?>
<div class="modal-header">
	<h5 class="modal-title">Editar Usuario</b></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
<?php } ?>

<?php if ($b != 'Edit') { ?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Perfil</h1>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content" >
    <div class="container-fluid">
	<?php } ?>

		<div class="row">
			<div class="col-lg-12">
				<?php require_once 'new.php' ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-body">
						<div class="d-flex flex-column">
							<div class="mt-3">
								<h3>Permisos</h3>
							</div>
						</div>

						<form id="userPermissions_form">
							<div class="row">
								<div class="col-sm-12 permissions">
								<?php foreach ($this->users->PermissionsTitleList() as $t) { ?>
									<div class="mt-3">
										<h5><?php echo $t->category ?></h5>
										<hr>
									</div>

									<?php 
									$userPermissions = json_decode($this->init->get('users',$user->id)->permissions);
									foreach ($this->users->PermissionsList($t->category) as $p) { ?>
									<label class="btn <?php echo (in_array($p->id, $userPermissions)) ? 'btn-primary' : 'btn-secondary'; ?> permission active" data-id="<?php echo $p->id ?>" style="cursor:pointer">
										<?php echo $p->name ?>
										<?php echo (in_array($p->id, $userPermissions)) ? "<input type='hidden' name='permissions[]' value='$p->id'>" : ""; ?>
										
									</label>
									<?php } ?>
						
								<?php } ?>
								</div>
							</div>
							<div class="row mt-3">
							<?php  if (in_array(1, $permissions)) { ?>
								<div class="col-12 text-right">
								<input type="hidden" name="userId" value="<?php echo $user->id ?>">
									<button type="submit" class="btn btn-primary">Actualizar</button>
								</div>
								<?php  } ?>
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<script>

$(document).on('click','.permission', function() {
	id = $(this).data('id');
	div = `<input type='hidden' name='permissions[]' value='${id}'>`;
    $(this).toggleClass('btn-primary btn-secondary active');
	if ($(this).hasClass("btn-secondary")) {
		$(this).find('input').remove();
    } else {
		$(this).append(div).val(id);
    }
});

$(document).on('submit','#userPermissions_form', function(e) {
    e.preventDefault();
	$("#loading").show();
	$.post( "?c=Users&a=UserPermissionsSave", $("#userPermissions_form").serialize()).done(function( res ) {
		location.reload();   
	});
});
</script>