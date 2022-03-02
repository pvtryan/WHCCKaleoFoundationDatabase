<?php
    require_once('includes/all.php');
   
    require('fpdf/fpdf.php');

    $year = isset($_GET["Year"])? $_GET["Year"] : "";
    $name;
    if(isset($_GET["Month"])){
        $month = isset($_GET["Month"])? $_GET["Month"] : "";
        $donations=get_donation_by_year_month($year,$month);
        $info = get_info_by_year_month($year,$month);
        $name = get_monthname($month);
    }else if(isset($_GET["Quarter"])){
        $quarter = isset($_GET["Quarter"])? $_GET["Quarter"] : "";
        $donations = get_donation_by_year_quarter($year,$quarter);
        $info = get_info_by_year_quarter($year,$quarter);
    
    }else{
        $donations = get_donation_by_year($year);
        $info = get_info_by_year($year);
    }

    class ReportPDF extends FPDF{
        function Header(){
            global $donations,$year,$info,$name;

            $this->SetFont('Arial', 'B', 35);
			$this->Cell(80);
            $this->Cell(-1,20,'Donation Report For',0,0, 'C');
            $this->Cell(155,20,$year,0,0, 'C');
            $this->Ln();
			$this->SetLineWidth(2);
			$this->Ln();
			$this->Line(10,40,$this->getPageWidth()-10,40);
            $this->SetFont('Times','',12);
            $this->SetLineWidth(.3);
            $this->Cell(41,7, 'Total # of All Products:',1,0,'L');
            $this->Cell(10,7, $info["countnum"],1,0,'R');
            $this->Cell(30,7,'Total Quantity:' ,1,0,'L');
            $this->Cell(15,7,$info["total_quantity"],1,0,'R');
            $this->Cell(24,7,'Total Value: ',1,0,'L');
            $this->Cell(1,7,'$',1,0,'L');
            $this->Cell(20,7,$info["total_value"],1,0,'R');
            $this->Ln();
        }

        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->SetTextColor(0,0,0);
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }


        function report($header,$data){
            global $donations,$year,$info;
            
            $this->SetFont('Times','B','14');
	        $this->Cell(40,10,'Donation List',0,0,'C');
	        $this->Ln();
	
    	    $this->SetFont('Times','',12);
	
	        //colors
	        $this->SetFillColor(36,153,244);
	        $this->SetTextColor(0,0,0);
	        $this->SetDrawColor(71,71,71);
	        $this->SetLineWidth(.3);
	
	
	        //width columns
	        $w = array(25,60,60,35);
	        //Header
	        for($i=0;$i<count($header);$i++)
		        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    	        $this->Ln();
	
	
	
	        $this->SetDrawColor(255,211,89);
	        $this->SetFillColor(255,235,185);

            $this->SetFillColor(255,255,255);
	        $this->SetDrawColor(0,0,0);

            foreach( $donations as $donation){
		        $this->SetTextColor(0,0,0);
		        $this->Cell($w[0],6,$donation["DonationID"],1,0,'L',true);
		        $this->Cell($w[1],6,$donation["Date"],1,0,'L',true);
		        if($donation["event_name"] == NULL){
                    $this->Cell($w[2],6,$donation["org_name"],1,0,'L',true);
                }else{
                    $this->Cell($w[2],6,$donation["event_name"],1,0,'L',true);
                }
                if($donation["event_name"] == NULL){
                    $this->Cell($w[3],6,'Organization',1,0,'L',true);
                }else{
                    $this->Cell($w[3],6,'Event',1,0,'L',true);
                }
		        $this->Ln();
	        }
            
            $this->Cell(array_sum($w),0,' ','T');
    
        }

    }

    $pdf = new ReportPDF();
    $pdf->AliasNbPages();
    
    $header = array('ID', 'Date Added', 'Reicipent' , 'Type');
  
    $data = [];
    $pdf->AddPage();
    $pdf->SetFont('Times', '', 16);
    $pdf->report($header,$data);
    $pdf->Output();

?>