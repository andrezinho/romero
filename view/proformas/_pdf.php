<?php
session_start();
require("../lib/fpdf/fpdf.php");
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
        $this->SetFillColor(208, 217, 218);
        $this->SetTextColor(0);        
        $this->SetDrawColor(208, 217, 218);
        $h = 18;

        $this->Rect(14, 9 ,181, $h+2);
        $this->Image('../../web/images/logo.jpg',18,10,30,$h);
        $this->MultiCellp(10, $h, '', 0, 'C', false);

        $this->MultiCell(1, $h, '', 0, 'C', false);                
        $nh = $this->nLineaBreak(20, $h, 'SAPOSOA', 'C');
        $this->MultiCell(20, $h/$nh, '', 0, 'C');                

        $this->MultiCellp(1, $h, '', 0, 'C', false);
        $nh = $this->nLineaBreak(75, $h, $_SESSION['empresa'], 'C');
        $this->MultiCell(75, $h/$nh, 'CARPINTERIA ROMERO E.I.R.L', 0, 'C', true);

        $this->SetFillColor(208, 217, 218);
        $this->SetFont('Arial','B',8);
        $this->MultiCell(1, $h, '', 0, 'C', false);                
        $nh = $this->nLineaBreak(30, $h, 'PROVINCIA DE TARAPOTO', 'C');
        $this->MultiCell(30, $h/$nh, 'PROVINCIA DE TARAPOTO', 0, 'C', true);                

        $this->SetFillColor(208, 217, 218);
        $this->MultiCell(1, $h, '', 0, 'C', false);                
        $nh = $this->nLineaBreak(30, $h, utf8_decode('REGION SAN MARTIN PERÚ'), 'C');
        $this->MultiCell(30, $h/$nh, utf8_decode('REGION SAN MARTIN PERÚ'), 0, 'C', true);                

        //$this->SetFont('Arial','B',10);
        $this->Ln(15);
        /*$this->SetTextColor(0); 
        $this->Cell(0,5,'VER',0,1,'C',false);
        $this->Ln(10);*/
    }
    
    function cuerpo($IdProforma,$FechaPro)
    {
        $this->Ln(10);
        $this->SetFont('Arial','B',8);
	$this->Cell(16,5,utf8_decode('Señor (a):'),1,0,'L');
        $this->Cell(55,5,utf8_decode('Andres Linerico'),1,0,'L');
        
        $this->Cell(16,5,utf8_decode('RUC:'),1,0,'L');
        $this->Cell(0,5,utf8_decode('S0000'),1,1,'L');
        
        //2° linea
        $this->Cell(16,5,utf8_decode('Dirección:'),1,0,'L');
        $this->Cell(55,5,utf8_decode('Jr: Los postes'),1,0,'L');
        
        $this->Cell(16,5,utf8_decode('FECHA:'),1,0,'L');
        $this->Cell(0,5,utf8_decode('05/47/13'),1,1,'L');
        
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

    
}

$nombre = $cabecera[1];
die($nombre);
$IdProforma = $_GET['id'];
$FechaPro= $_GET['fecha'];
$_SESSION['empresa'] = strtoupper(utf8_decode($empresa));
$_SESSION['logo'] = $logo;
$_SESSION['titulo'] ='"'.strtoupper(utf8_decode($name_year)).'"'; 
//$_SESSION['empresa'] = strtoupper(utf8_decode($empresa));
$pdf = new PDF();
$pdf->SetTitle($title);
$pdf->SetMargins(20,10,20);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->cuerpo($IdProforma,$FechaPro);
$pdf->Output();	


$pdf->Output($ruta, 'F');

?>