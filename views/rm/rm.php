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
    <div class="row mb-4">
        <div class="col-sm-1">
            <b>RM:</b> <?php echo $id->id ?>
        </div>
        <div class="col-sm-2">
            <b>FECHA:</b> <?php echo $id->date ?>
        </div>
        <div class="col-sm-3">
            <b>CLIENTE:</b> <?php echo $id->clientname ?>
        </div>
        <div class="col-sm-3">
            <b>PRODUCTO:</b> <?php echo $id->productname ?>
        </div>
        <div class="col-sm-3">
            <b>CIUDAD:</b> <?php echo $id->city ?>
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
                <input type="datetime-local" onfocus='this.showPicker()' class="form-control" name="datetime" required>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Responsable:</label>
                <div class="input-group">
                    <select class="form-control" name="operatorId" required>
                        <option value=''></option>
                        <?php foreach ($this->model->list("*","users"," and type = 'Operario' and status = 1") as $r) { ?>     
                            <option value='<?php echo $r->id?>'><?php echo $r->username?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-1">
            <div class="form-group">
                <label>* Reactor N°:</label>
                <div class="input-group">
                    <select class="form-control" name="reactor">
                        <option></option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Pasta que no Entra:</label>
                <div class="input-group">
                <input type="number" step="0.01" class="form-control" id="paste" name="paste" required>
                </div>
            </div>
        </div>

        <div class="col-sm-1">
            <div class="form-group">
                <label>* Devolver:</label>
                <div class="input-group">
                <input type="number" step="1" min="0" class="form-control" name="toreturn" required>
                </div>
            </div>
        </div>

        <div class="col-sm-1">
            <div class="form-group">
                <label>* Excedente:</label>
                <div class="input-group">
                <input type="number" step="1" min="0" class="form-control" name="surplus" required>
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
                <textarea style="width:100%" class="form-control form-control-sm" name="notes"></textarea>
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
        row = row+1;
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

$(document).on("change", "#paste", function(e) {
    paste = $('#paste').val();
    net = SUMCOL(table, 4);
    total = Number(net) - Number(paste);
    $('#total').html(total);
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
        data = $( "#formRM" ).serialize();
        table = table.getData();
        status = '<?php echo $status ?>';
        id = <?php echo $id->id ?>;
        $.post( "?c=RM&a=Update", {data,table,status,id}).done(function(res) {
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