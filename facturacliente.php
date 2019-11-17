<?php
session_start();
$username=10 ;  
$codigo=$_POST["codigo"];
$usuarioactivo=$_SESSION["usuarioactivo"];
if ($usuarioactivo==1) {
include_once 'TCPDF-master/tcpdf.php';
    include("conexion.php");
    // Extend the TCPDF class to create custom Header and Footer
    class MYPDF extends TCPDF {

        // Page footer
        public function Footer() {
            // Position at 15 mm from bottom
            $this->SetY(-15);
            // Set font
            $this->SetFont('helvetica', 'I', 8);
            // Page number
            $this->Cell(0,0, 'Pag. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 
                    false, 'R', 0, '', 0, false, 'T', 'M');
        }
    }

    $titulo="Informe de Compra";

    // create new PDF document // CODIFICACION POR DEFECTO ES UTF-8
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Nombre Usuario');
    $pdf->SetTitle("$titulo");
    $pdf->SetSubject('Sistema ');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    $pdf->setPrintHeader(false);
    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margins POR DEFECTO
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    //$pdf->SetMargins(8,10, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //set auto page breaks SALTO AUTOMATICO Y MARGEN INFERIOR
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


    // ---------------------------------------------------------

    // TIPO DE LETRA
    $pdf->SetFont('times', 'B', 14);

    // AGREGAR PAGINA
    $pdf->AddPage('P','LEGAL');
    $pdf->Cell(0,0,"Organizacion",0,1,'C');
    $pdf->Cell(0,0,"$titulo",0,1,'C');
    //SALTO DE LINEA
    $pdf->Ln();

    //COLOR DE TABLA
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetLineWidth(0.2);
    
    $pdf->SetFont('', 'B',12);
    // Header
    
    $pdf->SetFillColor(180, 180, 180);
    $tit="Factura Nro $codigo";
    $pdf->Cell(90,5,$tit, 1, 0, 'C', 1);
    /*$pdf->Cell(100,5,'DESCRIPCION', 1, 0, 'L', 1);
    $pdf->Cell(0,5,'OTRO', 1, 0, 'C', 1);*/

    $pdf->Ln();
    $pdf->SetFont('', '');
        $pdf->SetFillColor(255, 255, 255);
        
        $pedira = "SELECT * FROM factura,cliente where factura.cli_codigo=cliente.cli_codigo and fac_codigo=$codigo";
        $pe = mysqli_query($conexion,$pedira);

        while ($row = mysqli_fetch_array($pe)) {
            $nombre=$row["cli_nombre"];
            $apellido=$row["cli_apellido"];
            $fec=$row["fac_fecha"];
            $di=$row["cli_direccion"];
            $co=$row["cli_correo"];
            $to=$row["fac_total"];
            $n="Cliente: $nombre $apellido";
            $f="Fecha: $fec";
            $d="Direccion: $di";
            $c="Correo: $co";

            $pdf->Cell(90,5,$n, 1, 0, 'L', 1);
            $pdf->Ln();
            $pdf->Cell(90,5,$f, 1, 0, 'L', 1);
            $pdf->Ln();
            $pdf->Cell(90,5,$d, 1, 0, 'L', 1);
            $pdf->Ln();
            $pdf->Cell(90,5,$c, 1, 0, 'L', 1);
            $pdf->Ln();

            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetLineWidth(0.2);
            
            $pdf->SetFont('', 'B',12);
            $pdf->SetFillColor(180, 180, 180);
            $pdf->Cell(38,5,'Codigo', 1, 0, 'C', 1);
            $pdf->Cell(38,5,'Producto', 1, 0, 'C', 1);
            $pdf->Cell(38,5,'Precio', 1, 0, 'C', 1);
            $pdf->Cell(38,5,'Cantidad', 1, 0, 'C', 1);
            $pdf->Cell(38,5,'Subtotal', 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetFont('', '');
            $pdf->SetFillColor(255, 255, 255);
            $factura_inf="SELECT * from factura_detalle,producto where factura_detalle.pro_codigo=producto.pro_codigo and factura_detalle.fac_codigo=$codigo";
            $res = mysqli_query($conexion, $factura_inf);
            while ($row = mysqli_fetch_array($res)){
                

                $pdf->Cell(38,5,$row["pro_codigo"], 1, 0, 'L', 1);
                $pdf->Cell(38,5,$row["pro_descripcion"], 1, 0, 'L', 1);
                $pdf->Cell(38,5,$row["pro_precio"], 1, 0, 'L', 1);
                $pdf->Cell(38,5,$row["fac_det_cantidad"], 1, 0, 'L', 1);
                $pdf->Cell(38,5,$row["fac_det_subtotal"], 1, 0, 'L', 1);
                $pdf->Ln();

                
            }
            $pdf->SetFont('', 'B',12);
            $pdf->SetFillColor(180, 180, 180);
            $t="Total:$to";
            $pdf->Cell(190,5,$t, 1, 0, 'C', 1);
            $pdf->Ln();
            
        }

    setlocale(LC_ALL,"es_ES.UTF-8");
    date_default_timezone_set('America/Asuncion');
    $fee = date("d-m-Y");
    $fee=strftime("%A, %d de %B de %Y",strtotime($fee));

      $pdf->Ln();
    $pdf->Cell(0,0,"Informe Generado el $fee",0,1,'R');
    //SALIDA AL NAVEGADOR
    $pdf->Output('reporte_tabla.pdf', 'I');

} else echo "Acceda...";
?>
