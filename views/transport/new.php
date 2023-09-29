<header>
    <script src="assets/plugins/inputmask/jquery.inputmask.min.js"></script>
</header>

<form method="post" id="formNew">
    <div class="modal-header">
        <h5 class="modal-title">Nuevo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="row">

            <div class="col-sm-4">
                <div class="form-group">
                    <label>* Responsable:</label>
                    <div class="input-group">
                        <input class="form-control" name="user" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>* Punto de Origen:</label>
                    <div class="input-group">
                        <input class="form-control" name="start" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>* Punto de Destino:</label>
                    <div class="input-group">
                        <input class="form-control" name="end" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>* RM:</label>
                    <div class="input-group">
                        <input type="number" step="1" min="1" class="form-control" name="rm" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>* Cantidad de Tambores:</label>
                    <div class="input-group">
                        <input type="number" step="1" min="1" class="form-control" name="qty" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>* Kg:</label>
                    <div class="input-group">
                        <input data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'" class="form-control" name="kg" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>* Factura:</label>
                    <div class="input-group">
                        <input class="form-control" name="invoice" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>* Valor:</label>
                    <div class="input-group">
                        <input data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 0, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'" class="form-control" name="price" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label>* Notas:</label>
                    <div class="input-group">
                        <textarea class="form-control" name="notes" style="width:100%"></textarea>
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
    $(":input").inputmask();
});


$(document).on('submit', '#formNew', function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    if (document.getElementById("formNew").checkValidity()) {
        $("#loading").show();
        $.post( "?c=Transport&a=Save",  $( "#formNew" ).serialize()).done(function(res) {
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