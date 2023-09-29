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
		<div class="row">
			<div class="col-lg-12">
				<?php require_once 'new.php' ?>
			</div>
		</div>

		<?php  if (in_array(1, $permissions)) { ?>
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
								<?php foreach ($this->model->list('DISTINCT(category)','permissions',' ORDER BY sort,category ASC') as $t) { ?>
									<div class="mt-3">
										<h5><?php echo $t->category ?></h5>
										<hr>
									</div>
									<?php foreach ($this->model->list('*','permissions'," and category = '$t->category' ORDER BY sort,name ASC") as $p) { ?>
									<label class="btn <?php echo (in_array($p->id, json_decode($id->permissions))) ? 'btn-primary' : 'btn-secondary'; ?> permission" data-id="<?php echo $p->id ?>" style="cursor:pointer">
										<?php echo $p->name ?>										
									</label>
									<?php } ?>
								<?php } ?>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php  } ?>

	</div>
</div>

<?php  if (in_array(1, $permissions)) { ?>
<script>
$(document).on('click','.permission', function() {
	const userId = '<?php echo $id->id ?>';
	const id = String($(this).data('id')); // Convierte a cadena
	// if (id != '1') {
		$(this).toggleClass('btn-primary btn-secondary');
		const elements = document.querySelectorAll('.permission.btn-primary');
		const arr = Array.from(elements, item => item.getAttribute('data-id'));
		const permissions = JSON.stringify(arr);
		$("#loading").show();
		$.post('?c=Users&a=SavePermissions', {userId, permissions}, function (data) {
			location.reload();
		});
	// }
});
</script>
<?php } ?>
