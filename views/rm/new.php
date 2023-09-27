<header>
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
</header>

<form method="post" id="formNew">
    <div class="modal-header">
        <h5 class="modal-title"><?php echo (isset($id)) ? 'Editar' : 'Nuevo'; ?> Recibo</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>* Cliente:</label>
                    <div class="input-group">
                        <select class="form-control select2" name="clientId" id="client" style="width: 100%;" required>
                            <option value=''></option>
                            <?php foreach ($this->init->list("*","users"," and type = 'Cliente' and status = 1") as $r) { ?>     
                                <option value='<?php echo $r->id?>'><?php echo $r->company?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>* Producto:</label>
                    <div class="input-group">
                    <select class="form-control" name="productId" id="product" required>
                        <option>Seleccione el Cliente...</option>
                    </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>* Fecha:</label>
                    <div class="input-group">
                    <input type="date"  onfocus='this.showPicker()' class="form-control" name="date" min="<?php echo date('Y-m-d', strtotime('-2 days')); ?>" max="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>
            </div>
        </div>

        <center>
            <div id="spreadsheet"></div>
        </center>

    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>

<script>
$('.select2').select2({
    dropdownParent: $('#xsModal')
});

$(document).on('input', '#client', function() {
    client = $(this).val();
    $("#loading").show();
    $.post("?c=RM&a=ClientProducts",{client},function(data) {
    var select = $("#product");
    select.empty();
    for (var i=0; i < data.length; i++) {
        select.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
    }
    $("#loading").hide();
  }, "json");
});

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
    minDimensions:[5,1],
    autoIncrement: false,
    allowInsertColumn: false, 
    allowDeleteColumn: false, 
    allowRenameColumn: false,
    columnDrag:true,
    allowExport: false,
    footers: [['=SUMCOL(TABLE(), 0)','=SUMCOL(TABLE(), 1)']],
    columns: [
      { 
        title:'PESO BRUTO',
        type:'numeric',
        width:100,
      },
      { 
        title:'PESO BRUTO \n CLIENTE',
        type:'numeric',
        width:100,
      },
      { 
        type:'hidden',
      },
      { 
        type:'hidden',
      },
      { 
        type:'hidden',
      },
      {
        type:'hidden',
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
      },
      { 
        title:'DERRAMES \n VEHÍCULO',
        type: 'checkbox',
        width:100,
      },
      { 
        title:'DERRAMES \n CANECA',
        type: 'checkbox',
        width:100,
      },
      { 
        type:'hidden',
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

$(document).on('submit', '#formNew', function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    if (hasEmptyFields(table.getColumnData(0))) {
        toastr.error('Complete la columna PESO BRUTO');
        return
    };
    if (hasEmptyFields(table.getColumnData(1))) {
        toastr.error('Complete la columna PESO BRUTO CLIENTE');
        return
    };
    if (hasEmptyFields(table.getColumnData(6))) {
        toastr.error('Complete la columna ESTADO DEL TAMBOR');
        return
    };
    if (document.getElementById("formNew").checkValidity()) {
        $("#loading").show();
        data = $( "#formNew" ).serialize();
        table = table.getData();
        $.post( "?c=RM&a=Save", {data,table}).done(function(res) {
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