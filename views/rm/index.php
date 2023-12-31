<header>
	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
	
	<script src="https://bossanova.uk/jspreadsheet/v4/jexcel.js"></script>
	<link rel="stylesheet" href="https://bossanova.uk/jspreadsheet/v4/jexcel.css" type="text/css" />
	<script src="https://jsuites.net/v4/jsuites.js"></script>
	<link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
								<button type="button" class="btn btn-primary float-right new btn-lg">
                  <i class="fas fa-plus"></i> Adicionar
                </button>
                <h2 class="m-0 text-dark">Recibo de Material</h2>
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
							<form id="filter_form" method="post" autocomplete="off" enctype="multipart/form-data" action="?c=RM&a=Index">
								<div class="row">
									<div class="col-sm-2">
											<div class="form-group">
													<label>RM:</label>
													<div class="input-group">
															<input type="number" step="1" min="1" class="form-control select2" value="<?php echo !empty($_POST) ? $_POST['id'] : '' ?>" name="id">
													</div>
											</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
												<label>* Cliente:</label>
												<div class="input-group">
														<select class="form-control select2" name="clientId" id="client" style="width: 100%;">
																<option value=''></option>
																<?php foreach ($this->model->list("*","users"," and type = 'Cliente' and status = 1") as $r) { ?>     
																		<option <?php echo (!empty($_REQUEST['clientId']) and $r->id == $_REQUEST['clientId']) ? 'selected' : ''; ?> value='<?php echo $r->id?>'><?php echo $r->company?></option>
																<?php } ?>
														</select>
												</div>
										</div>
									</div>
									<div class="col-sm-2">
											<div class="form-group">
													<label>Producto:</label>
													<div class="input-group">
													<select class="form-control select2" name="productId" style="width: 100%;">
																<option value=''></option>
																<?php foreach ($this->model->list("*","products"," and status = 1") as $r) { ?>     
																		<option <?php echo (!empty($_REQUEST['productId']) and $r->id == $_REQUEST['productId']) ? 'selected' : ''; ?> value='<?php echo $r->id?>'><?php echo $r->name?></option>
																<?php } ?>
														</select>
													</div>
											</div>
									</div>
									<div class="col-sm-2">
											<div class="form-group">
													<label>Estado:</label>
													<div class="input-group">
															<select class="form-control" name="status">
															<option></option>
															<option <?php echo (!empty($_REQUEST['status']) and 'Terminar R.M.' == $_REQUEST['status']) ? 'selected' : ''; ?> value="Terminar R.M.">Terminar R.M.</option>
															<option <?php echo (!empty($_REQUEST['status']) and 'Producción' == $_REQUEST['status']) ? 'selected' : ''; ?> value="Producción">Producción</option>
															<option <?php echo (!empty($_REQUEST['status']) and 'Iniciado' == $_REQUEST['status']) ? 'selected' : ''; ?> value="Iniciado">Iniciado</option>
															<option <?php echo (!empty($_REQUEST['status']) and 'Facturación' == $_REQUEST['status']) ? 'Facturación' : ''; ?> value="Facturación">Facturación</option>
															<option <?php echo (!empty($_REQUEST['status']) and 'Cerrado' == $_REQUEST['status']) ? 'selected' : ''; ?> value="Cerrado">Cerrado</option>
															</select>
													</div>
											</div>
									</div>
									<div class="col-sm-2">
											<div class="form-group">
													<label>Desde:</label>
													<input type="date" class="form-control" onfocus='this.showPicker()' value="<?php echo !empty($_POST) ? $_POST['from'] : '' ?>" name="from">
											</div>
									</div>
									<div class="col-sm-2">
											<div class="form-group">
													<label>Hasta:</label>
													<input type="date" class="form-control" onfocus='this.showPicker()' value="<?php echo !empty($_POST) ? $_POST['to'] : '' ?>" name="to">
											</div>
									</div>
								</div>
								<button type="submit" class="btn btn-primary float-right"><i class="fas fa-search"></i> Buscar</button>
							</form>
						</div>
          </div>
        </div>
        <div class="card p-4 listTable"> 
					<table id="list" class="display table-striped text-md">
						<thead>
							<tr>
								<th>RM</th>
								<th>Fecha</th>
								<th>Creado Por</th>
								<th>Cliente</th>
								<th>Producto</th>
								<th>Estado</th>
								<?php if (!empty($_REQUEST['status']) and 'Cerrado' == $_REQUEST['status']) { ?>
								<th>Factura</th>
								<?php } ?>
								<th class="text-right">Acción</th>
							</tr>
						</thead>
					</table> 
        </div>
    	</div>
		</div>
	</div>
</div>

<script>
$(document).on("click", ".new", function(e) {
	e.stopImmediatePropagation();
  e.preventDefault();
	$("#loading").show();
	$.post( "?c=RM&a=New").done(function( data ) {
		$("#loading").hide();
		$('#lgModal').modal('toggle');
		$('#lgModal .modal-content').html(data);
	});
});

$(document).on("click", ".action", function() {
	id = $(this).data('id');
	status = $(this).data('status');
  if (status == 'Terminar R.M.') {
		url = "?c=RM&a=RM";
	}
	if (status == 'Producción' || status == 'Iniciado') {
		url = "?c=BC&a=BC";
	} 
  if (status == 'Análisis') {
		url = "?c=IP&a=IP";
	}
  if (status == 'Facturación') {
		url = "?c=BC&a=IV";
	} 
	$("#loading").show();
	$.post(url , {id, status}).done(function(data){
		$("#loading").hide();
	  if (status == 'Facturación') {
			$('#xsModal').modal('toggle');
			$('#xsModal .modal-content').html(data);
		} else {
			$('#xlModal').modal('toggle');
			$('#xlModal .modal-content').html(data);
		}
	});
});

$(document).ready(function() {
list = $('#list').DataTable({
		'order': [[1, 'desc']],
		'lengthChange' : false,
		'paginate': false,
		'scrollX' : true,
		'autoWidth' : false,
		'ajax': {
			url:"?c=RM&a=Data&filters=<?php echo $filters ?>",
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
			{ data: 'id' },
			{ data: 'date' },
			{ data: 'user' },
			{ data: 'client' },
			{ data: 'product' },
			{ data: 'status' },
			<?php if (!empty($_REQUEST['status']) and 'Cerrado' == $_REQUEST['status']) { ?>
				{ data: 'invoice' },
			<?php } ?>
			{ data: 'action' }
		],
		"columnDefs": [
        { "width": "200px", "targets": 6 },
				{ className: 'dt-body-right', "targets": 6 },
				
    ]
	});
});
</script>