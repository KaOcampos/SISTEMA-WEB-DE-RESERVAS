<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      $conn = new mysqli("localhost", "usuario", "contraseña", "comedor_universitario"); //conexion BD

      if ($conn->connect_error) {
          die("Conexión fallida: " . $conn->connect_error);
      }

      //$consulta_info = $conexion->query(" select *from hotel ");//traemos datos de la empresa desde BD
      //$dato_info = $consulta_info->fetch_object();
      $this->Image('logo.png', 140, 10, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->Image('bie2.png', 45, 9, 20);
      $this->SetFont('Arial', 'B', 12); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(37); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->Cell(110, 10, utf8_decode('SISTEMA WEB DE RESERVAS'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(2); // Salto de línea
      $this->SetTextColor(103); //color

      $this->SetFont('Arial', 'B', 12); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(37); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->Cell(110, 5, utf8_decode('COMEDOR UNIVERSITARIO'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(7); // Salto de línea
      $this->SetTextColor(103); //color

      /* COREEO */
      // $this->Cell(110);  // mover a la derecha
      // $this->SetFont('Arial', 'B', 10);
      // $this->Cell(85, 10, utf8_decode("Correo : "), 0, 0, '', 0);
      // $this->Ln(5);

      /* TELEFONO */
      // $this->Cell(110);  // mover a la derecha
      // $this->SetFont('Arial', 'B', 10);
      // $this->Cell(85, 10, utf8_decode("Sucursal : "), 0, 0, '', 0);
      // $this->Ln(10);

      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(228, 100, 0);
      $this->Cell(47); // mover a la derecha
      $this->SetFont('Arial', 'B', 12);
      $this->Cell(90, 5, utf8_decode("COMPROBANTE DE RESERVAS "), 0, 1, 'C', 0);
      $this->Ln(3);
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)
   }
}

$conn = new mysqli("localhost", "usuario", "contraseña", "comedor_universitario"); //llamamos a la conexion BD
if ($conn->connect_error) {
   die("Conexión fallida: " . $conn->connect_error);
}

extract($_REQUEST);
$id_reserva = $_GET['id_reserva'];
// var_dump($id_reserva);

$sql = "SELECT sm.dia_semana AS dia, sm.tipo AS tipo,
   a.nombre AS nombre, a.apellido AS apellido, a.usuario AS usuario, r.fecha_reserva AS fecha_reserva
   FROM reservas r
   JOIN menu_semanal sm ON r.id_menu = sm.id
   JOIN alumnos a ON r.id_alumno = a.id
   WHERE r.id = '$id_reserva'";

$result = $conn->query($sql);

$row = $result->fetch_assoc();
extract($row);

$fecha = date("d-m-Y", strtotime($dia));
$reservado = date ("d-m-Y H:i:s", strtotime($fecha_reserva));
$tipo_comida= mb_convert_case($tipo, MB_CASE_UPPER, "UTF-8");

$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

/*$consulta_reporte_alquiler = $conexion->query("  ");*/

/*while ($datos_reporte = $consulta_reporte_alquiler->fetch_object()) {      
   }*/
$i = $i + 1;
/* TABLA */
// $pdf->Multicell(0,5,"This is a multi-line text string \n New line \n New line", 0, 'C', 0); 
$pdf->Multicell(0, 7, utf8_decode("Apellido/s: $apellido \n Nombre/s: $nombre \n Usuario: $usuario \n Fecha de reserva: $reservado \n Fecha de menú: $fecha \n Tipo de menú: $tipo_comida"), 0, 'C', 0);

$pdf->Output('ComprobanteReservas.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
