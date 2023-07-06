<header>
    <script src="assets/plugins/inputmask/jquery.inputmask.min.js"></script>
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>

</header>

<form method="post" id="Purchases_Form">
    <div class="modal-header">
        <h5 class="modal-title">Nueva Compra</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
            <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Producto</label>
                                <div class="input-group">
                                    <select class="form-control select2" style="width:100%" name="productId" required>
                                        <option value=''></option>
                                        <?php foreach($this->products->list('and active = 1') as $r) { 
                                             $description = mb_convert_case($r->description, MB_CASE_TITLE, "UTF-8");
                                             $size = mb_convert_case($r->size, MB_CASE_UPPER, "UTF-8");
                                             $color = mb_convert_case($r->color, MB_CASE_UPPER, "UTF-8");
                                             $price = $r->price;
                                            ?>
                                        <option value='<?php echo $r->id ?>'><?php echo "$r->code / $description / $size / $color / $$price" ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Cantidad</label>
                                <div class="input-group">
                                    <input type="number" name="qty" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Precio de Compra (ud)</label>
                                <div class="input-group">
                                    <input id="price"
                                        data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                                        class="form-control" name="price" placeholder="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Notas</label>
                                <div class="input-group">
                                    <input class="form-control" name="notes">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $(":input").inputmask();
    $('.select2').select2()
});
</script>