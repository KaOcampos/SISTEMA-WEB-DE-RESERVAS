<?php
session_start();

$conn = new mysqli("localhost", "usuario", "contraseña", "comedor_universitario");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true || (!isset
($_SESSION["id_admin"]) || $_SESSION["id_admin"] == "")) {
	session_destroy();
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM alumnos";
$result = $conn->query($sql);
$total_row = mysqli_num_rows($result);

$sql_admin = "SELECT * FROM administradores";
$result_admin = $conn->query($sql_admin);
$row_admin = mysqli_num_rows($result_admin);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel de Administración</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="./css/main.css">
</head>
<body>
	<?php require_once "parte_izquierda.php"; ?>

    <section class="full-box dashboard-contentPage">
	<?php require_once "parte_superior.php"; ?>
		<div class="full-box text-center" style="padding: 30px 10px;">
			<article class="full-box tile">
				<div class="full-box tile-title text-center text-titles text-uppercase">
					Administradores
				</div>
				<div class="full-box tile-icon text-center">
					<i class="zmdi zmdi-account"></i>
				</div>
				<div class="full-box tile-number text-titles">
					<p class="full-box"><?php echo $row_admin; ?></p>
					<small>Registros</small>
				</div>
			</article>
			<article class="full-box tile">
				<div class="full-box tile-title text-center text-titles text-uppercase">
					Usuarios
				</div>
				<div class="full-box tile-icon text-center">
					<i class="zmdi zmdi-face"></i>
				</div>
				<div class="full-box tile-number text-titles">
					<p class="full-box"><?php echo $total_row; ?></p>
					<small>Registros</small>
				</div>
			</article>
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

</body>
</html>

<?php
$conn->close();
?>
