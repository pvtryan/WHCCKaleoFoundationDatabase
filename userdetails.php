<?php
require_once("includes/all.php");
require_once('fpdf/fpdf.php');

$username = isset($_GET["username"])? $_GET["username"] : "";
$Password = isset($_GET["password"])? $_GET["password"] : "";
$user = get_user_by_username($username);

class userPDF extends FPDF
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
	global $user;
	$this->SetFont('Arial','', 8);
	$this->Cell($this->getPageWidth(),1,$this->time_now(),0,0,'L');
	$this->Ln();

    $this->SetFont('Arial','B', 35);
	$this->Cell($this->getPageWidth()-20,45,'WHCC - Kaleo User Details',0,0,'C');
	
	$this->Ln();
	$this->SetFont('Arial', 'B', 20);


	   $this->Cell(65);
	   $this->Write(10,'User: '.$user["full_name"]);
	
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
    global $user,$Password;
	$this->SetFont('Times','B','14');

	
	$this->SetFont('Times','',12);
	$this->SetLineWidth(.3);
	$this->color_header();
	$this->Cell(41,7, 'Username:',1,0,'L',true);
	$this->nocolor();
	$this->Cell(30,7, $user["Username"],1,0,'R',true);
	$this->Ln();
	$this->color_header();
	$this->Cell(41,7,'Password:' ,1,0,'L',true);
	$this->nocolor();
	$this->Cell(30,7,$Password,1,0,'R',true);
	$this->color_header();
	$this->Ln();

	

	
}

}

$pdf = new userPDF();
$pdf->AliasNbPages();


$data = [];
$pdf->AddPage();
$pdf->itemlist($header,$data);
$pdf->Output();
?>