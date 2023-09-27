<form method="post" id="formBC">
  <div class="modal-header">
  <h5 class="modal-title">Bitacora</b></h5>
  <input type="hidden" name="id" value="<?php echo $id->id ?>">
  <input type="hidden" name="status" value="<?php echo $status ?>">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <div class="row">
        <div class="col-sm-1">
            <dl>
                <dt><i class="fas fa-info-circle"></i> LOTE:</dt>
                <dd class="text-md"><?php echo $id->id ?></dd>
            </dl>
        </div>
        <div class="col-sm-1">
            <dl>
                <dt><i class="fas fa-info-circle"></i> RM:</dt>
                <dd class="text-md"><?php echo $id->rmId ?></dd>
            </dl>
        </div>
        <div class="col-sm-2">
            <dl>
                <dt><i class="fas fa-user"></i> CLIENTE:</dt>
                <dd class="text-md"><?php echo $id->clientname ?></dd>
            </dl>
        </div>
        <div class="col-sm-2">
            <dl>
                <dt><i class="fas fa-box"></i> PRODUCTO:</dt>
                <dd class="text-md"><?php echo $id->productname ?></dd>
            </dl>
        </div>
        <div class="col-sm-2">
            <dl>
                <dt><i class="fas fa-globe"></i> CANTIDAD:</dt>
                <dd class="text-md"><?php echo $qty ?></dd>
            </dl>
        </div>

        <div class="col-sm-2">
            <dl>
                <dt><i class="fas fa-globe"></i> REACTOR:</dt>
                <dd class="text-md"><?php echo $id->reactor ?></dd>
            </dl>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label>* Tipo:</label>
                <div class="input-group">
                <select class="form-control inputBC" data-id="<?php echo $id->id ?>" data-field="type" required>
                        <option value=''></option>
                        <option <?php echo (isset($id) and $id->type == 'Servicio') ? 'selected' : ''; ?>>Servicio</option>
                        <option <?php echo (isset($id) and $id->type == 'Producción') ? 'selected' : ''; ?>>Producción</option>
                        <option <?php echo (isset($id) and $id->type == 'Reproceso') ? 'selected' : ''; ?>>Reproceso</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Lodos de Destilación:</label>
                <div class="input-group">
                <input class="form-control inputBC" data-id="<?php echo $id->id ?>" data-field="mud_dist" value="<?php echo (isset($id)) ? $id->mud_dist : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Destilado Humedo:</label>
                <div class="input-group">
                <input class="form-control inputBC" data-id="<?php echo $id->id ?>" data-field="distilled" value="<?php echo (isset($id)) ? $id->distilled : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Perdida Evaporación:</label>
                <div class="input-group">
                <input class="form-control inputBC" data-id="<?php echo $id->id ?>" data-field="evaporation" value="<?php echo (isset($id)) ? $id->evaporation : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Lodos del Proceso:</label>
                <div class="input-group">
                <input class="form-control inputBC" data-id="<?php echo $id->id ?>" data-field="mud" value="<?php echo (isset($id)) ? $id->mud : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Agua Inicial:</label>
                <div class="input-group">
                <input class="form-control inputBC" data-id="<?php echo $id->id ?>" data-field="water_0" value="<?php echo (isset($id)) ? $id->water_0 : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Agua Final:</label>
                <div class="input-group">
                <input class="form-control inputBC" data-id="<?php echo $id->id ?>" data-field="water_1" value="<?php echo (isset($id)) ? $id->water_1 : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Gas Inicial:</label>
                <div class="input-group">
                <input class="form-control inputBC" data-id="<?php echo $id->id ?>" data-field="gas_0" value="<?php echo (isset($id)) ? $id->gas_0 : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Gas Final:</label>
                <div class="input-group">
                <input class="form-control inputBC" data-id="<?php echo $id->id ?>" data-field="gas_1" value="<?php echo (isset($id)) ? $id->gas_1 : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Energía Inicial:</label>
                <div class="input-group">
                <input class="form-control inputBC" data-id="<?php echo $id->id ?>" data-field="energy_0" value="<?php echo (isset($id)) ? $id->energy_0 : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Energía Final:</label>
                <div class="input-group">
                <input class="form-control inputBC" data-id="<?php echo $id->id ?>" data-field="energy_1" value="<?php echo (isset($id)) ? $id->energy_1 : ''; ?>" required>
                </div>
            </div>
        </div>

    </div>

    <div class="table-responsive p-0 mt-3" style="width:100%">
			<table id="items" class="table-excel">
					<thead>
					<tr>
							<th>Fecha</th>
							<th>Tipo</th>
							<th>Peso <br> Neto</th>
							<th>Peso <br> Tambor</th>
							<th>T°</th>
							<th>Notas</th>
							<th style='width:20px !important'>
							<?php if ($status == 'Producción' || $status == 'Iniciado') { ?>
							<button class='btn btn-primary add' data-id='<?php echo $id->id ?>'><i class="fas fa-plus"></i> Adicionar</button>
							<?php } ?>
							</th>
					</tr>
					</thead>
			</table>    
    </div>

  </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Guardar</button>
  </div>

</form>


<script>

$(document).on("click", ".add", function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    id = $(this).data('id');
    $("#loading").show();
    $.post("?c=BC&a=NewItem",{id}).done(function(data){
        $("#loading").hide();
		$('#xsModal').modal('toggle');
		$('#xsModal .modal-content').html(data);
	});
});


$(document).ready(function() {
table = $('#items').DataTable({
    'order': [[1, 'asc']],
    'lengthChange' : false,
    'paginate': false,
    'scrollX' : true,
    'autoWidth' : false,
    'ordering': false,
    'searching': false,
    'info':     false,
    language : {
        'zeroRecords': 'Agrega un item'          
    },
    'ajax': {
        'url':'?c=BC&a=ItemsData&id=<?php echo $id->id ?>',
        'dataSrc': function (json) {
            // Check if the data array is not empty or null
            if (json != '') {
                return json;
            } else {
                // Hide the table if there is no data
                return []; // Return an empty array to prevent rendering
            }
        },
    },
    'columns': [
        { data: 'date' },
        { data: 'type' },
        { data: 'net' },
        { data: 'drum' },
        { data: 'temp' },
        { data: 'notes' },
		{ data: 'user' },
    ],
		"columnDefs": [
        { "width": "110px", "targets": 0 },
        { "width": "60px", "targets": [1,2,3,4] },
        { "width": "130px", "targets": 6 },
    ]
});
setTimeout( function () {
    table.draw();
}, 200 );

});

$(document).on("change", ".inputBC", function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    id = $(this).data('id');
    field = $(this).data('field');
    value = $(this).val();
    $("#loading").show();
    $.post("?c=BC&a=Update",{id,field,value}).done(function(data){
        $("#loading").hide();
    });
});

$(document).on('submit', '#formBC', function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    if (document.getElementById("formBC").checkValidity()) {
        $("#loading").show();
        $.post( "?c=BC&a=Update", $( "#formBC" ).serialize()).done(function(res) {
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

