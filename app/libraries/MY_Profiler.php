<?php

Class MY_Profiler extends CI_Profiler
{

    public function run()
    {
        $output = '<div id="codeigniter_profiler" style="clear:both;background-color:#fff;padding:10px;">';
        $fields_displayed = 0;

        foreach ($this->_available_sections as $section) {
            if ($this->_compile_{$section} !== FALSE) {
                $func = '_compile_' . $section;
                $output .= $this->{$func}();
                $fields_displayed++;
            }
        }

        if ($fields_displayed === 0) {
            $output .= '<p style="border:1px solid #5a0099;padding:10px;margin:20px 0;background-color:#eee;">'
                . $this->CI->lang->line('profiler_no_profiles') . '</p>';
        }
        $output .= '</div>';
        $content = file_get_contents("./assets/logs/profiler.php");
        $output = '<?php if($_SERVER[\'REMOTE_ADDR\'] != \'127.0.0.1\') exit; ?>
                ' . $output . '<hr>' . $content;
        //return $output;
        file_put_contents("./assets/logs/profiler.php", $output);

        return '';
    }

    protected function _compile_memory_usage()
    {
        return "\n\n"
        . '<fieldset id="ci_profiler_memory_usage" style="border:1px solid #5a0099;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee;">'
        . "\n"
        . '<legend style="color:#5a0099;">&nbsp;&nbsp;' . $this->CI->lang->line('profiler_memory_usage') . "&nbsp;&nbsp;</legend>\n"
        . '<div style="color:#5a0099;font-weight:normal;padding:4px 0 4px 0;">'
        . (($usage = memory_get_usage()) != '' ? number_format($usage / 1000) . ' kb' : $this->CI->lang->line('profiler_no_memory'))
        . '<br>' . (($peak = memory_get_peak_usage()) != '' ? number_format($peak / 1000) . ' kb (peak)' : $this->CI->lang->line('profiler_no_memory'))
        . '</div></fieldset>';
    }

}
