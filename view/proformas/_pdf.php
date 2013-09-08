<?php
session_start();
require("../../lib/fpdf/fpdf.php");
class PDF extends FPDF
{

    function Header()
    {
        global $title;	
        global $a;
        global $title;	
        global $a;
        $this->SetLineWidth(.1);
        $this->SetFont('Arial','B',10);
        $this->SetFillColor(21, 107, 35);
        $this->SetTextColor(255);        
        $this->SetDrawColor(50, 133, 59);
        $h = 15;

        $this->Rect(14, 9 ,181, $h+2);
        //$this->Image('../../web/images/logo.png',18,10,14,$h);
        $this->MultiCellp(10, $h, '', 0, 'C', false);

        $this->MultiCell(1, $h, '', 0, 'C', false);                
        $nh = $this->nLineaBreak(20, $h, 'SAPOSOA', 'C');
        $this->MultiCell(23, $h/$nh, 'TARAPOTO', 0, 'C', true);                

        $this->MultiCellp(1, $h, '', 0, 'C', false);
        $nh = $this->nLineaBreak(75, $h, $_SESSION['empresa'], 'C');
        $this->MultiCell(75, $h/$nh, $_SESSION['empresa'], 0, 'C', true);

        $this->SetFillColor(0, 153, 0);
        $this->SetFont('Arial','B',8);
        $this->MultiCell(1, $h, '', 0, 'C', false);                
        $nh = $this->nLineaBreak(30, $h, 'PROVINCIA DE HUALLAGA', 'C');
        $this->MultiCell(30, $h/$nh, 'PROVINCIA DE HUALLAGA', 0, 'C', true);                

        $this->SetFillColor(51, 204, 51);
        $this->MultiCell(1, $h, '', 0, 'C', false);                
        $nh = $this->nLineaBreak(30, $h, utf8_decode('REGION SAN MARTIN PERÚ'), 'C');
        $this->MultiCell(30, $h/$nh, utf8_decode('REGION SAN MARTIN PERÚ'), 0, 'C', true);                

        $this->SetFont('Arial','B',10);
        $this->Ln(25);
        $this->SetTextColor(0); 
        $this->Cell(0,5,$_SESSION['titulo'],0,1,'C',false);
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-20);		
        $this->SetFont('Arial','I',8);		
        $this->SetTextColor(0);

        $this->SetLineWidth(.1);
        $this->Cell(0,.1,"",1,1,'C',true);
        $this->Ln(2);
        $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function Fecha($Fecha)
    {
        $this->Ln();
        $this->SetFont('Arial','',12);

        $this->Cell(30,5,'FECHA',0,0,'',true);		//Para
        $this->Cell(20,5,':',0,0,'C',true);			//2 Puntos

        ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $Fecha, $mifecha);
        $Fecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];

        $this->Cell(0, 5, $Fecha, 0, 1, '', true);
        $this->SetFont('Arial','',10);
        $this->Ln(3);
        $this->Cell(0,.1,"",1,1,'C',true);
        $this->Ln(3);
    }
	
 
    function Firma($firma,$cargo)
    {		
        $firma = strtoupper($firma);
        $this->SetFont('Arial','',12);		
        $w=$this->GetStringWidth($firma)+6;
        $this->SetX((210-$w)/2);
        $this->Cell($w,.1,"",1,1,'C',true);
        $this->Ln(1);		
        $this->Cell(0,5, utf8_decode($firma),0,1,'C',true);
        $this->SetFont('Arial','',10);		
        $this->Cell(0,5,$cargo,0,1,'C',true);
        $this->Ln(20);
    }

}

$IdExpediente = $_GET['idexpediente'];
$_SESSION['empresa'] = strtoupper(utf8_decode($empresa));
$_SESSION['logo'] = $logo;
$_SESSION['titulo'] ='"'.strtoupper(utf8_decode($name_year)).'"'; 
//$_SESSION['empresa'] = strtoupper(utf8_decode($empresa));
$pdf = new PDF();
$pdf->SetTitle($title);
$pdf->SetAuthor('ADZ');
$pdf->SetMargins(20,10,20);
$pdf->AliasNbPages();

//$pdf->PrintChapter($IdExpediente, $obj->documento, $obj->numexpediente, $obj->siglas, $user_destino , $obj->firma,$obj->cargo, $obj->asunto, $obj->fechaexpediente, utf8_decode($obj->contenido),$proveido,$ref);
$pdf->Output();	

$ruta = "expedientes/".$IdExpediente.".pdf";

$pdf->Output($ruta, 'F');

?>