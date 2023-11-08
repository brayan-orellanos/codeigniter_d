<?php

/**
*@author Innovación y Tecnología
*@copyright 2021 Fábrica de Desarrollo
*@version v 2.0
*@param 
*@return 
**/

if( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

require_once( APPPATH . 'third_party/smarty/libs/Smarty.class.php' );

class Smartie extends Smarty
{
    public function __construct()
    {
        parent::__construct();

        $this->setTemplateDir( APPPATH . "views" );

        $this->setCompileDir( APPPATH . "views_c" );
    }
}