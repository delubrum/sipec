<div class="modal-header">
    <h5 class="modal-title">Rejections</b></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table id="itemsTable" class="table table-head-fixed table-striped table-hover" style="width:100%">
    <tr>
        <th>Date</th>
        <th>Cause</th>
        <th>User</th>
    </tr>
    <?php foreach($this->init->RejectList($type,$id) as $reject) { ?>
    <tr>
        <td style="width:20%"><?php echo $reject->createdAt ?></td>
        <td style="text-align:justify"><?php echo $reject->cause ?></td>
        <td style="width:20%"> <?php echo $reject->username; ?>
    </tr>
    <?php } ?>
    </table>
</div>