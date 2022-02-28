<?php
    require_once('includes/all.php');
   
    require('fpdf/fpdf.php');

    $donations = get_donation_list();

    class donationlistPDF extends FPDF{
        function Header(){
            global $donations;

            $this->SetFont('Arial', 'B', 35);
			$this->Cell(80);
			$this->Cell(30,20,'Donation List',0,0, 'C');
			$this->Ln();
			$this->SetLineWidth(2);
			$this->Ln();
			$this->Line(10,40,$this->getPageWidth()-10,40);
        }

        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->SetTextColor(0,0,0);
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }

        function donationList($header,$data){
			global $donations;
            
            $this->SetFont('Times','B','14');
	    $this->Cell(40,10,'Inventory List',0,0,'C');
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


    $pdf = new donationlistPDF();
    $pdf->AliasNbPages();
    
    $header = array('DonationID', 'Date Added', 'Name', 'Type');
    $data = [];
    $pdf->AddPage();
    $pdf->SetFont('Times', '', 16);
    $pdf->donationList($header,$data);
    $pdf->Output();
?>
