<form method="post" id="form">
  <div class="modal-header">
  <h5 class="modal-title">RM : <b><?php echo $id->id ?></b></h5>
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
                <dt><i class="fas fa-info-circle"></i> ID:</dt>
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

    <div class="table-responsive p-0" style="width:100%">
      <table id="items" class="table-excel">
        <thead>
            <tr>
                <th style="width:40px">N°</th>
                <th>Peso</th>
                <th>Peso<br>Cliente</th>
                <?php if($status != 'Registrando') { ?>
                <th>Taras</th>
                <th>Taras<br>Cliente</th>
                <th>Neto</th>
                <th>Neto<br>Cliente</th>
                <?php } ?> 
                <th>Estado</th>
                <th>Fugas</th>
                <th>Derrames</th>
                <?php if($status == 'Registrando') { ?> 
                <th style='width:40px !important;cursor:pointer' <?php if($status == 'Registrando') { ?> class='add' data-id='<?php echo $id->id ?>' <?php } ?>" >
                    <i class="text-primary fas fa-plus"></i>
                </th>
                <?php } ?> 
            </tr>
        </thead>
      </table>    
    </div>

    
    <?php if($status != 'Registrando') { ?>
    <div class="row mt-4">
        <div class="col-sm-3">
            <div class="form-group">
                <label>* Fecha Y Hora Cargue:</label>
                <div class="input-group">
                <input type="datetime-local" class="form-control inputRM" value="<?php echo (isset($id)) ? $id->datetime : ''; ?>"" required>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label>* Responsable:</label>
                <div class="input-group">
                    <select class="form-control inputRM" required>
                        <option value=''></option>
                        <?php foreach ($this->init->list('*','operators',' and status = 1') as $r) { ?>     
                            <option value='<?php echo $r->id?>'><?php echo $r->name?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Reactor N°:</label>
                <div class="input-group">
                <input type="number" step="1" min="1" class="form-control inputRM" value="<?php echo (isset($id)) ? $id->reactor : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Pasta que no Entra:</label>
                <div class="input-group">
                <input type="number" step="0.01" class="form-control inputRM" id="paste" value="<?php echo $id->paste ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>* Total a Cargar:</label>
                <div class="input-group">
                <input type="number" step="0.01" class="form-control" id="total" value="<?php echo $id->paste * $net ?>" readonly>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label>Notas:</label>
                <div class="input-group">
                <textarea style="width:100%" class="form-control form-control-sm inputRM" type="number"><?php echo (isset($id)) ? $id->notes : ''; ?></textarea>
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
    'ajax': {
        'url':'?c=RM&a=ItemsData&id=<?php echo $id->id ?>&status=<?php echo $status ?>',
        'dataSrc': function (json) {
            // Check if the data array is not empty or null
            if (json != '') {
                return json;
            } else {
                // Hide the table if there is no data
                $('#example').hide();
                console.log('No data available for DataTables.');
                return []; // Return an empty array to prevent rendering
            }
        },
    },
    'columns': [
        { data: 'Index' },
        { data: 'kg' },
        { data: 'kg_client' },
        <?php if($status != 'Registrando') { ?> 
        { data: 'tara' },
        { data: 'tara_client' },
        { data: 'net' },
        { data: 'net_client' },
        <?php } ?> 
        { data: 'Status' },
        { data: 'Leaks' },
        { data: 'Spills' },
        <?php if($status == 'Registrando') { ?> 
        { data: 'Action' }
        <?php } ?> 
    ],
});
setTimeout( function () {
    table.draw();
}, 200 );

});


$(document).on("click", ".add", function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    id = $(this).data('id');
    $("#loading").show();
    $.post("?c=RM&a=SaveItem",{id}).done(function(data){
        $("#loading").hide();
        table.ajax.reload( null, false );
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
            $.post("?c=RM&a=DeleteItem",{id}).done(function(data){
                $("#loading").hide();
                table.ajax.reload( null, false );
            });
        }
    })
});

$(document).on("change", ".input", function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    id = $(this).data('id');
    field = $(this).data('field');
    value = $(this).val();
    $("#loading").show();
    $.post("?c=RM&a=UpdateItem",{id,field,value}).done(function(data){
        $("#loading").hide();
        table.ajax.reload( null, false );
    });
});

$(document).on("click", ".spills", function(e) {
    $(this).toggleClass('btn-info btn-secondary');
    e.stopImmediatePropagation();
    e.preventDefault();
    id = $(this).parent().data('id');
    field = 'spills';
    const arr = [];
    $(this).parent().find('.spills').each(function() {
        if($(this).hasClass('btn-info')){
            arr.push($(this).html());
        }
    });
    const value = JSON.stringify(arr);
    $("#loading").show();
    $.post("?c=RM&a=UpdateItem",{id,field,value}).done(function(data){
        $("#loading").hide();
        table.ajax.reload( null, false );
    });
});


$(document).on("change", "#paste", function(e) {
    paste = $('#paste').val();
    net = <?php echo $net ?>;
    total = Number(net) - Number(paste);
    $('#total').val(total)
});

$(document).on('submit', '#form', function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
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