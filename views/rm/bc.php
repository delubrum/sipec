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

    <center>
    <div id="spreadsheet"></div>

    <div id="spreadsheet2"></div>

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

var customColumn = {
    // Methods
    closeEditor : function(cell, save) {
        var value = cell.children[0].value;
        cell.innerHTML = value;
        return value;
    },
    openEditor : function(cell) {
        // Create input
        var element = document.createElement('input');
        element.type = "datetime-local";
        element.value = cell.innerHTML;
        cell.innerHTML = '';
        cell.appendChild(element);
        element.focus();
    },
    getValue : function(cell) {
        return cell.innerHTML;
    },
    setValue : function(cell, value) {
        cell.innerHTML = value;
    }
}

var save = function(instance, cell, x, y, value) {
    data = table.getData();
    id = <?php echo $id->id ?>;
    field = 'turns';
    $("#loading").show();
    $.post("?c=BC&a=UpdateData",{id,data,field}).done(function(data){
        $("#loading").hide();
        table.refresh();
    });
}

var save2 = function(instance, cell, x, y, value) {
    data = table2.getData();
    id = <?php echo $id->id ?>;
    field = 'data';
    $("#loading").show();
    $.post("?c=BC&a=UpdateData",{id,data,field}).done(function(data){
        $("#loading").hide();
        table.refresh();
    });
}

var table = jspreadsheet(document.getElementById('spreadsheet'), {
    "url":"?c=BC&a=TurnsData&id=<?php echo $id->id ?>",
    minDimensions:[2,1],
    autoIncrement: false,
    allowInsertColumn: false, // Allow ly inserting columns
    allowDeleteColumn: false, // Allow ly deleting columns
    allowRenameColumn: false, // Allow ly deleting columns
    columnDrag:true,
    allowExport: false,
    parseFormulas: true,
    onafterchanges: save,
    columns: [
      { 
        title:'date',
        type:'calendar',
        width:100,
      },
      { 
        title:'Net',
        type:'text',
        width:200,
      },
    ],
    text:{
        insertANewRowBefore:'Insertar fila antes',
        insertANewRowAfter:'Insertar fila despues',
        deleteSelectedRows:'Borrar filas',
        copy:'Copiar',
        paste:'Pegar',
        about: '',
        areYouSureToDeleteTheSelectedRows:'Desea borrar las filas seleccionadas?',
    }
});

var save = function(instance, cell, x, y, value) {
    data = table.getData();
    id = <?php echo $id->id ?>;
    $("#loading").show();
    $.post("?c=RM&a=UpdateData",{id,data}).done(function(data){
        $("#loading").hide();
        table.refresh();
    });
}

var SUMCOL = function(instance, columnId) {
    var total = 0;
    for (var j = 0; j < instance.options.data.length; j++) {
        if (Number(instance.records[j][columnId].innerHTML)) {
            total += Number(instance.records[j][columnId].innerHTML);
        }
    }
    return total.toFixed(2);
}

var table2 = jspreadsheet(document.getElementById('spreadsheet2'), {
    url: "?c=BC&a=ItemsData&id=<?php echo $id->id ?>",
    minDimensions:[10,1],
    autoIncrement: false,
    allowInsertColumn: false, // Allow ly inserting columns
    allowDeleteColumn: false, // Allow ly deleting columns
    allowRenameColumn: false, // Allow ly deleting columns
    columnDrag:true,
    allowExport: false,
    parseFormulas: true,
    onafterchanges: save,
    <?php if($status != 'Registrando') { ?>
        footers: [['=SUMCOL(TABLE(), 0)','=SUMCOL(TABLE(), 1)','=SUMCOL(TABLE(), 2)','=SUMCOL(TABLE(), 3)','=SUMCOL(TABLE(), 4)','=SUMCOL(TABLE(), 5)']],
    <?php } else { ?>
        footers: [['=SUMCOL(TABLE(), 0)','=SUMCOL(TABLE(), 1)']],
    <?php } ?>

    columns: [
      { 
        title:'Peso',
        type:'numeric',
        width:70,
        <?php if($status != 'Registrando') { ?>
        readOnly: true,
        <?php } ?> 
      },
      { 
        title:'Peso Cliente',
        type:'numeric',
        width:100,
      },
      { 
        title:'Taras',
        type:'numeric',
        width:100,
        <?php if($status == 'Registrando') { ?>
        readOnly: true,
        type:'hidden',
        <?php } ?> 
      },
      { 
        title:'Taras Cliente',
        type:'numeric',
        width:100,
        <?php if($status == 'Registrando') { ?>
        readOnly: true,
        type:'hidden',
        <?php } ?> 
      },
      { 
        title:'Neto',
        width:70,
        type:'numeric',
        readOnly: true,
        <?php if($status == 'Registrando') { ?>
        type:'hidden',
        <?php } ?> 
      },
      { 
        title:'Neto cliente',
        type:'numeric',
        width:100,
        readOnly: true,
        <?php if($status == 'Registrando') { ?>
        type:'hidden',
        <?php } ?> 
      },
      {
        type: 'dropdown',
        title:'Estado',
        width:100,
        source:[
          "Bueno",
          "Malo",
        ],
        validate: 'required',
        <?php if($status != 'Registrando') { ?>
        readOnly: true,
        <?php } ?> 
      },
      { 
        title:'Derrames Vehículo',
        type: 'checkbox',
        width:150,
        <?php if($status != 'Registrando') { ?>
        readOnly: true,
        <?php } ?> 
      },
      { 
        title:'Derrames Caneca',
        type: 'checkbox',
        width:150,
        <?php if($status != 'Registrando') { ?>
        readOnly: true,
        <?php } ?> 
      },
      { 
        title:'Derrames Planta',
        type: 'checkbox',
        width:150,
        <?php if($status == 'Registrando') { ?>
        readOnly: true,
        type:'hidden',
        <?php } ?> 
      },
    ],
    updateTable:function(instance, cell, col, row, val, label, cellName) {
        paste = $('#paste').val();
        total = SUMCOL(table, 4);
        $('#total').html(total-paste);
        if (col == 4) {
            cell.innerHTML = (table.getValue('A'+row)-(table.getValue('C'+row))).toFixed(2);
        }
        if (col == 5) {
            cell.innerHTML = (table.getValue('B'+row)-(table.getValue('D'+row))).toFixed(2);
        }
    },
    text:{
        insertANewRowBefore:'Insertar fila antes',
        insertANewRowAfter:'Insertar fila despues',
        deleteSelectedRows:'Borrar filas',
        copy:'Copiar',
        paste:'Pegar',
        about: '',
        areYouSureToDeleteTheSelectedRows:'Desea borrar las filas seleccionadas?',
    }
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

