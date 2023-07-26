<header>
    <script src="assets/plugins/inputmask/jquery.inputmask.min.js"></script>
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
</header>

<form method="post" id="client_form">
    <div class="modal-header">
        <h5 class="modal-title"><?php echo (isset($id)) ? 'Edit' : 'New'; ?> Client</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Name:</label>
                    <div class="input-group">
                        <input class="form-control" name="name" value="<?php echo isset($id) ? $id->name : '' ?>" required>
                        <input type="hidden" name="clientId" value="<?php echo isset($id) ? $id->id : '' ?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Company:</label>
                    <div class="input-group">
                    <input class="form-control" name="company" value="<?php echo isset($id) ? $id->company : '' ?>" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Email:</label>
                    <div class="input-group">
                    <input type="email" class="form-control" name="email" value="<?php echo isset($id) ? $id->email : '' ?>" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Tel 1:</label>
                    <div class="input-group">
                    <input class="form-control" name="tel1" value="<?php echo isset($id) ? $id->tel1 : '' ?>" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Tel 2:</label>
                    <div class="input-group">
                    <input class="form-control" name="tel2" value="<?php echo isset($id) ? $id->tel2 : '' ?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* City:</label>
                    <div class="input-group">
                    <input class="form-control" name="city" value="<?php echo isset($id) ? $id->city : '' ?>" required>
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
    dropdownParent: $('#lgModal')
});

$(document).ready(function() {
    $(":input").inputmask();
});

$('#client_form').on('submit', function(e) {
    e.preventDefault();
    if (document.getElementById("client_form").checkValidity()) {
        $("#loading").show();
        var formData = new FormData(this);
        $.ajax({
            url: "?c=Clients&a=Save",
            type: 'POST',
            data: formData,
            success: function (data) {
                $("#loading").hide();
                location.reload();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
});
</script>