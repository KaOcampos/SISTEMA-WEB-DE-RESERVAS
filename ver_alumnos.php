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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listado de Menús</title>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
	<link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/estilo.css">
</head>

<body>
    <?php require_once "parte_izquierda.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php require_once "parte_superior.php"; ?>
        <div class="container-fluid">
            <div class="container-fluid">
			    <div class="page-header">
			        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i> Buscar <small>Usuario</small></h1>
			    </div>
			    <p class="lead">En esta pantalla podrá visualizar los usuarios registrados.
                La búsqueda del usuario es ingresando el D.N.I. sin puntos(.).</p>
		    </div>
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs" style="margin-bottom: 15px;">
					  	<li class="active"><a href="#new" data-toggle="tab">Buscar</a></li>
					  	<li><a href="#list" data-toggle="tab">Usuario</a></li>
					</ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="new">
                            <div class="container-fluid">
                                <div class="row">
                                    <!-- <div class="col-xs-12 col-md-10 col-md-offset-1">  -->
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <div id="resultado" class="alert alert-info"></div>
                                                <h1 class="h3 mb-2 text-gray-800">Usuarios</h1>
                                                <table class="table table-hover table-bordered border-secondary m-0" id="tablax" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Apellido/s </th>
                                                            <th class="text-center">Nombre/s </th>
                                                            <th class="text-center">DNI </th>
                                                            <th class="text-center">Correo </th>
                                                            <th class="text-center">Estamento </th>
                                                            <th class="text-center">Área </th>
                                                            <th class="text-center">Operaciones </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $sql = "SELECT * FROM alumnos";
                                                        $result = $conn->query($sql);
                                                        while ($alumn = $result->fetch_assoc()) { 
                                                            extract($alumn);
                                                            $sql_area = "SELECT * FROM area WHERE id = $id_area";
                                                            $result_area = $conn->query($sql_area);
                                                            while($row = $result_area->fetch_assoc()){
                                                                $area = $row['nombre'];
                                                                include ("datos_alumnos.php");
                                                            }
                                                        } ?>
                                                    </tbody>
                                                </table>
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