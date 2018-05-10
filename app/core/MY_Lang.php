<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Lang extends CI_Lang {

    function __construct() {
        parent::__construct();
    }

    public function admin_load($langfile, $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '') {
		return $this->my_load($langfile, $idiom, $return, $add_suffix, $alt_path, 'admin');
	}

    public function shop_load($langfile, $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '') {
        return $this->my_load($langfile, $idiom, $return, $add_suffix, $alt_path, 'shop');
    }

    public function my_load($langfile, $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '', $path = NULL) {
		if (is_array($langfile)) {
			foreach ($langfile as $value) {
				$this->load($value, $idiom, $return, $add_suffix, $alt_path);
			}

			return;
		}

		$langfile = str_replace('.php', '', $langfile);

		if ($add_suffix === TRUE) {
			$langfile = preg_replace('/_lang$/', '', $langfile).'_lang';
		}

		$langfile .= '.php';

		if (empty($idiom) OR ! preg_match('/^[a-z_-]+$/i', $idiom)) {
			$config =& get_config();
			$idiom = empty($config['language']) ? 'english' : $config['language'];
		}

		if ($return === FALSE && isset($this->is_loaded[$langfile]) && $this->is_loaded[$langfile] === $idiom) {
			return;
		}

		$basepath = BASEPATH.'language/'.$idiom.'/'.($path ? $path.'/' : '').$langfile;
		if (($found = file_exists($basepath)) === TRUE) {
			include($basepath);
		}

		if ($alt_path !== '') {
			$alt_path .= 'language/'.$idiom.'/'.$langfile;
			if (file_exists($alt_path)) {
				include($alt_path);
				$found = TRUE;
			}
		} else {
			foreach (get_instance()->load->get_package_paths(TRUE) as $package_path) {
				$package_path .= 'language/'.$idiom.'/'.($path ? $path.'/' : '').$langfile;
				if ($basepath !== $package_path && file_exists($package_path)) {
					include($package_path);
					$found = TRUE;
					break;
				}
			}
		}

		if ($found !== TRUE) {
			show_error('Unable to load the requested language file: language/'.$idiom.'/'.($path ? $path.'/' : '').$langfile);
		}

		if ( ! isset($lang) OR ! is_array($lang)) {
			log_message('error', 'Language file contains no data: language/'.$idiom.'/'.($path ? $path.'/' : '').$langfile);

			if ($return === TRUE) {
				return array();
			}
			return;
		}

		if ($return === TRUE) {
			return $lang;
		}

		$this->is_loaded[$langfile] = $idiom;
		$this->language = array_merge($this->language, $lang);

		log_message('info', 'Language file loaded: language/'.$idiom.'/'.($path ? $path.'/' : '').$langfile);
		return TRUE;
	}

    public function line($line, $params = NULL) {
        $return = parent::line($line);
        if($return === false) {
            return str_replace('_', ' ', $line);
        } else {
            if(! is_null($params)) {
                $return = $this->_ni_line($return, $params);
            }
            return $return;
        }
    }

    private function _ni_line($str, $params) {
        $return = $str;
        $params = is_array($params) ? $params : array($params);
        $search = array();
        $cnt = 1;
        foreach($params as $param) {
            $search[$cnt] = "/\\${$cnt}/";
            $cnt++;
        }
        unset($search[0]);
        $return = preg_replace($search, $params, $return);
        return $return;
    }
}
