<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *  ============================================================================== 
 *  Author  : Mian Saleem
 *  Email   : saleem@tecdiary.com 
 *  For     : Stock Manager Advance
 *  Web     : http://tecdiary.com
 *  ============================================================================== 
 */

class Logs
{

    protected $_log_path;
    protected $_file_permissions = 0644;
    protected $_date_fmt = 'Y-m-d H:i:s';
    protected $_file_ext;
    protected $_enabled = TRUE;

    function __get($var)
    {
        return get_instance()->$var;
    }

    public function __construct()
    {
        $this->config->load('config');
        $this->_log_path = ($this->config->item('log_path') !== '') ? $this->config->item('log_path') : APPPATH . 'logs/';
        $this->_file_ext = ($this->config->item('log_file_extension') !== '') ? ltrim($this->config->item('log_file_extension'), '.') : 'php';
        file_exists($this->_log_path) OR mkdir($this->_log_path, 0755, TRUE);
        if (!is_dir($this->_log_path) OR !is_really_writable($this->_log_path)) {
            $this->_enabled = FALSE;
        }
        if ($this->config->item('log_date_format')) {
            $this->_date_fmt = $this->config->item('log_date_format');
        }
        if ($this->config->item('log_file_permissions') && is_int($this->config->item('log_file_permissions'))) {
            $this->_file_permissions = $this->config->item('log_file_permissions');
        }
    }

    public function write($type, $msg, $val = NULL)
    {
        if ($this->_enabled === FALSE) {
            return FALSE;
        }

        $filepath = $this->_log_path . 'payments-' . date('Y-m-d') . '.' . $this->_file_ext;
        $message = '';

        if (!file_exists($filepath)) {
            $newfile = TRUE;
            if ($this->_file_ext === 'php') {
                $message .= "<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>\n\n";
            }
        }
        if (!$fp = @fopen($filepath, 'ab')) {
            return FALSE;
        }

        $message .= $type.' - '.date($this->_date_fmt) . ' --> ' . $msg . " (" . $this->input->ip_address() . ") " . ($val ? $val : "") . "\n";
        flock($fp, LOCK_EX);
        for ($written = 0, $length = strlen($message); $written < $length; $written += $result) {
            if (($result = fwrite($fp, substr($message, $written))) === FALSE) {
                break;
            }
        }
        flock($fp, LOCK_UN);
        fclose($fp);
        if (isset($newfile) && $newfile === TRUE) {
            chmod($filepath, $this->_file_permissions);
        }

        return is_int($result);
    }

    public function delete($type = NULL, $date = NULL)
    {
        if (!$type || $this->_enabled === FALSE) {
            return FALSE;
        }
        if (!$date) {
            $date = date('Y-m-d', strtotime('-1 month'));
        }
        $deleted = 0;
        $kept = 0;

        $files = glob($this->_log_path . $type . '*.php');

        foreach ($files as $file) {
            if (filemtime($file) < strtotime($date)) {
                unlink($file);
                $deleted++;
            } else {
                $kept++;
            }
        }
        $total = $deleted + $kept;

        $res = array('total' => $total, 'deleted' => $deleted, 'kept' => $kept);
        return $res;
    }

}
