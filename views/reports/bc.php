<!DOCTYPE html>
<html lang="es">
<head>
  <title>SIPEC | Bitacora</title>
  <link rel="icon" sizes="192x192" href="assets/img/logo.png">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <script src="https://adminlte.io/themes/v3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js"></script>
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

  <style>
    .tabla th, .tabla td {
      border: 1px solid black;
      border-collapse: collapse;
      padding:5px;
      text-align:center;
    }
</style>
</head>

<body class="p-4">

    <div class="row">    
    <table style='text-align:center;padding:0' class="mb-4 col-12">
        <tr>
        <td style='width:33%'><img style='width:200px' src='assets/img/logo2.png'></td>
        <td style='width:33%'><h1> BITACORA</h1></td>
        <td style='width:33%;font-size:18px'>
            <b>Código:</b> 
            <br>
            <b>Fecha:</b> 
            <br>
            <b>Versión:</b> 01
        </td>
        </tr>
    </table>
    </div>

    <div class="row mb-2">
        <div class="col-sm-1">
        <b>LOTE:</b> <?php echo $id->id?>
        </div>

        <div class="col-sm-1">
        <b>RM:</b> <?php echo $id->rmId?>
        </div>

        <div class="col-sm-3">
        <b>CLIENTE:</b> <?php echo $id->clientname?>
        </div>

        <div class="col-sm-3">
        <b>PRODUCTO:</b> <?php echo $id->productname?>
        </div>

        <div class="col-sm-2">
        <b>REACTOR:</b> <?php echo $qty?>
        </div>

        <div class="col-sm-2">
        <b>TIPO:</b> <?php echo $id->type ?>
        </div>
    </div>

    <div class="row mb-2">

        <div class="col-sm-2">
        <b>LODOS DEL PROCESO:</b> <?php echo $id->mud ?>
        </div>

        <div class="col-sm-3">
        <b>DESTILADO HUMEDO:</b> <?php echo $id->distilled ?>
        </div>

        <div class="col-sm-3">
        <b>LODOS DE DESTILACIÓN:</b> <?php echo $id->mud_dist ?>
        </div>

        <div class="col-sm-4">
        <b>PERDIDA POR EVAPORACIÓN:</b> <?php echo $id->evaporation ?>
        </div>

    </div>

    <div class="row mb-2">
        <div class="col-sm-2">
        <b>AGUA INICIAL:</b> <?php echo $id->water_0 ?>
        </div>

        <div class="col-sm-2">
        <b>AGUA FINAL:</b> <?php echo $id->water_1 ?>
        </div>


        <div class="col-sm-2">
        <b>GAS INICIAL:</b> <?php echo $id->gas_0 ?>
        </div>

        <div class="col-sm-2">
        <b>GAS FINAL:</b> <?php echo $id->gas_1 ?>
        </div>

        <div class="col-sm-2">
        <b>ENERGÍA INICIAL:</b> <?php echo $id->energy_0 ?>
        </div>

        <div class="col-sm-2">
        <b>ENERGÍA FINAL:</b> <?php echo $id->energy_1 ?>
        </div>
    </div>

    <div class="row my-4">

        <div class="col-12">
        <b>NOTAS:</b> <?php echo $id->energy_1 ?>
        </div>

    </div>

    <table class="tabla mb-4" style="width:100%">
        <tr>
            <th style="width:40px">Turno</th>
            <th>Inicio</th>
            <th>Fin</th>
        </tr>
        <?php  $i=0; foreach($this->init->list("*","bc_turns","and bcId = $id->id") as $r) { ?>
        <tr>
            <td><?php echo "<b>" . $i+1 . "</b>" ?></td>
            <td><?php echo $r->start ?></td>
            <td><?php echo $r->end ?></td>
        </tr>
        <?php $i++; } ?>
    </table>   

    <table class="tabla" style="width:100%">
        <tr>
            <th>Date</th>
            <th style="width:40px">N°</th>
            <th>Peso</th>
            <th>Tambor</th>
            <th>Hora Inicio</th>
            <th>Hora Fin</th>
            <th>T° Inicio</th>
            <th>T° Fin</th>
            <th>Hora Caldera</th>
            <th>T° Caldera</th>
            <th>Responsable</th>
        </tr>
        <?php  
        $i=0;
        foreach($this->init->list("a.*, b.username","bc_items a","and bcId = $id->id", "LEFT JOIN users b on a.userId = b.id") as $r) {
            $index = ($i == 0) ? 'Cabeza' : $i;
            $net = ($i == 0) ? '' : $r->net;
            $drum = ($i == 0) ? '' : $r->drum;
        ?>
        <tr>
            <td><?php echo $r->date ?></td>
            <td><?php echo "<b>" . $index . "</b>" ?></td>
            <td><?php echo $net ?></td>
            <td><?php echo $drum ?></td>
            <td><?php echo $r->start ?></td>
            <td><?php echo $r->end ?></td>
            <td><?php echo $r->t_0 ?></td>
            <td><?php echo $r->t_1 ?></td>
            <td><?php echo $r->boiler_time ?></td>
            <td><?php echo $r->boiler_t ?></td>
            <td><?php echo $r->username ?></td>
        </tr>
        <?php $i++; } ?>
        </tr>
    </table>    
