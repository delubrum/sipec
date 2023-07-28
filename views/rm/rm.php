<form method="post" id="<?php echo $status ?>_form">
  <div class="modal-header">
  <h5 class="modal-title">RM : <b><?php echo $id->id ?></b></h5>
  <input type="hidden" name="id" value="<?php echo $id->id ?>">
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

    <div class="table-responsive p-0" style="height: 300px;width:100%">
      <table id="items" class="table-excel">
        <thead>
          <tr>
            <th style="width:40px">Nro</th>
            <th>Peso Bruto</th>
            <th>Estado</th>
            <th>Fugas</th>
            <th>Derrames</th>
            <th style='width:40px !important;cursor:pointer' <?php if($status == 'Registrando') { ?> class='add' data-id='<?php echo $id->id ?>' <?php } ?>" >
              <?php if($status == 'Registrando') { ?> 
                <i class="text-primary fas fa-plus"></i>
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
        { data: 'Status' },
        { data: 'Leaks' },
        { data: 'Spills' },
        { data: 'Action' }
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
        setTimeout( function () {
            $('.kg:last').focus();
            $('.kg:last').val('');
        }, 100 );
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

$(document).on('click','.spills', function(e) {
    $(this).toggleClass('btn-info btn-secondary');
	if ($(this).hasClass("btn-secondary")) {
		$(this).find('input').prop( "disabled", true );
    } else {
		$(this).find('input').prop( "disabled", false );
    }
});

$(document).on('submit', '#<?php echo $status ?>_form', function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    if (document.getElementById("<?php echo $status ?>_form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=RM&a=Update", $( "#<?php echo $status ?>_form" ).serialize()).done(function(res) {
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