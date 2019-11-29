<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
function pdf($html, $filename=null)
{
    require_once("mpdf_lib/mpdf.php");
 
    $mpdf = new mPDF('c' ,array(215,297));
    $mpdf->showImageErrors = false;
 
    //$mpdf->allow_charset_conversion=true;
    //$mpdf->charset_in='iso-8859-1';
    
    //Exibir a pagina inteira no browser
    //$mpdf->SetDisplayMode('fullpage');
 
    //Cabeçalho: Seta a data/hora completa de quando o PDF foi gerado + um texto no lado direito
    //$mpdf->SetHeader('{DATE j/m/Y H:i}|{PAGENO}/{nb}|Texto no cabeçalho');
 
    //Rodapé: Seta a data/hora completa de quando o PDF foi gerado + um texto no lado direito
    //$mpdf->SetFooter('{DATE j/m/Y H:i}|{PAGENO}/{nb}|Texto no rodapé');
 
    //$mpdf->WriteHTML($html);
    $stylesheet = file_get_contents('css/pdf.css'); // external css
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($html,2);
    $mpdf->SetTitle($filename);
 
    // define um nome para o arquivo PDF
    if($filename == null){
        $filename = date("Y-m-d_his").'_impressao.pdf';
    }
 
    $mpdf->Output($filename, 'I');
}
 
/* End of file mpdf_pdf_pi.php */
/* Location: ./system/plugins/mpdf_pi.php */