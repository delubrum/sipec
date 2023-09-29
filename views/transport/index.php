<header>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
	<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
  <script src="assets/plugins/select2/js/select2.full.min.js"></script>
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
								<button type="button" class="btn btn-primary float-right new btn-lg">
                  <i class="fas fa-plus"></i> Adicionar
                </button>
                <h2 class="m-0 text-dark">Planilla de Transporte</h2>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
							<h3 class="card-title">Filtros</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" style="margin-top:0px;">
									<i class="fas fa-minus"></i>
								</button>
							</div>
            </div>
						<div class="card-body" style="display: block;">
							<form id="filter_form" method="post" autocomplete="off" enctype="multipart/form-data" action="?c=Transport&a=Index">
								<div class="row">
									<div class="col-sm-2">
											<div class="form-group">
													<label>RM:</label>
													<div class="input-group">
															<input type="number" step="1" min="1" class="form-control" value="<?php echo !empty($_POST) ? $_POST['id'] : '' ?>" name="id">
													</div>
											</div>
									</div>
									<div class="col-sm-2">
											<div class="form-group">
													<label>Factura:</label>
													<div class="input-group">
															<input class="form-control" value="<?php echo !empty($_POST) ? $_POST['invoice'] : '' ?>" name="invoice">
													</div>
											</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
												<label>* Responsable:</label>
												<div class="input-group">
														<select class="form-control select2" name="user" style="width: 100%;">
																<option value=''></option>
																<?php foreach ($this->model->list("DISTINCT(user) as user","transport") as $r) { ?>     
																		<option <?php echo (!empty($_REQUEST['user']) and $r->user == $_REQUEST['user']) ? 'selected' : ''; ?>><?php echo $r->user?></option>
																<?php } ?>
														</select>
												</div>
										</div>
									</div>
									<div class="col-sm-3">
											<div class="form-group">
													<label>From:</label>
													<input type="date" class="form-control" name="from" value="<?php echo isset($_REQUEST['from']) ? $_REQUEST['from'] : "$mon" ?>" required>
											</div>
									</div>

									<div class="col-sm-3">
											<div class="form-group">
													<label>To:</label>
													<input type="date" class="form-control" name="to" value="<?php echo isset($_REQUEST['to']) ? $_REQUEST['to'] : "$sun" ?>" required>
											</div>
									</div>
								</div>
								<span class="h4">Total: $ <?php echo $total ?></span>
								<button type="submit" class="btn btn-primary float-right"><i class="fas fa-search"></i> Search</button>
							</form>
						</div>
          </div>
        </div>
        <div class="card p-4 listTable"> 
					<table id="list" class="display table-striped text-md">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Responsable</th>
								<th>Punto de Origen</th>
								<th>Punto de Destino</th>
								<th>RM</th>
								<th>Cantidad de Tambores</th>
								<th>Kg</th>
								<th>Factura</th>
								<th>Valor</th>
								<th>Notas</th>
							</tr>
						</thead>
					</table> 
        </div>
    	</div>
		</div>
	</div>
</div>

<script>
$('.select2').select2();

$(document).on("click", ".new", function(e) {
	e.stopImmediatePropagation();
  e.preventDefault();
	$("#loading").show();
	$.post( "?c=Transport&a=New").done(function( data ) {
		$("#loading").hide();
		$('#xlModal').modal('toggle');
		$('#xlModal .modal-content').html(data);
	});
});

$(document).ready(function() {
list = $('#list').DataTable({
		'order': [[0, 'desc']],
		'lengthChange' : false,
		'paginate': false,
		'scrollX' : true,
		'autoWidth' : false,
		'ajax': {
			url:"?c=Transport&a=Data&filters=<?php echo $filters?>",
			dataSrc: function (json) {
				// Check if the data array is not empty or null
				if (json != '') {
					return json;
				} else {
					return []; // Return an empty array to prevent rendering
				}
			},
		},
		'columns': [
			{ data: 'date' },
			{ data: 'user' },
			{ data: 'start' },
			{ data: 'end' },
			{ data: 'rm' },
			{ data: 'qty' },
			{ data: 'kg' },
			{ data: 'invoice' },
			{ data: 'price' },
			{ data: 'notes' },
		],
	});
});
</script>