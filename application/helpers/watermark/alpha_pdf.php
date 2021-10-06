 <?php
require_once('pdf_js.php');

/*
//example
require('alphapdf.php');

$pdf = new AlphaPDF();
$pdf->AddPage();
$pdf->SetLineWidth(1.5);

// draw opaque red square
$pdf->SetFillColor(255, 0, 0);
$pdf->Rect(10, 10, 40, 40, 'DF');

// set alpha to semi-transparency
$pdf->SetAlpha(0.5);

// draw green square
$pdf->SetFillColor(0, 255, 0);
$pdf->Rect(20, 20, 40, 40, 'DF');

// draw jpeg image
$pdf->Image('lena.jpg', 30, 30, 40);

// restore full opacity
$pdf->SetAlpha(1);

// print name
$pdf->SetFont('Arial', '', 12);
$pdf->Text(46, 68, 'Lena');

$pdf->Output();

*/


//class AlphaPDF extends FPDF
class AlphaPDF extends PDF_JavaScript
{
    var $extgstates;

    function AlphaPDF($orientation='P', $unit='mm', $format='A4')
    {
        parent::FPDF($orientation, $unit, $format);
        $this->extgstates = array();
    }

    // alpha: real value from 0 (transparent) to 1 (opaque)
    // bm:    blend mode, one of the following:
    //          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn,
    //          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
    function SetAlpha($alpha, $bm='Normal')
    {
        // set alpha for stroking (CA) and non-stroking (ca) operations
        $gs = $this->AddExtGState(array('ca'=>$alpha, 'CA'=>$alpha, 'BM'=>'/'.$bm));
        $this->SetExtGState($gs);
    }

    function AddExtGState($parms)
    {
        $n = count($this->extgstates)+1;
        $this->extgstates[$n]['parms'] = $parms;
        return $n;
    }

    function SetExtGState($gs)
    {
        $this->_out(sprintf('/GS%d gs', $gs));
    }

    function _enddoc()
    {
        if(!empty($this->extgstates) && $this->PDFVersion<'1.4')
            $this->PDFVersion='1.4';
        parent::_enddoc();
    }

    function _putextgstates()
    {
        for ($i = 1; $i <= count($this->extgstates); $i++)
        {
            $this->_newobj();
            $this->extgstates[$i]['n'] = $this->n;
            $this->_out('<</Type /ExtGState');
            foreach ($this->extgstates[$i]['parms'] as $k=>$v)
                $this->_out('/'.$k.' '.$v);
            $this->_out('>>');
            $this->_out('endobj');
        }
    }

    function _putresourcedict()
    {
        parent::_putresourcedict();
        $this->_out('/ExtGState <<');
        foreach($this->extgstates as $k=>$extgstate)
            $this->_out('/GS'.$k.' '.$extgstate['n'].' 0 R');
        $this->_out('>>');
    }

    function _putresources()
    {
        $this->_putextgstates();
        parent::_putresources();
    }
}
?> 