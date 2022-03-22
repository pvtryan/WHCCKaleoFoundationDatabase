<?php
    require_once('includes/all.php');
   
    require('fpdf/fpdf.php');

    $donations = report_donation();
    $info = get_info_all();


    class allReportPDF extends FPDF{
        function headercolor(){
            //colors
	        $this->SetFillColor(36,153,244);
	        $this->SetTextColor(0,0,0);
	        $this->SetDrawColor(71,71,71);
	        $this->SetLineWidth(.3);
        }

        function cellnocolor(){

	    $this->SetDrawColor(255,211,89);
	    $this->SetFillColor(255,235,185);

        $this->SetFillColor(255,255,255);
	    $this->SetDrawColor(0,0,0);

        }

        function Header(){
            global $donations,$info;

            $this->SetFont('Arial', 'B', 35);
			$this->Cell(80);
			$this->Cell(30,20,'WHCC - Kaleo Donation List',0,0, 'C');
			$this->Ln();
			$this->SetLineWidth(2);
			$this->Ln();
			$this->Line(10,40,$this->getPageWidth()-10,40);

              
         
            $this->Ln();
            $this->SetFont('Times','',12);
            $this->SetLineWidth(.3);
            $this->headercolor();
            $this->Cell(45,7, 'Total # of All Products:',1,0,'L',true);
            $this->cellnocolor();
            $this->Cell(35,7, $info["countnum"],1,0,'R',true);
            $this->Ln();
            $this->headercolor();
            $this->Cell(45,7,'Total Quantity:' ,1,0,'L',true);
            $this->cellnocolor();
            $this->Cell(35,7,$info["total_quantity"],1,0,'R',true);
            $this->Ln();
            $this->headercolor();
            $this->Cell(45,7,'Total Value: ',1,0,'L',true);
            $this->cellnocolor();
            $this->Cell(35,7,'$ '.$info["total_value"],1,0,'R',true);
            $this->Ln();
        }

        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->SetTextColor(0,0,0);
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }

        function report($header,$data){
            global $donations;
            
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
	        $w = array(25,40,60,25,25);
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
		        $this->Cell($w[1],6,$donation["Date2"],1,0,'L',true);
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
                $value = get_value_of_donation($donation["DonationID"]);
                if($value["total"] == 0){
                    $this->Cell($w[4],6,'$ 0.00',1,0,'R',true);
                }else{
                    $this->Cell($w[4],6,'$ ' .$value["total"],1,0,'R',true);
                }
                $this->Ln();
	        }
            
            $this->Cell(array_sum($w),0,' ','T');
    
        }
        
    }


    $pdf = new allReportPDF();
    $pdf->AliasNbPages();
    
    $header = array('ID', 'Date Added', 'Reicipent' , 'Type','Value');
  
    $data = [];
    $pdf->AddPage();
    $pdf->SetFont('Times', '', 16);
    $pdf->report($header,$data);
    $pdf->Output();
?>