<header>
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
</header>

<form method="post" id="form">
    <div class="modal-header">
        <h5 class="modal-title"><?php echo (isset($id)) ? 'Editar' : 'Nuevo'; ?> Recibo</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>* Ciudad:</label>
                    <div class="input-group">
                        <input class="form-control" name="city" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>* Cliente:</label>
                    <div class="input-group">
                        <select class="form-control select2" name="clientId" id="client" style="width: 100%;" required>
                            <option value=''></option>
                            <?php foreach ($this->init->list('*','clients',' and status = 1') as $r) { ?>     
                                <option value='<?php echo $r->id?>'><?php echo $r->company?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label>* Producto:</label>
                    <div class="input-group">
                    <select class="form-control" name="productId" id="product" required>
                        <option>Seleccione el Cliente...</option>
                    </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label>* Fecha:</label>
                    <div class="input-group">
                    <input type="date" class="form-control" name="date" min="<?php echo date('Y-m-d', strtotime('-2 days')); ?>">
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><?php echo (isset($id)) ? 'Update' : 'Add'; ?></button>
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
    select.select2();
  }, "json");
});

$(document).on('submit', '#form', function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    if (document.getElementById("form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=RM&a=Save", $( "#form" ).serialize()).done(function(res) {

            var res = $.parseJSON(res);
            id = res.id;
            status = res.status;
            $.post( "?c=RM&a=RM", {id,status}).done(function( data ) {
                $('#xsModal').modal('toggle');
                $("#loading").hide();
                $('#xlModal').modal('toggle');
                $('#xlModal .modal-content').html(data);
                $( "#example" ).load(window.location.href + " #example" );                
            });
            
        });
    }
});
</script>