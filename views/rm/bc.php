<form method="post" id="form">
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

    </div>

    <div class="table-responsive p-0 mb-4" style="width:100%">
      <table id="turns" class="table-excel">
        <thead>
            <tr>
                <th style="width:40px">Turno</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th style='width:40px !important'>
                    <button class='btn btn-primary addTurn' data-id='<?php echo $id->id ?>'><i class="fas fa-plus"></i></button>
                </th>
            </tr>
        </thead>
      </table>   
    </div> 

    <div class="table-responsive p-0" style="width:100%">
      <table id="items" class="table-excel">
        <thead>
            <tr>
                <th>Date</th>
                <th style="width:40px">N°</th>
                <th>Peso</th>
                <th>Tambor</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>T° Inicio</th>
                <th>T° Fin</th>
                <th>Hora Caldera</th>
                <th>T° Caldera</th>
                <th>Responsable</th>
                <th style='width:40px !important'>
                    <button class='btn btn-primary add' data-id='<?php echo $id->id ?>'><i class="fas fa-plus"></i></button>
                </th>
            </tr>
        </thead>
      </table>    
    </div>

    
    <div class="row mt-4">
        <div class="col-sm-4">
            <div class="form-group">
                <label>* Type:</label>
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

        <div class="col-sm-12">
            <div class="form-group">
                <label>Notas:</label>
                <div class="input-group">
                <textarea style="width:100%" class="form-control form-control-sm inputBC" data-id="<?php echo $id->id ?>" data-field="notes"><?php echo (isset($id)) ? $id->notes : ''; ?></textarea>
                </div>
            </div>
        </div>


    </div>

  </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Guardar</button>
  </div>

</form>


<script>
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
                return []; // Return an empty array to prevent rendering
            }
        },
    },
    'columns': [
        { data: 'date' },
        { data: 'index' },
        { data: 'net' },
        { data: 'drum' },
        { data: 'start' },
        { data: 'end' },
        { data: 't0' },
        { data: 't1' },
        { data: 'boilerTime' },
        { data: 'boilerT' },
        { data: 'user' },
        { data: 'action' }
    ],
});

setTimeout( function () {
    table.draw();
}, 200 );

tableb = $('#turns').DataTable({
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
        'url':'?c=BC&a=TurnsData&id=<?php echo $id->id ?>',
        'dataSrc': function (json) {
            // Check if the data array is not empty or null
            if (json != '') {
                return json;
            } else {
                return []; // Return an empty array to prevent rendering
            }
        },
    },
    'columns': [
        { data: 'index' },
        { data: 'start' },
        { data: 'end' },
        { data: 'action' }
    ],
});

setTimeout( function () {
    tableb.draw();
}, 200 );


});




$(document).on("click", ".add", function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    id = $(this).data('id');
    $("#loading").show();
    $.post("?c=BC&a=SaveItem",{id}).done(function(data){
        $("#loading").hide();
        table.ajax.reload( null, false );
        // setTimeout( function () {
        //     $('.kg:last').focus();
        //     $('.kg:last').val('');
        // }, 100 );
    });
});

$(document).on("click", ".addTurn", function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    id = $(this).data('id');
    $("#loading").show();
    $.post("?c=BC&a=SaveTurn",{id}).done(function(data){
        $("#loading").hide();
        tableb.ajax.reload( null, false );
        // setTimeout( function () {
        //     $('.kg:last').focus();
        //     $('.kg:last').val('');
        // }, 100 );
    });
});

$(document).on('click','.delete', function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    id = $(this).data("id");
    e.preventDefault();
    Swal.fire({
        title: 'Desea eliminar el item?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=BC&a=DeleteItem",{id}).done(function(data){
                $("#loading").hide();
                table.ajax.reload( null, false );
            });
        }
    })
});

$(document).on('click','.deleteTurn', function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    id = $(this).data("id");
    e.preventDefault();
    Swal.fire({
        title: 'Desea eliminar el item?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=BC&a=DeleteTurn",{id}).done(function(data){
                $("#loading").hide();
                tableb.ajax.reload( null, false );
            });
        }
    })
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

$(document).on("change", ".input", function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    id = $(this).data('id');
    field = $(this).data('field');
    value = $(this).val();
    $("#loading").show();
    $.post("?c=BC&a=UpdateItem",{id,field,value}).done(function(data){
        $("#loading").hide();
        table.ajax.reload( null, false );
    });
});

$(document).on("change", ".inputTurn", function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    id = $(this).data('id');
    field = $(this).data('field');
    value = $(this).val();
    $("#loading").show();
    $.post("?c=BC&a=UpdateTurn",{id,field,value}).done(function(data){
        $("#loading").hide();
        tableb.ajax.reload( null, false );
    });
});

$(document).on('submit', '#form', function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    if (document.getElementById("form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=BC&a=Update", $( "#form" ).serialize()).done(function(res) {
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

