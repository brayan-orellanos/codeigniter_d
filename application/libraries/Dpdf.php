<?php

/**
*@author Innovación y Tecnología
*@copyright 2021 Fábrica de Desarrollo
*@version v 2.0
*@param 
*@return 
**/

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

require_once APPPATH . 'third_party\dompdf\lib\html5lib\Parser.php';
require_once APPPATH . 'third_party\dompdf\lib\php-font-lib\src\FontLib\Autoloader.php';
require_once APPPATH . 'third_party\dompdf\lib\php-svg-lib\src\autoload.php';
require_once APPPATH . 'third_party\dompdf\src\Autoloader.php';

Dompdf\Autoloader::register();

use Dompdf\Dompdf;

class Dpdf 
{
    public function gpdf( $html, $filename = '', $stream = TRUE, $paper = 'A4', $orientation = "portrait" )
    {
        $dompdf = new Dompdf();

        $dompdf->loadHtml( $html );
        $dompdf->setPaper( $paper, $orientation );
        $dompdf->render();

        ob_end_clean();

        if ( $stream ) 
        {
            $dompdf->stream( $filename.".pdf", array( "Attachment" => 0 ) );
        } 
        else 
        {
            $dompdf->stream( $filename.".pdf", array( "Attachment" => 1 ) );
        }
    }
}