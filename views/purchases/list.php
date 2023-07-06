<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Fecha</th>
            <th>Producto</th>
            <th>Categoria</th>
            <th>Cantidad</th>
            <th>Precio de Compra (ud)</th>
            <th>Total Pagado</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->purchases->list() as $r) { ?>
        <tr>
            <td><?php echo $r->id ?></td>
            <td><?php echo $r->createdAt ?></td>
            <td><?php echo $r->code ?> <?php echo $r->description ?></td>
            <td><?php echo $r->name ?></td>
            <td><?php echo $r->qty ?></td>
            <td><?php echo number_format($r->price,2) ?></td>
            <td><?php echo number_format($r->price*$r->qty,2) ?></td>
            <td><?php echo $r->notes ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>