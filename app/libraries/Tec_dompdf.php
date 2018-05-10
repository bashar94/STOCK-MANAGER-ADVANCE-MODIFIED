<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  ==============================================================================
 *  Author  : Mian Saleem
 *  Email   : saleem@tecdiary.com
 *  For     : DOMPDF
 *  Web     : https://github.com/dompdf/dompdf
 *  License : LGPL-2.1
 *      : https://github.com/dompdf/dompdf/blob/master/LICENSE.LGPL
 *  ==============================================================================
 */

use Dompdf\Dompdf;

class Tec_dompdf extends DOMPDF
{
    public function __construct() {
        parent::__construct();
    }

    public function generate($content, $name = 'download.pdf', $output_type = null, $footer = null, $margin_bottom = null, $header = null, $margin_top = null, $orientation = 'P') {
        $html = '';
        if (is_array($content)) {
            foreach ($content as $page) {
                $html .= $header ? '<header>' . $header . '</header>' : '';
                $html .= '<footer>'.($footer ? $footer.'<br><span class="pagenum"></span>' : '<span class="pagenum"></span>').'</footer>';
                $html .= '<div class="page">'.$page['content'].'</div>';
            }
        } else {
            $html .= $header ? '<header>' . $header . '</header>' : '';
            $html .= $footer ? '<footer>' . $footer . '</footer>' : '';
            $html .= $content;
        }

        $this->set_option('isPhpEnabled', true);
        $this->set_option('isHtml5ParserEnabled', true);
        $this->loadHtml($html);
        $this->setPaper('A4', ($orientation == 'P' ? 'portrait' : 'landscape'));
        $this->getOptions()->setIsFontSubsettingEnabled(true);
        $this->render();

        if ($output_type == 'S') {
            $output = $this->output();
            write_file('assets/uploads/' . $name, $output);
            return 'assets/uploads/' . $name;
        } else {
            $this->stream($name);
            return true;
        }
    }

}
