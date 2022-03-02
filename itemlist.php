<?php
require_once("includes/all.php");
require_once('fpdf/fpdf.php');

$products = product_pdf();
$sum = get_sum_value();
$sum_quantity=get_sum_quantity();

class inventoryPDF extends FPDF
{

function time_now(){

	$now = date('M/d/Y h:i:s a', time());

	return $now;
}

function color_header(){
	$this->SetFillColor(36,153,244);
	$this->SetTextColor(0,0,0);
	$this->SetDrawColor(71,71,71);
	$this->SetLineWidth(.3);
}

function nocolor(){
	$this->SetDrawColor(255,211,89);
	$this->SetFillColor(255,235,185);

    $this->SetFillColor(255,255,255);
	$this->SetDrawColor(0,0,0);
}

function Header(){
	global $sum,$sum_quantity;
	$this->SetFont('Arial','B', 12);
	$this->Cell($this->getPageWidth(),1,$this->time_now(),0,0,'L');
	$this->Ln();

    $this->SetFont('Arial','B', 35);
	$this->Cell($this->getPageWidth()-20,45,'WHCC Inventory List',0,0,'C');
	$this->SetLineWidth(2);
	$this->Line(10,40,$this->getPageWidth()-10,40);
	$this->Ln();
	
}

function Footer()
{
	$this->SetY(-15);
	$this->SetFont('Arial','I',8);
	$this->SetTextColor(0);
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	
}

function itemlist($header,$data){
    global $products,$sum,$sum_quantity;
	$this->SetFont('Times','B','14');
	$this->Cell(40,10,'Inventory List',0,0,'C');
	$this->Ln();
	
	$this->SetFont('Times','',12);
	$this->SetLineWidth(.3);
	$this->color_header();
	$this->Cell(41,7, 'Total # of All Products:',1,0,'L',true);
	$this->nocolor();
	$this->Cell(30,7, count(get_products()),1,0,'R',true);
	$this->Ln();
	$this->color_header();
	$this->Cell(41,7,'Total Quantity:' ,1,0,'L',true);
	$this->nocolor();
	$this->Cell(30,7,$sum_quantity["sum_quantity"],1,0,'R',true);
	$this->color_header();
	$this->Ln();
	$this->Cell(41,7,'Total Value: ',1,0,'L',true);
	$this->nocolor();
	$this->Cell(30,7,'$ '.$sum["sum"],1,0,'R',true);
	$this->Ln();
	$this->Ln();
	
	//colors
	$this->SetFillColor(36,153,244);
	$this->SetTextColor(0,0,0);
	$this->SetDrawColor(71,71,71);
	$this->SetLineWidth(.3);
	
	
	//width columns
	$w = array(15,75,30,35,30);
	//Header
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
	$this->Ln();
	
	
	
	$this->SetDrawColor(255,211,89);
	$this->SetFillColor(255,235,185);

    $this->SetFillColor(255,255,255);
	$this->SetDrawColor(0,0,0);

    foreach( $products as $product){
		$this->SetTextColor(0,0,0);
		$this->Cell($w[0],6,$product["ProductID"],1,0,'L',true);
		$this->Cell($w[1],6,$product["ProductName"],1,0,'L',true);
		$this->Cell($w[2],6,$product["combine"],1,0,'L',true);
		$this->Cell($w[3],6,$product["value"],1,0,'L',true);
        $this->Cell($w[4],6,$product["total"],1,0,'L',true);
		$this->Ln();
	}
    $this->Cell(array_sum($w),0,' ','T');
}

}
$pdf = new inventoryPDF();
$pdf->AliasNbPages();

$header = array('Item ID', 'Product Name', 'Quantity' , 'EstValue', 'Total Est. Value');
$data = [];
$pdf->AddPage();
$pdf->itemlist($header,$data);
$pdf->Output();
?>