<?php 

require_once ("../../../connection.php");
// Include the main TCPDF library (search for installation path).
require_once('../../TCPDF-main/tcpdf.php');

if (isset($_GET['generate_report'])) {

    $courseCode = $_GET['courseCode'];

}    
// set default header data
class PDF extends TCPDF
{
    public function Header(){
        $imageFile = K_PATH_IMAGES.'logo.jpg';
        $this->Image($imageFile, 40, 10, 20, '', 'JPG', '', 'T', false, 300, '', false, false,
        0, false, false, false);
        $this->Ln(0);

        $this->SetFont('helvetica', '', 8,);
        $this->Cell(270, 3, 'Republic of the Philippines', 0, 1, 'C');
        $this->Cell(270, 3, 'Commision on Higher Education', 0,1, 'C');
        $this->Cell(270, 3, 'Region V', 0,1, 'C');
        $this->SetFont('helvetica', 'B', 11);
        $this->Cell(270, 3, 'LIGAO COMMUNITY COLLEGE', 0, 1, 'C');
        $this->SetFont('helvetica', '', 8,);
        $this->Cell(270, 3, 'Soledad Street, Guilid, Ligao City, 4505', 0, 1, 'C');
        $this->SetFont('helvetica', 'B', 11);
        $this->Cell(270, 1, '________________________________________________________________________________________________________________________', 0, 1, 'C');

    }

}


// create new PDF document
$pdf = new PDF('l', 'mm', 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator('OJT RECORD MONITORING SYSTEM');
$pdf->SetAuthor('Administrator');
$pdf->SetTitle('Student Profile');
$pdf->SetSubject('General Report of Student Profile');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}


// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 12, '', true);



// Add a page
// This method has several options, check the source code documentation for more information.


// add a page
$pdf->AddPage();
// Start First Page Group
$pdf->startPageGroup();
// $pdf->Ln(10);
// $pdf->SetFont('helvetica', 'B', 12);
// $pdf->Cell(180, 3, 'Student Profile Report', 0, 1, 'C');
// $pdf->SetFont('times', '', 12);
$html = '
<style>
body{
    font-style: "Times New Roman" ;
    font-size:12px;
    margin: 0;
    padding:0;
}

</style>

<body>
<center><h3 style="text-align:center;">Student List Report in '.$courseCode.'</h3></center>


<table border="1"  align="center"  cellpadding="1">

 <tr nobr="true">
  <th><b>Pre-Service Student</b></th>
  <th><b>Course</b></th>
  <th><b>Student ID</b></th>
  <th><b>Cooperating School/Company</b></th>
  <th><b>Supervisor/School Head</b></th>
 </tr>
';

$getStudent = mysqli_query($db, "SELECT * FROM students WHERE courseCode='$courseCode'");
while($row = mysqli_fetch_array($getStudent)){
      $Sname = $row['Sname'];
    $Smname = $row['Smname'];
    $Slname = $row['Slname'];
    $Scourse = $row['Scourse'];
    $Syear = $row['Syear'];
    $Sblock = $row['Sblock'];
    $studentID = $row['studentID'];

    $Sgender = $row['Sgender'];
    $Snumber = $row['Snumber'];

    $Swname = $row['Swname'];
    $Swcompany = $row['Swcompany'];
    $Swemployer = $row['Swemployer'];

    $courseCode = $row['courseCode'];


$html .='
 <tr nobr="true">
 <td>'.$Sname.' '.$Smname.' '.$Slname.'</td>
 <td>'.$Scourse.' '.$Syear.'-'.$Sblock.'</td>
 <td>'.$studentID.'</td>
 <td>'.$Swcompany.'</td>
 <td>'.$Swemployer.'</td>
 </tr>
';
}
$html .='

</table>

</body>
</html>';






$pdf->writeHTML($html, true, false, true, false, '');
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');
