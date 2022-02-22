<?php 

// call the pdf library
require('fpdf/fpdf.php');

// A4 Width : 219mm
// default margin : 10mm each side
// writable horizontal : 219-(10*2)=199mm


// create pdf object
$pdf = new FPDF('P','mm','A4');

// string orientation (P or L) - Portrait or Landscape
// string orientation (pt, mm, cm, in) - measure unit
// Mixed format (A3, A4, A5, Letter and Legal) - format of page

// add new page
$pdf->AddPage();

// $pdf->SetFillColor(238,211,38);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(80,10,'Pasar Rakyat',0,0,'');

$pdf->SetFont('Arial','B',13);
$pdf->Cell(112,10,'INVOICE',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Address : Pluit Selatan No 12, Jakrta Utara',0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(112,5,'Invoice : #12345',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Phone : 021 - 632 256 255',0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(112,5,'Date : 22-02-2022',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Email Address : yudi10_anto@yahoo.co.id',0,1,'');
$pdf->Cell(80,5,'Website : www.jakartavintage.co',0,1,'');

// Line(x1,y1,x2,y2)
$pdf->Line(5,45,205,45);
$pdf->Line(5,46,205,46);

// line break
$pdf->LN(10);

$pdf->SetFont('Arial','BI',12);
$pdf->Cell(20,10,'Bill To : ',0,0,'');

$pdf->SetFont('Courier','BI',14);
$pdf->Cell(50,10,'Yudi Anto',0,1,'');
$pdf->Cell(50,5,'',0,1,'');

$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(208,208,208);
$pdf->Cell(20,8,'NO',1,0,'C',true); // TOTAL 190
$pdf->Cell(80,8,'PRODUCT',1,0,'C',true); 
$pdf->Cell(20,8,'QTY',1,0,'C',true);
$pdf->Cell(30,8,'PRICE',1,0,'C',true);
$pdf->Cell(40,8,'TOTAL',1,1,'C',true);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,8,'1',1,0,'C'); // TOTAL 190
$pdf->Cell(80,8,'IPHONE',1,0,'L'); 
$pdf->Cell(20,8,'1',1,0,'C');
$pdf->Cell(30,8,'200',1,0,'C');
$pdf->Cell(40,8,'200',1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,8,'2',1,0,'C'); // TOTAL 190
$pdf->Cell(80,8,'SAMSUNG',1,0,'L'); 
$pdf->Cell(20,8,'1',1,0,'C');
$pdf->Cell(30,8,'150',1,0,'C');
$pdf->Cell(40,8,'150',1,1,'C');


$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,8,'3',1,0,'C'); // TOTAL 190
$pdf->Cell(80,8,'OPPO',1,0,'L'); 
$pdf->Cell(20,8,'2',1,0,'C');
$pdf->Cell(30,8,'150',1,0,'C');
$pdf->Cell(40,8,'300',1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,8,'',0,0,'C'); // TOTAL 190
$pdf->Cell(80,8,'',0,0,'L'); 
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Sub Total',1,0,'C',true);
$pdf->Cell(40,8,'300',1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,8,'',0,0,'C'); // TOTAL 190
$pdf->Cell(80,8,'',0,0,'L'); 
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Tax',1,0,'C',true);
$pdf->Cell(40,8,'30',1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,8,'',0,0,'C'); // TOTAL 190
$pdf->Cell(80,8,'',0,0,'L'); 
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Discount',1,0,'C',true);
$pdf->Cell(40,8,'0',1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,8,'',0,0,'C'); // TOTAL 190
$pdf->Cell(80,8,'',0,0,'L'); 
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Grand Total',1,0,'C',true);
$pdf->Cell(40,8,'$'.'330',1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,8,'',0,0,'C'); // TOTAL 190
$pdf->Cell(80,8,'',0,0,'L'); 
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Paid',1,0,'C',true);
$pdf->Cell(40,8,'400',1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,8,'',0,0,'C'); // TOTAL 190
$pdf->Cell(80,8,'',0,0,'L'); 
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Due',1,0,'C',true);
$pdf->Cell(40,8,'70',1,1,'C');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,8,'',0,0,'C'); // TOTAL 190
$pdf->Cell(80,8,'',0,0,'L'); 
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Payment Type',1,0,'C',true);
$pdf->Cell(40,8,'Debit',1,1,'C');

$pdf->Cell(50,10,'',0,1,'');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(32,10,'Important Notice :',0,0,'',true);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(148,10,'No item will be replaced or refunded if you dont have the invoice with you. You can refund with in 2 day of purchase.',0,0,'');

// output the result
$pdf->Output();



?>