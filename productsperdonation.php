<?php
    require_once('includes/all.php');
   
    require('fpdf/fpdf.php');

    $donationID = isset($_GET["DonationID"])? $_GET["DonationID"] : "";
    

    $info = get_donation_name_by_id($donationID);
    $products = get_products_donated_by($donationID);
    $stat=stats_of_donations($donationID);


    class donationlistPDF extends FPDF{
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
            global $products,$info,$stat;

            $this->SetFont('Arial', 'B', 35);
			$this->Cell(80);
			$this->Cell(30,20,'WHCC - Kaleo Donation List',0,0, 'C');
			$this->Ln();
            $this->SetFont('Arial', 'B', 15);
           //$this->Cell(20);
        
            if($info["event_name"] == NULL){
                $this->Cell(0,10,$info["org_name"] .' Added On ' .$info["FormatDate"] ,0,0,'C');
            }else{
                $this->Cell(0,10,$info["event_name"] .' Added On ' .$info["FormatDate"] ,0,0,'C');
            
            }
        
        
            $this->Ln();
            $this->SetFont('Arial', 'B', 20);
            
            $this->SetLineWidth(2);
			$this->Ln();
			$this->Line(10,40,$this->getPageWidth()-10,40);
            $this->Ln();

                
            $this->SetFont('Times','',12);
	        $this->SetLineWidth(.3);
            $this->headercolor();
            $this->Cell(45,7,'Total # of All Products: ',1,0,'C',true);
            $this-> cellnocolor();
            $this->Cell(35,7,$stat["totalcount"],1,0,'R',true);
            $this->cellnocolor();
            $this->Ln();
            $this->headercolor();
            $this->Cell(45,7,'Total Quantity: ',1,0,'C',true);
            $this-> cellnocolor();
            $this->Cell(35,7,$stat["totalquantity"],1,0,'R',true);
            $this->cellnocolor();
            $this->Ln();
            $this->headercolor();
            $this->Cell(45,7,'Total Value: ',1,0,'C',true);
            $this-> cellnocolor();
            $this->Cell(35,7,'$ '.$stat["totalvalue"]. '.00',1,0,'R',true);
            $this->cellnocolor();

        }

        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->SetTextColor(0,0,0);
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }

        function donationList($header,$data){
			global $products,$stat;

            $this->SetFont('Times','B','14');
	    $this->Ln();
        $this->Ln();
        $this->Cell(40,10,'Donation List',0,0,'C');

        $this->Ln();
        $this->headercolor();//sets cell color to blue for header
        $this->SetFont('Times','',12);
	    //width columns
	    $w = array(20,60,35,35);
	    //Header
	    for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    	$this->Ln();
	
        $this->cellnocolor(); //sets cell color to white 

        foreach( $products as $product){
		    $this->SetTextColor(0,0,0);
		    $this->Cell($w[0],6,$product["ID"],1,0,'R',true);
		    $this->Cell($w[1],6,$product["ProductName"],1,0,'L',true);
	        $this->Cell($w[2],6,$product["productused"],1,0,'R',true);
           
            $this->Cell($w[2],6,"$".$product["Value"].".00",1,0,'R',true);
        
		    $this->Ln();
	    }
        
        $this->Cell(array_sum($w),0,' ','T');
		}

    }


    $pdf = new donationlistPDF();
    $pdf->AliasNbPages();
    
    $header = array('ProductID', 'ProductName', 'Quantity', 'Value');
    $data = [];
    $pdf->AddPage();
    $pdf->SetFont('Times', '', 16);
    $pdf->donationList($header,$data);
    $pdf->Output();

?>