<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  ==============================================================================
 *  Author  : Mian Saleem
 *  Email   : saleem@tecdiary.com
 *  For     : PHPExcel
 *  Web     : https://github.com/PHPOffice/PHPExcels
 *  License : LGPL (GNU LESSER GENERAL PUBLIC LICENSE)
 *      : https://github.com/PHPOffice/PHPExcel/blob/master/license.md
 *  ==============================================================================
 */

require_once FCPATH . "vendor/phpoffice/phpexcel/Classes/PHPExcel.php";

class Excel extends PHPExcel
{
    public function __construct()
    {
        parent::__construct();
    }
}
