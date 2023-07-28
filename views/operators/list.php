<table id="list" class="display table-striped text-md">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Status</th>
            <th class="text-right">Acción</th>
        </tr>
    </thead>
</table>

<script>
$(document).ready(function() {
    var table = $('#list').DataTable({
        'order': [[1, 'asc']],
        'lengthChange' : false,
        'paginate': false,
        'scrollX' : true,
        'autoWidth' : false,
        'ajax': {
            'url':'?c=Operators&a=Data',
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
            { data: 'Name' },
            { data: 'Status' },
            { data: 'Action' }
        ]
    });
});

$(document).on('click','.status', function(e) {
    id = $(this).data("id");
    status = $(this).data("status");
    $("#loading").show();
    $.post("?c=Operators&a=Status", { id,status }).done(function( res ) {
        location.reload();
    });
});
</script>