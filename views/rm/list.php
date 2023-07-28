<table id="list" class="display table-striped text-md">
  <thead>
      <tr>
          <th>Fecha</th>
          <th>Cliente</th>
          <th>Producto</th>
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
            'url':'?c=RM&a=Data',
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
            { data: 'Date' },
            { data: 'Client' },
            { data: 'Product' },
            { data: 'Status' },
            { data: 'Action' }
        ]
    });
});

$(document).on("click", ".action", function() {
    id = $(this).data('id');
    status = $(this).data('status');
    $("#loading").show();
    $.post("?c=RM&a=RM",{id,status}).done(function(data){
        $("#loading").hide();
        $('#xlModal').modal('toggle');
        $('#xlModal .modal-content').html(data);
    });
});
</script>