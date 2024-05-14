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

      extract($_REQUEST);
	   $fecha_reserva = $_GET['fecha_reserva'];
      $tipo_comida = $_GET["tipo_comida"];
      $fecha= date("d-m-Y", strtotime($fecha_reserva));
      $tipo= mb_convert_case($tipo_comida, MB_CASE_UPPER, "UTF-8");
      // var_dump($fecha_reserva);
      // var_dump($tipo_comida);

      $sql = "SELECT a.nombre AS nombre, a.apellido AS apellido, a.dni AS dni
      FROM reservas r
      JOIN menu_semanal sm ON r.id_menu = sm.id
      JOIN alumnos a ON r.id_alumno = a.id
      WHERE DATE(sm.dia_semana) = '$fecha_reserva' 
      AND sm.tipo = '$tipo_comida'";

      $result = $conn->query($sql);

      $total_row = mysqli_num_rows($result);

      $this->Image('logo.png', 270, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->Image('bie1.png', 10, 7, 50);
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(80); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->Cell(110, 15, utf8_decode('SISTEMA WEB DE RESERVAS'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color

      /* UBICACION */
      // $this->Cell(180);  // mover a la derecha
      // $this->SetFont('Arial', 'B', 10);
      // $this->Cell(96, 10, utf8_decode("Ubicación : "), 0, 0, '', 0);
      // $this->Ln(5);

      /* DIA */
      $this->Cell(180);  // mover a la derecha
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(95, 10, utf8_decode("FECHA : $fecha" ), 0, 0, '', 0);
      $this->Ln(5);

      /* TIPO */
      $this->Cell(180);  // mover a la derecha
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(95, 10, utf8_decode("TIPO DE MENU : $tipo"), 0, 0, '', 0);
      $this->Ln(5);

      /* CANTIDAD */
      $this->Cell(180);  // mover a la derecha
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(59, 10, utf8_decode("CANTIDAD DE RESERVAS : $total_row"), 0, 0, '', 0);
      $this->Ln(15);

      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(228, 100, 0);
      $this->Cell(90); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("RESERVAS "), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(228, 100, 0); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(20, 10, utf8_decode('Nº'), 1, 0, 'C', 1);
      $this->Cell(60, 10, utf8_decode('APELLIDO'), 1, 0, 'C', 1);
      $this->Cell(70, 10, utf8_decode('NOMBRE'), 1, 0, 'C', 1);
      $this->Cell(40, 10, utf8_decode('D.N.I'), 1, 0, 'C', 1);
      $this->Cell(48, 10, utf8_decode('ÁREA'), 1, 0, 'C', 1);
      $this->Cell(40, 10, utf8_decode('ESTAMENTO'), 1, 1, 'C', 1);
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(540, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

$conn = new mysqli("localhost", "usuario", "contraseña", "comedor_universitario"); //llamamos a la conexion BD
if ($conn->connect_error) {
   die("Conexión fallida: " . $conn->connect_error);
}

extract($_REQUEST);
$fecha_reserva = $_GET['fecha_reserva'];
$tipo_comida = $_GET["tipo_comida"];

$pdf = new PDF();
$pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 11);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

$fontSize=12; //definimos el comienzo font size

$sql = "SELECT a.nombre AS nombre, a.apellido AS apellido, a.dni AS dni,
a.estamento AS estamento, f.nombre AS area
FROM reservas r
JOIN menu_semanal sm ON r.id_menu = sm.id
JOIN alumnos a ON r.id_alumno = a.id
JOIN area f ON a.id_area = f.id
WHERE DATE(sm.dia_semana) = '$fecha_reserva' 
AND sm.tipo = '$tipo_comida'";

$result = $conn->query($sql);

$total_row = mysqli_num_rows($result);

while ($row = $result->fetch_assoc()) {  
   extract($row);
   $cellWidth = 48; //ancho de celda area
   $cellHeigth= 5; //altura normal de la celda de una linea area
   $i = $i + 1;
   /* TABLA */
   // $pdf->Cell(30, 10, utf8_decode($i), 1, 0, 'C', 0);// AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
   
   if($pdf->GetStringWidth($area) < $cellWidth ){
      $line=1;
   }else{
      //calcula la altura necesaria para la celda
      $textLength=strlen($area); //longitud total del texto
      $errMargin=15; //margen de error de ancho de celda
      $startChar=0; //Posición inicial del carácter para cada línea.
      $maxChar=0; // carácter máximo en una línea, que se incrementará más tarde
      $textArray=array();
      $tmpString="";

      while($startChar < $textLength){ //bucle hasta el final del texto
         //bucle hasta alcanzar el carácter máximo
         while($pdf->GetStringWidth( $tmpString) < ($cellWidth-$errMargin) &&
         ($startChar+$maxChar) < $textLength){
            $maxChar++;
            $tmpString=substr($area,$startChar,$maxChar);
         }
         //mover startChar a la siguiente línea
         $startChar = $startChar+$maxChar;
         //luego agregalo a la matriz para que sepamos cuántas líneas se necesitan
         array_push($textArray,$tmpString);
         //resetear maxchar y tmpString
         $maxChar=0;
         $tmpString='';
      }

      //obtener numero de linea
      $line=count($textArray);
   }

   //escribir las celdas
   $pdf->Cell(20, ($line * $cellHeigth), utf8_decode($i), 1, 0, 'C', 0); //adaptar altura o número de línea
   $pdf->Cell(60, ($line * $cellHeigth), utf8_decode($apellido), 1, 0, 'C', 0);
   $pdf->Cell(70, ($line * $cellHeigth), utf8_decode($nombre), 1, 0, 'C', 0);
   $pdf->Cell(40, ($line * $cellHeigth), utf8_decode($dni), 1, 0, 'C', 0);

   //use Multicell en lugar de celda, pero primero, debido a que Multicell 
   //siempre se trata como final de línea, debemos configurar manualmente 
   //la posición xy para que la siguiente celda esté al lado de ella.
   //recuerde la posición x e y antes de escribir el Multicell
   $xPos=$pdf->GetX();
   $yPos=$pdf->GetY();
   $pdf->Multicell($cellWidth,$cellHeigth,$area,1, 'C', 0);

   //devuelve la posición para la siguiente celda al lado de la Multicell y 
   //compensa la x con el ancho de la Multicell
   $pdf->SetXY($xPos + $cellWidth , $yPos);

   //adaptar la altura al número de líneas
   $pdf->Cell(40, ($line * $cellHeigth), utf8_decode($estamento), 1, 1, 'C', 0);
}


$pdf->Output('DescargarReserva.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
