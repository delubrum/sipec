<!DOCTYPE html>
<html lang="es">
<head>
  <title>SIPEC | Paquete de Despacho</title>
  <link rel="icon" sizes="192x192" href="assets/img/logo.png">
  <link rel="stylesheet" href="assets/css/adminlte.min.css">

  <style>
    .tabla th, .tabla td {
      border: 1px solid black;
      border-collapse: collapse;
      text-align:center;
    }

    body {
      background-image: url('assets/img/membrete.jpg');
      background-repeat: no-repeat;
      background-size: cover;4
    }

    .margin {
      padding-top:200px;
    }

  </style>
</head>
 
<body class="p-4">

  <p class="pt-4 mt-4">
  <?php 
    $meses = array(
      1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
      5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
      9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
    );

    // Fecha a formatear
    $fecha = $id->bcAt; // Cambia esto por la fecha que necesitas

    // Convierte la fecha en formato legible
    $timestamp = strtotime($fecha);
    $dia = date('j', $timestamp);
    $mes = $meses[date('n', $timestamp)];
    $año = date('Y', $timestamp);

    // Formatea la fecha en texto
    $fecha_formateada = "$dia de $mes de $año";

    // Imprime la fecha formateada
    echo $fecha_formateada; // Salida: 14 de agosto de 2023
  ?>
  </p>


  <section class="margin">
    <center>
    <table class="tabla" style="width:100%; margin-top:25px;">
      <tr>
        <th>Cliente</th>
        <th>Producto</th>
        <th>Lote</th>
        <th>RM</th>
      </tr>
      <tr>
        <td><?php echo $id->clientname ?></td>
        <td><?php echo $id->productname ?></td>
        <td><?php echo $id->bcId ?></td>
        <td><?php echo $id->id ?></td>

      </tr>
    </table>
    </center>
    <p>
    <h4 class="text-center mt-4">INFORME DE PROCESO DE RECUPERACIÓN</h4>
    <!-- <h5 class="text-center">
      <span>LOTE: <?php echo $id->bcId ?></span>
      <span>RM: <?php echo $id->id ?></span>
    </h5> -->
    </p>
    <center>
    <table class="tabla text-center" style="width:100%">
      <tr>
        <td style="width:50% !important">Peso bruto recibido</td>
        <td><?php echo $kg?></td>
      </tr>
      <tr>
        <td>Peso taras</td>
        <td><?php echo $tara?></td>
      </tr>
      <tr>
        <td>Pasta que no entra</td>
        <td><?php echo $id->paste?></td>
      </tr>
      <tr>
        <td>Peso materia prima para recuperar</td>
        <td><?php echo $net - $id->paste ?></td>
      </tr>
      <tr>
        <td>Peso material recuperado</td>
        <td><?php echo "%" ?></td>
      </tr>
      <tr>
        <td>Lodos del proceso</td>
        <td><?php echo $id->mud ?></td>
      </tr>
      <tr>
        <td>Destilado húmedo</td>
        <td><?php echo $id->distilled ?></td>
      </tr>
      <tr>
        <td>Perdida por evaporación</td>
        <td><?php echo $id->evaporation ?></td>
      </tr>
      <tr>
        <td>Porcentaje de Recuperación</td>
        <td><?php echo "%" ?></td>
      </tr>
    </table>

    <table class="tabla" style="width:100%; margin-top:25px;">
      <tr>
        <td>Lodos de Destilación %</td>
        <td>Húmedad %</td>
        <td>Evaporación %</td>
        
      </tr>
      <tr>
        <td><?php echo $id->mud_dist ?></td>
        <td><?php echo $id->mud_dist ?></td>
        <td><?php echo $id->mud_dist ?></td>
      </tr>
    </table>
    </center>
  </section>

  <section class="mt-4">
    <h4 class="text-center">CERTIFICADO DE ANÁLISIS</h4>
    <center>
    <table class="tabla" style="width:100%; margin-top:25px;">
      <tr>
        <th>PARAMETRO</td>
        <th>ESPECIFICACIÓN</td>
        <th>RESULTADO</td>
      </tr>
      <tr>
        <td>Apariencia</td>
        <td>Liquido Transparente</td>
        <td>Liquido Transparente</td>
      </tr>
      <tr>
        <td>Olor</td>
        <td>Característico</td>
        <td>Característico</td>
      </tr>
      <tr>
        <td>Densidad (g/ml)</td>
        <td>0.800 - 0.900</td>
        <td><?php echo "densidad" ?></td>
      </tr>
      <tr>
        <td>% Humedad</td>
        <td>4.90 - 9.50</td>
        <td><?php echo "humedadP" ?></td>
      </tr>
      <tr>
        <td>% PH</td>
        <td>5</td>
        <td>5</td>
      </tr>
    </table>
    <p>
      <i><b>Nota:</b> única humedad dado que los tambores están homogenizados, por lo tanto, la humedad es la misma en cada tambor.</i>
    </p>
    </center>

  </section>

  <section class="mt-4">
    <h4 class="text-center">RELACIÓN DE PESOS</h4>
    <center>
    <table class="tabla" style="width:100%;">
      <tr>
          <th style="width:40px">N°</th>
          <th>Peso</th>
          <th>Peso<br>Cliente</th>
          <th>Taras</th>
          <th>Taras<br>Cliente</th>
          <th>Neto</th>
          <th>Neto<br>Cliente</th>
      </tr>
      <?php 
      $i=0;$kg=0;$kg_client=0;$tara=0;$tara_client=0;$net=0;$net_client=0;
      $filters = "and rmId = " . $_REQUEST['id'];
      foreach($this->model->list('*','rm_items',$filters) as $r) {
      ?>
      </tr>
        <td><?php echo "<b>" . ($i+1) . "</b>" ?></td>
        <td><?php $kg += $r->kg; echo $r->kg ?></td>
        <td><?php $kg_client += $r->kg_client; echo $r->kg_client ?></td>
        <td><?php $tara += $r->tara; echo $r->tara ?></td>
        <td><?php $tara_client += $r->tara_client; echo $r->tara_client ?></td>
        <td><?php $net += $r->kg - $r->tara; echo $r->kg - $r->tara ?></td>
        <td><?php $net_client += $r->kg_client - $r->tara_client; echo $r->kg_client - $r->tara_client ?></td>      
      </tr>
      <?php $i++; } ?>
      <tr>
        <td><b>Σ</b></td>
        <td><?php echo "<b>$kg</b>" ?></td>
        <td><?php echo "<b>$kg_client</b>" ?></td>
        <td><?php echo "<b>$tara</b>" ?></td>
        <td><?php echo "<b>$tara_client</b>" ?></td>
        <td><?php echo "<b>$net</b>" ?></td>
        <td><?php echo "<b>$net_client</b>" ?></td>
      </tr>
    </table>  
    </center>
  </section>

  <section class="mt-4">
    <h4 class="text-center">CONTROL DE TAMBORES</h4>
    <center>
    <table class="tabla" style="width:100%;">
      <tr>
          <th style="width:120px">Tipo</th>
          <th>Prestamo</th>
          <th>Devolución</th>
          <th>Saldo Anterior</th>
          <th>Saldo Actual</th>
      </tr>
      </tr>
        <th>Plásticos</th>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>           
      </tr>
      </tr>
        <th>Metalicos</th>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>           
      </tr>
    </table>  
    </center>
  </section>

</body>
</html>

