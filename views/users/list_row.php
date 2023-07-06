<table id="example" class="display nowrap">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $r) { ?>
        <tr>
            <td><?php echo $r->id; ?></td>
            <td>
                <?php echo $r->username; ?>
            </td>
            <td><?php echo $r->email; ?></td>
            <td><?php echo $r->createdAt; ?></td>
            <td class="text-right">
                <button type="button" class="btn btn-primary edit" data-toggle="tooltip" data-placement="top" data-status='process' data-id="<?php echo $r->id; ?>" title="Edit"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger cancel" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Deactivate"><i class="fas fa-trash"></i></button>

            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script>

$(document).on('click','.cancel', function(e) {
    id = $(this).data("id");
    e.preventDefault();
    Swal.fire({
        title: 'Deactivate this User?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=Users&a=Deactivate", { id }).done(function( res ) {
                location.reload();
            });
        }
    })
});
</script>