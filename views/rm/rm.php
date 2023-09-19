<form method="post" id="form">
  <div class="modal-header">
  <h5 class="modal-title">Recibo de Materiales</h5>
  <input type="hidden" name="id" value="<?php echo $id->id ?>">
  <input type="hidden" name="status" value="<?php echo $status ?>">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-'hidden'="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <div class="row">
        <div class="col-sm-1">
            <dl>
                <dt><i class="fas fa-info-circle"></i> RM:</dt>
                <dd class="text-md"><?php echo $id->id ?></dd>
            </dl>
        </div>
        <div class="col-sm-3">
            <dl>
                <dt><i class="fas fa-calendar"></i> FECHA:</dt>
                <dd class="text-md"><?php echo $id->date ?></dd>
            </dl>
        </div>
        <div class="col-sm-3">
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
                <dt><i class="fas fa-globe"></i> CIUDAD:</dt>
                <dd class="text-md"><?php echo $id->city ?></dd>
            </dl>
        </div>

    </div>

    <center>
        <div id="spreadsheet"></div>
    </center>
    
    <?php if($status != 'Registrando') { ?>
    <div class="row mt-4">
        <div class="col-sm-2">
            <div class="form-group">
                <label>* Fecha Y Hora Cargue:</label>
                <div class="input-group">
                <input type="datetime-local" onfocus='this.showPicker()' class="form-control inputRM" data-id="<?php echo $id->id ?>" data-field="datetime" value="<?php echo (isset($id)) ? $id->datetime : ''; ?>"" required>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Responsable:</label>
                <div class="input-group">
                    <select class="form-control inputRM" data-id="<?php echo $id->id ?>" data-field="operatorId" required>
                        <option value=''></option>
                        <?php foreach ($this->init->list("*","users"," and type = 'Operario' and status = 1") as $r) { ?>     
                            <option value='<?php echo $r->id?>' <?php echo (isset($id->operatorId) and $id->operatorId == $r->id) ? 'selected' : '' ?>><?php echo $r->username?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-1">
            <div class="form-group">
                <label>* Reactor N°:</label>
                <div class="input-group">
                <input type="number" step="1" min="1" class="form-control inputRM" data-id="<?php echo $id->id ?>" data-field="reactor" value="<?php echo (isset($id)) ? $id->reactor : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Pasta que no Entra:</label>
                <div class="input-group">
                <input type="number" step="0.01" class="form-control inputRM" id="paste" data-id="<?php echo $id->id ?>" data-field="paste" value="<?php echo $id->paste ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-1">
            <div class="form-group">
                <label>* Devolver:</label>
                <div class="input-group">
                <input type="number" step="1" min="1" class="form-control inputRM" data-id="<?php echo $id->id ?>" data-field="toreturn" value="<?php echo (isset($id)) ? $id->toreturn : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-1">
            <div class="form-group">
                <label>* Excedente:</label>
                <div class="input-group">
                <input type="number" step="1" min="1" class="form-control inputRM" data-id="<?php echo $id->id ?>" data-field="surplus" value="<?php echo (isset($id)) ? $id->surplus : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label>* Total a Cargar:</label>
                <div class="input-group mt-1 h5 text-primary">
                <span id="total"> </span>
                </div>
            </div>
        </div>



        <div class="col-sm-12">
            <div class="form-group">
                <label>Notas:</label>
                <div class="input-group">
                <textarea style="width:100%" class="form-control form-control-sm inputRM" data-id="<?php echo $id->id ?>" data-field="notes"><?php echo (isset($id)) ? $id->notes : ''; ?></textarea>
                </div>
            </div>
        </div>



    </div>

    <?php } ?> 

  </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Guardar</button>
  </div>

</form>

<script>

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

var table = jspreadsheet(document.getElementById('spreadsheet'), {
    url: "?c=RM&a=ItemsData&id=<?php echo $id->id ?>&status=<?php echo $status ?>",
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



// Function to check for empty fields in JSON data
function hasEmptyFields(data) {
  function checkObject(obj) {
    for (const key in obj) {
      if (obj.hasOwnProperty(key)) {
        const value = obj[key];
        
        if (value === '' || value === null || value === undefined) {
          return true; // Found an empty field, return true
        } else if (typeof value === 'object') {
          if (checkObject(value)) {
            return true; // Recursively found an empty field, return true
          }
        }
      }
    }
    
    return false; // No empty fields found in this object
  }

  return checkObject(data);
}

<?php if($status != 'Registrando') { ?> 
    $(document).on("change", ".inputRM", function(e) {
        e.stopImmediatePropagation();
        e.preventDefault();
        id = $(this).data('id');
        field = $(this).data('field');
        value = $(this).val();
        $("#loading").show();
        $.post("?c=RM&a=Update",{id,field,value}).done(function(data){
            $("#loading").hide();
            paste = $('#paste').val();
            total = SUMCOL(table, 4);
            $('#total').html(total-paste)
        });
    });
<?php } ?> 

$(document).on('submit', '#form', function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    if (hasEmptyFields(table.getColumnData(0))) {
        toastr.error('Complete la columna Peso');
        return
    };
    if (hasEmptyFields(table.getColumnData(6))) {
        toastr.error('Complete la columna Estado');
        return
    };


    <?php if($status != 'Registrando') { ?> 
    if (hasEmptyFields(table.getColumnData(1))) {
        toastr.error('Complete la columna Peso Cliente');
        return
    };
    if (hasEmptyFields(table.getColumnData(2))) {
        toastr.error('Complete la columna Tara');
        return
    };
    if (hasEmptyFields(table.getColumnData(3))) {
        toastr.error('Complete la columna Tara Cliente');
        return
    };
    <?php } ?> 
    if (document.getElementById("form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=RM&a=Update", $( "#form" ).serialize()).done(function(res) {
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