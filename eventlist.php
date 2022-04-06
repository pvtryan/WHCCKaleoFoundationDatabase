<?php
require_once("includes/all.php");
require_once('fpdf/fpdf.php');

$events = get_events();
class eventPDF extends FPDF
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
	$this->SetFont('Arial','', 8);
	$this->Cell($this->getPageWidth(),1,$this->time_now(),0,0,'L');
	$this->Ln();

    $this->SetFont('Arial','B', 35);
	$this->Cell($this->getPageWidth()-20,45,'WHCC - Kaleo Inventory List',0,0,'C');
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
    global $events;
	$this->SetFont('Times','B','14');

	$this->SetFont('Times','B','14');
	$this->Cell(40,10,'Event List',0,0,'C');
	$this->Ln();

	$this->SetFont('Times','',10);
	//colors
	$this->SetFillColor(36,153,244);
	$this->SetTextColor(0,0,0);
	$this->SetDrawColor(71,71,71);
	$this->SetLineWidth(.3);
	
	
	//width columns
	$w = array(15,50,30,30,25,45);
	//Header
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
	$this->Ln();
	
	
	
	$this->SetDrawColor(255,211,89);
	$this->SetFillColor(255,235,185);

    $this->SetFillColor(255,255,255);
	$this->SetDrawColor(0,0,0);

    foreach( $events as $event){
		$this->SetTextColor(0,0,0);
		$this->Cell($w[0],6,$event["EventID"],1,0,'L',true);
		$this->Cell($w[1],6,$event["EventName"],1,0,'L',true);
		$this->Cell($w[2],6,$event["format_date"],1,0,'L',true);
		$this->Cell($w[3],6,$event["full_name"],1,0,'L',true);
        $this->Cell($w[4],6,$event["Phone"],1,0,'L',true);
        $this->Cell($w[5],6,$event["Email"],1,0,'L',true);
		$this->Ln();
	}
    $this->Cell(array_sum($w),0,' ','T');
}

}
$pdf = new eventPDF();
$pdf->AliasNbPages();

$header = array('EventID', 'EventName', 'Event Date' , 'Contact', 'Phone', 'Email');

$data = [];
$pdf->AddPage();
$pdf->itemlist($header,$data);
$pdf->Output();
?>