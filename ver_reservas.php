<?php
session_start();

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true || (!isset
($_SESSION["id_admin"]) || $_SESSION["id_admin"] == "")) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "usuario", "contraseña", "comedor_universitario");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT a.nombre AS nombre, a.apellido AS apellido, a.dni AS dni, a.estamento AS estamento,
sm.dia_semana AS dia_semana, sm.tipo AS tipo, f.nombre AS area, r.id AS id_reserva
FROM reservas r
JOIN alumnos a ON r.id_alumno = a.id
JOIN menu_semanal sm ON r.id_menu = sm.id
JOIN area f ON a.id_area = f.id";
$reservas_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservas</title>
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
			        <h1 class="text-titles"><i class="zmdi zmdi-card zmdi-hc-fw"></i> Buscar <small>Reservas</small></h1>
			    </div>
			    <p class="lead">En esta pantalla podrá visualizar las reservas.
                La búsqueda de reservas se debe realizar ingresando la fecha y el tipo (almuerzo o cena).</p>
		    </div>
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs" style="margin-bottom: 15px;">
					  	<li class="active"><a href="#new" data-toggle="tab">Buscar</a></li>
					  	<li><a href="#list" data-toggle="tab">Reservas</a></li>
					</ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="new">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-md-10 col-md-offset-1">
                                        <?php require_once "encabezado_buscar_reservas.php"; ?>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <h1 class="h3 mb-2 text-gray-800">Reservas</h1>
                                                <table class="table table-hover table-bordered border-secondary m-0" id="table" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Apellido</th>
                                                            <th>D.N.I.</th>
                                                            <th>Fecha</th>
                                                            <th>Tipo</th>
                                                            <th>Estamento</th>
                                                            <th>Área</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        <?php while ($row = $reservas_result->fetch_assoc()) { 
                                                            extract($row);
                                                            $fecha = date('d-m-Y', strtotime($dia_semana));
            
                                                            include ("datos_reserva.php");
                                                        } ?>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
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
    <script src="./js/tablas.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>