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

$salida="";
        $id_reserva = $_POST['ids'];

        foreach($id_reserva as $valor){
            $sql = "UPDATE reservas SET asistencia = 1 WHERE id = $valor";
            if ($conn->query($sql) === TRUE) {
                $salida= "Asistencia registrada.";
            } else {
                $salida= "Error al registrar la asistencia " . $conn->error;
            }
        }

        echo $salida;
?>
