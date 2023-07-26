<table id="listTable" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Empresa</th>
            <th>Email</th>
            <th>Tel 1</th>
            <th>Tel 2</th>
            <th>Ciudad</th>
            <th class="text-right">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->clients->list() as $r) { ?>
        <tr>
            <td><?php echo $r->id; ?></td>
            <td><?php echo $r->name; ?></td>
            <td><?php echo $r->company; ?></td>
            <td><?php echo $r->email; ?></td>
            <td><?php echo $r->tel1; ?></td>
            <td><?php echo $r->tel2 ?></td>
            <td><?php echo $r->city ?></td>
            <td class="text-right">
                <button type="button" class="btn btn-primary new" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Editar"><i class="fas fa-edit"></i></button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>