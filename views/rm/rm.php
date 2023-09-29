<form method="post" id="formRM">
  <div class="modal-header">
  <h5 class="modal-title">Recibo de Materiales</h5>
  <input type="hidden" name="id" value="<?php echo $id->id ?>">
  <input type="hidden" name="status" id="status" value="<?php echo $status ?>">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
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
                        <?php foreach ($this->model->list("*","users"," and type = 'Operario' and status = 1") as $r) { ?>     
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
                    <select class="form-control inputRM" data-id="<?php echo $id->id ?>" data-field="reactor">
                        <option></option>
                        <option <?php echo (isset($id) and $id->reactor == 1) ?'selected' : ''; ?>>1</option>
                        <option <?php echo (isset($id) and $id->reactor == 2) ?'selected' : ''; ?>>2</option>
                        <option <?php echo (isset($id) and $id->reactor == 3) ?'selected' : ''; ?>>3</option>
                    </select>
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

    table = jspreadsheet(document.getElementById('spreadsheet'), {
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
    allowInsertRow: false, // Allow ly inserting columns
    allowDeleteRow: false, // Allow ly inserting columns
    footers: [['=SUMCOL(TABLE(), 0)','=SUMCOL(TABLE(), 1)','=SUMCOL(TABLE(), 2)','=SUMCOL(TABLE(), 3)','=SUMCOL(TABLE(), 4)','=SUMCOL(TABLE(), 5)']],
    columns: [
      { 
        title:'PESO BRUTO',
        type:'numeric',
        width:100,
        readOnly: true,
      },
      { 
        title:'PESO BRUTO \n CLIENTE',
        type:'numeric',
        width:100,
        readOnly: true,
      },
      { 
        title:'TARAS',
        type:'numeric',
        width:100,
      },
      { 
        title:'TARAS CLIENTE',
        type:'numeric',
        width:100,
      },
      { 
        title:'PESO NETO',
        width:100,
        type:'numeric',
        readOnly: true,
      },
      { 
        title:'PESO NETO \n CLIENTE',
        type:'numeric',
        width:100,
        readOnly: true,
      },
      {
        type: 'dropdown',
        title:'ESTADO DEL \n TAMBOR',
        width:100,
        source:[
          "Bueno",
          "Malo",
        ],
        validate: 'required',
        readOnly: true,
      },
      { 
        title:'DERRAMES \n VEHÍCULO',
        type: 'checkbox',
        width:100,
        readOnly: true,
      },
      { 
        title:'DERRAMES \n CANECA',
        type: 'checkbox',
        width:100,
        readOnly: true,
      },
      { 
        title:'DERRAMES \n PLANTA',
        type: 'checkbox',
        width:100,
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
        copy:'Copiar',
        paste:'Pegar',
        about: '',
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

$(document).on('submit', '#formRM', function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    if (hasEmptyFields(table.getColumnData(2))) {
        toastr.error('Complete la columna Tara');
        return
    };
    if (hasEmptyFields(table.getColumnData(3))) {
        toastr.error('Complete la columna Tara Cliente');
        return
    };
    if (document.getElementById("formRM").checkValidity()) {
        $("#loading").show();
        $.post( "?c=RM&a=Update", $( "#formRM" ).serialize()).done(function(res) {
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