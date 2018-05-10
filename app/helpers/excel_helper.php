<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists('create_excel')) {
    function create_excel($excel, $filename) {
        header("Content-Type: ".get_mime_by_extension('xlsx'));
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}
