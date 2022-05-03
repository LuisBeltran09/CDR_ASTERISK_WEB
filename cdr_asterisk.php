<?php

include("config.php");

//Filtros mysql para consultar las llamadadas en: ultimo año, ultima semana y por meses//
$sqlfiltros = [
    "s"   => ' AND YEAR(NOW()) = YEAR(calldate) AND WEEK(NOW()) = WEEK(calldate)',
    "m1"  => 'AND YEAR(NOW()) = YEAR(calldate) AND MONTH(calldate)= 1',
    "m2"  => 'AND YEAR(NOW()) = YEAR(calldate) AND MONTH(calldate)= 2',
    "m3"  => 'AND YEAR(NOW()) = YEAR(calldate) AND MONTH(calldate)= 3',
    "m4"  => 'AND YEAR(NOW()) = YEAR(calldate) AND MONTH(calldate)= 4',
    "m5"  => 'AND YEAR(NOW()) = YEAR(calldate) AND MONTH(calldate)= 5',
    "m6"  => 'AND YEAR(NOW()) = YEAR(calldate) AND MONTH(calldate)= 6',
    "m7"  => 'AND YEAR(NOW()) = YEAR(calldate) AND MONTH(calldate)= 7',
    "m8"  => 'AND YEAR(NOW()) = YEAR(calldate) AND MONTH(calldate)= 8',
    "m9"  => 'AND YEAR(NOW()) = YEAR(calldate) AND MONTH(calldate)= 9',
    "m10" => 'AND YEAR(NOW()) = YEAR(calldate) AND MONTH(calldate)= 10',
    "m11" => 'AND YEAR(NOW()) = YEAR(calldate) AND MONTH(calldate)= 11',
    "m12" => 'AND YEAR(NOW()) = YEAR(calldate) AND MONTH(calldate)= 12',
    "a"   => 'AND YEAR(NOW()) = YEAR(calldate)',
];

$f = $_GET['f'];

//Mensajes para mostrar cada vez que se consulte que llamadas se han realizado//

$mensajesfiltros = [
    "s"   => 'de la semana actual',
    "m1"  => 'realizadas en enero',
    "m2"  => 'realizadas en febrero',
    "m3"  => 'realizadas en marzo',
    "m4"  => 'realizadas en abril',
    "m5"  => 'realizadas en mayo',
    "m6"  => 'realizadas en junio',
    "m7"  => 'realizadas en julio',
    "m8"  => 'realizadas en agosto',
    "m9"  => 'realizadas en septiembre',
    "m10" => 'realizadas en octubre',
    "m11" => 'realizadas en noviembre',
    "m12" => 'realizadas en diciembre',
    "a"   => 'del año actual',
];

//Valor por defecto de f//

if (!$f) {

    $f = "s";
}

//Condición que se debe de cumplir para que el valor introducido de f sea válido//

if (!array_key_exists($f, $sqlfiltros)) {
    echo "El filtro introducido es incorrecto";
    exit;
}

?>

<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<!--Popper and Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <title>Registro de Llamadas</title>

</head>

<nav>
<div class="position-absolute top-0 start-0 mx-4 my-4">
    <img src="images/2849835_phone_telephone_cell_call_communication_icon.png" style="width: 70px">
</div>
</nav>

<body>

<div class="dropdown position-absolute top-0 end-0 m-4" >

  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">

   Filtrar

  </button>

  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    <li><a class="dropdown-item" href="?f=s">Semana actual</a></li>
    <li><a class="dropdown-item" href="?f=a">Año actual</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><h5 class="dropdown-header">Por meses</h5></li>
    <li><a href="?f=m1" class="dropdown-item">Enero</a></li>
    <li><a href="?f=m2" class="dropdown-item">Febrero</a></li>
    <li><a href="?f=m3" class="dropdown-item">Marzo</a></li>
    <li><a href="?f=m4" class="dropdown-item">Abril</a></li>
    <li><a href="?f=m5" class="dropdown-item">Mayo</a></li>
    <li><a href="?f=m6" class="dropdown-item">Junio</a></li>
    <li><a href="?f=m7" class="dropdown-item">Julio</a></li>
    <li><a href="?f=m8" class="dropdown-item">Agosto</a></li>
    <li><a href="?f=m9" class="dropdown-item">Septiembre</a></li>
    <li><a href="?f=m10" class="dropdown-item">Octubre</a></li>
    <li><a href="?f=m11" class="dropdown-item">Noviembre</a></li>
    <li><a href="?f=m12" class="dropdown-item">Diciembre</a></li>

  </ul>
</div>

<p class="text-center fs-1 fw-bold m-4" style="color: #075ec5;">

    Registro de llamadas

</p>

<div class="table-responsive p-5" >

<p class="text-center fs-6" >
<em>
    Mostrando llamadas <?php echo $mensajesfiltros[$f]; ?>
</em>
</p>

    <table class="table table-hover table-bordered border-primary table table-sm " >
        <tr class="table text-white" style="background-color:#008BFF ;" >

            <th>Fecha-Hora</th>
            <th>Identificador</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Duración</th>
            <th>Estado</th>

        </tr>

<?php

try {
    $mbd = new PDO('mysql:host=192.168.254.110;dbname=asteriskpbx', $userdb, $password);
    foreach ($mbd->query('SELECT * FROM asteriskpbx.cdr WHERE lastapp = "Dial"' . $sqlfiltros[$f] .
        ' ORDER BY calldate DESC ') as $fila) {

        /* Array ( [calldate] => 2022-04-25 13:26:56 [0] => 2022-04-25 13:26:56
        [clid] => "Irekisoft" <40> [1] => "Irekisoft" <40> [src] => 40 [2] => 40 [dst] => 35 [3] => 35
        [dcontext] => from-repelega [4] => from-repelega [channel] => PJSIP/40-00000000 [5] => PJSIP/40-00000000
        [dstchannel] => [6] => [lastapp] => Hangup [7] => Hangup [lastdata] => [8] => [duration] => 0 [9] => 0
        [billsec] => 0 [10] => 0 [disposition] => ANSWERED [11] => ANSWERED [amaflags] => 3 [12] => 3
        [accountcode] => [13] => [uniqueid] => 1650886002.0 [14] => 1650886002.0 [userfield] => [15] => )
         */

        echo "<tr>";

        echo "<td>" . $fila["calldate"] . "</td>";
        echo "<td>" . $fila["clid"] . "</td>";
        echo "<td>" . $fila["src"] . "</td>";
        echo "<td>" . $fila["dst"] . "</td>";
        echo "<td>" . $fila["duration"] . "</td>";
        echo "<td>" . $fila["disposition"] . "</td>";

        echo "</tr>";

    }

    $mbd = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>

    </table>

</div>
</body>
</html>
