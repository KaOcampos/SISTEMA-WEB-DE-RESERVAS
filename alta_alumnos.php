<?php
session_start();

$conn = new mysqli("localhost", "usuario", "contraseña", "comedor_universitario");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true || (!isset
($_SESSION["id_admin"]) || $_SESSION["id_admin"] == "")) {
    
        echo'<section class="full-box dashboard-contentPage">
        
            <div class="container-fluid">
                <div class="container-fluid">
                    <div class="page-header">
                        <h1 class="text-titles">
                            <a href="login.php">
                                <i class="zmdi zmdi-arrow-left"></i>
                            </a>
                            <i class="zmdi zmdi-account zmdi-hc-fw"></i> Registrar <small>Usuario</small></h1>
                    </div>
                    <p class="lead">Ingresé los datos para registrar a un nuevo usuario.
                    Deberá registrar el numero de DNI sin puntos (.)</p>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                            <li class="active"><a href="#new" data-toggle="tab"></a></li>
                            <li><a href="#list" data-toggle="tab"></a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="new">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                                            <div id="resultado" class="alert alert-info"></div>';
                                            require_once "registro_alumno.php";
                                    echo '</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>';    
    }else{
        require_once "parte_izquierda.php";
        echo'<section class="full-box dashboard-contentPage">';
        require_once "parte_superior.php";
            echo'<div class="container-fluid">
                <div class="container-fluid">
                    <div class="page-header">
                        <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Registrar <small>Usuario</small></h1>
                    </div>
                    <p class="lead">Ingresé los datos para registrar a un nuevo usuario.</p>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                            <li class="active"><a href="#new" data-toggle="tab">Nuevo</a></li>
                            <li><a href="#list" data-toggle="tab">Usuario</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="new">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                                            <div id="resultado" class="alert alert-info"></div>'; 
                                            require_once "registro_alumno.php";
                                    echo '</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>';
    }    

?>

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
    <script src="./js/registro_alumno.js"></script>

<?php
$conn->close();
?>