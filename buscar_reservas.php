<?php
session_start();

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true || (!isset
($_SESSION["id_admin"]) || $_SESSION["id_admin"] == "")) {
    header("Location: login.php");
    exit;
}

$buscar=$_REQUEST['fecha_reserva'];

if ($buscar == '') {
    header("Location: ver_reservas.php");
        // echo'<p>No se pudo acceder al contenido del menu.</p>';
            
}

$conn = new mysqli("localhost", "usuario", "contraseña", "comedor_universitario");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buscar"])) {
    $fecha_reserva = $_POST["fecha_reserva"];
    $tipo_comida = $_POST["tipo_comida"];

    // Seleccionar todas las reservas y los datos relacionados con los menús y los alumnos
    $sql = "SELECT a.nombre AS nombre, a.apellido AS apellido, a.dni AS dni, a.estamento AS estamento,
        f.nombre AS area, sm.dia_semana AS dia_semana, sm.tipo AS tipo, r.id AS id_reserva 
        FROM reservas r
        JOIN menu_semanal sm ON r.id_menu = sm.id
        JOIN alumnos a ON r.id_alumno = a.id
        JOIN area f ON a.id_area = f.id
        WHERE DATE(sm.dia_semana) = '$fecha_reserva' 
        AND sm.tipo = '$tipo_comida'";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buscar Reservas</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
	<link rel="stylesheet" href="./css/main.css">
</head>
<body>

    <?php require_once "parte_izquierda.php"; ?>    

    <section class="full-box dashboard-contentPage">
        <?php require_once "parte_superior.php"; ?>
            <div class="container-fluid">
                <div class="container-fluid">
			        <div class="page-header">
			            <h1 class="text-titles"><i class="zmdi zmdi-card zmdi-hc-fw"></i> Resultado <small>de la búsqueda</small></h1>
			        </div>
		        </div>
			    <div class="row">
				    <div class="col-xs-12">
					    <ul class="nav nav-tabs" style="margin-bottom: 15px;">
					  	    <li class="active"><a href="#new" data-toggle="tab">Búsqueda</a></li>
					  	    <li><a href="#list" data-toggle="tab"> Reservas</a></li>
					    </ul>
					    <div id="myTabContent" class="tab-content">
						    <div class="tab-pane fade active in" id="new">
						    	<div class="container-fluid">
						    		<div class="row">
						    			<!-- <div class="col-xs-12 col-md-10 col-md-offset-1"> -->
                                            <?php require_once "encabezado_buscar_reservas.php"; ?>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <?php $total_row = mysqli_num_rows($result);
                                                    if($result && $total_row > 0){?>
                                                    <?php $fecha = date("d-m-Y", strtotime($fecha_reserva));?>
                                                        <h1 class="h3 mb-2 text-gray-800">Reservas de: <?php echo $tipo_comida ?> del día <?php echo $fecha ?></h1>
                                                        <div class="text-right">
                                                            <a href="fpdf/descargar_reservas.php?fecha_reserva=<?php echo $fecha_reserva ?>&tipo_comida=<?php echo $tipo_comida; ?>" target="_blank" class="btn btn-success btn-raised btn-xs">
                                                            <i class="fa fa-file-pdf"></i>Descargar </a>
                                                        </div>
                                                        <table class="table table-hover table-bordered border-secondary m-0" id="table" width="100%" cellspacing="0">    
                                                            <thead>
                                                                <tr>
                                                                    <th>Apellido</th>
                                                                    <th>Nombre</th>
                                                                    <th>D.N.I.</th>
                                                                    <th>Fecha</th>
                                                                    <th>Tipo</th>
                                                                    <th>Estamento</th>
                                                                    <th>Área</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php while ($row = $result->fetch_assoc()) {
                                                                    extract($row);
                                                                    include ("datos_reserva.php");
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                        <p class="text-center">
			                                                <button href="#!" class="btn btn-info btn-raised btn-sm" type="submit" name="submit" onclick="guardarReserva()"><i class="zmdi zmdi-floppy"></i> Guardar</button>
		                                                </p>
                                                    <?php }else {
                                                        $fecha = date('d-m-Y', strtotime($fecha_reserva));
                                                        echo "<article class='full-box tile'>
                                                            <div class='full-box tile-title text-center text-titles text-uppercase'>
                                                                <small>No se encontraron reservas para el dia $fecha</small>
                                                            </div>
                                                            <div class='full-box tile-number text-titles'>
                                                                <p class='full-box'>0</p>
                                                                <small>Registros</small>
                                                            </div>
                                                        </article>";
                                                    } ?>
                                                </div>
                                            </div>
						    		    <!-- </div> -->
						    	    </div>
						        </div>
					        </div>
			            </div>
                    </div>
                </div>
            </div>
        </section>
<?php } ?>

    <!--====== Scripts -->
	<script src="./js/jquery-3.1.1.min.js"></script>
	<script src="./js/sweetalert2.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script src="./js/material.min.js"></script>
	<script src="./js/ripples.min.js"></script>
	<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="./js/main.js"></script>
	<script>
		$.material.init();
	</script>
    <script src="./js/codigo_java.js"></script>
    <script src="./js/tablas.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
