<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Shop_Controller
{

    function __construct() {
        parent::__construct();

        if ($this->Settings->mmode && $this->v != 'login') { redirect('notify/offline'); }
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
    }

    function index() {
        if (!SHOP) { redirect('admin'); }
        $this->data['featured_products'] = $this->shop_model->getFeaturedProducts();
        $this->data['slider'] = json_decode($this->shop_settings->slider);
        $this->data['page_title'] = $this->shop_settings->shop_name;
        $this->data['page_desc'] = $this->shop_settings->description;
        $this->page_construct('index', $this->data);
    }

    function profile($act = NULL) {
        if (!$this->loggedIn) { redirect('/'); }
        if (!SHOP || $this->Staff) { redirect('admin/users/profile/'.$this->session->userdata('user_id')); }
        $user = $this->ion_auth->user()->row();
        if ($act == 'user') {

            $this->form_validation->set_rules('first_name', lang("first_name"), 'required');
            $this->form_validation->set_rules('last_name', lang("last_name"), 'required');
            $this->form_validation->set_rules('phone', lang("phone"), 'required');
            $this->form_validation->set_rules('email', lang("email"), 'required|valid_email');
            $this->form_validation->set_rules('company', lang("company"), 'trim');
            $this->form_validation->set_rules('vat_no', lang("vat_no"), 'trim');
            $this->form_validation->set_rules('address', lang("billing_address"), 'required');
            $this->form_validation->set_rules('city', lang("city"), 'required');
            $this->form_validation->set_rules('state', lang("state"), 'required');
            $this->form_validation->set_rules('postal_code', lang("postal_code"), 'required');
            $this->form_validation->set_rules('country', lang("country"), 'required');
            if ($user->email != $this->input->post('email')) {
                $this->form_validation->set_rules('email', lang("email"), 'trim|is_unique[users.email]');
            }

            if ($this->form_validation->run() === TRUE) {

                $bdata = [
                    'name' => $this->input->post('first_name').' '.$this->input->post('last_name'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'company' => $this->input->post('company'),
                    'vat_no' => $this->input->post('vat_no'),
                    'address' => $this->input->post('address'),
                    'city' => $this->input->post('city'),
                    'state' => $this->input->post('state'),
                    'postal_code' => $this->input->post('postal_code'),
                    'country' => $this->input->post('country'),
                ];

                $udata = [
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                ];

                if ($this->ion_auth->update($user->id, $udata) && $this->shop_model->updateCompany($user->company_id, $bdata)) {
                    $this->session->set_flashdata('message', lang('user_updated'));
                    $this->session->set_flashdata('message', lang('billing_data_updated'));
                    redirect("profile");
                }

            } else {
                $this->session->set_flashdata('error', validation_errors());
                redirect($_SERVER["HTTP_REFERER"]);
            }

        } elseif ($act == 'password') {

            $this->form_validation->set_rules('old_password', lang('old_password'), 'required');
            $this->form_validation->set_rules('new_password', lang('new_password'), 'required|min_length[8]|max_length[25]');
            $this->form_validation->set_rules('new_password_confirm', lang('confirm_password'), 'required|matches[new_password]');

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('profile');
            } else {
                if (DEMO) {
                    $this->session->set_flashdata('warning', lang('disabled_in_demo'));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));
                $change = $this->ion_auth->change_password($identity, $this->input->post('old_password'), $this->input->post('new_password'));

                if ($change) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    $this->logout('m');
                } else {
                    $this->session->set_flashdata('error', $this->ion_auth->errors());
                    redirect('profile');
                }
            }

        }

        $this->data['featured_products'] = $this->shop_model->getFeaturedProducts();
        $this->data['customer'] = $this->site->getCompanyByID($this->session->userdata('company_id'));
        $this->data['user'] = $this->site->getUser();
        $this->data['page_title'] = lang('profile');
        $this->data['page_desc'] = $this->shop_settings->description;
        $this->page_construct('user/profile', $this->data);
    }

    function login($m = NULL) {
        if (!SHOP || $this->Settings->mmode) { redirect('admin/login'); }
        if ($this->loggedIn) {
            $this->session->set_flashdata('error', $this->session->flashdata('error'));
            redirect('/');
        }

        if ($this->Settings->captcha) {
            $this->form_validation->set_rules('captcha', lang('captcha'), 'required|callback_captcha_check');
        }

        if ($this->form_validation->run('auth/login') == true) {

            $remember = (bool)$this->input->post('remember_me');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                if ($this->Settings->mmode) {
                    if (!$this->ion_auth->in_group('owner')) {
                        $this->session->set_flashdata('error', lang('site_is_offline_plz_try_later'));
                        redirect('logout');
                    }
                }

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $referrer = ($this->session->userdata('requested_page') && $this->session->userdata('requested_page') != 'admin') ? $this->session->userdata('requested_page') : '/';
                redirect($referrer);
            } else {
                $this->session->set_flashdata('error', $this->ion_auth->errors());
                redirect('login');
            }

        } else {

            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->data['message'] = $m ? lang('password_changed') : $this->session->flashdata('message');
            $this->data['page_title'] = lang('login');
            $this->data['page_desc'] = $this->shop_settings->description;
            $this->page_construct('user/login', $this->data);

        }
    }

    function logout($m = NULL) {
        if (!SHOP) { redirect('admin/logout'); }
        $logout = $this->ion_auth->logout();
        $referrer = (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '/');
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect($m ? 'login/m' : $referrer);
    }

    function register() {

        $this->form_validation->set_rules('first_name', lang("first_name"), 'required');
        $this->form_validation->set_rules('last_name', lang("last_name"), 'required');
        $this->form_validation->set_rules('phone', lang("phone"), 'required');
        $this->form_validation->set_rules('company', lang("company"), 'required');
        $this->form_validation->set_rules('email', lang("email_address"), 'required|is_unique[users.email]');
        $this->form_validation->set_rules('username', lang("username"), 'required|is_unique[users.username]');
        $this->form_validation->set_rules('password', lang('password'), 'required|min_length[8]|max_length[20]|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', lang('confirm_password'), 'required');

        if ($this->form_validation->run('') == true) {

            $email = strtolower($this->input->post('email'));
            $username = strtolower($this->input->post('username'));
            $password = $this->input->post('password');

            $customer_group = $this->shop_model->getCustomerGroup($this->Settings->customer_group);
            $price_group = $this->shop_model->getPriceGroup($this->Settings->price_group);

            $company_data = [
                'company' => $this->input->post('company') ? $this->input->post('company') : '-',
                'name' => $this->input->post('first_name').' '.$this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'group_id' => 3,
                'group_name' => 'customer',
                'customer_group_id' => (!empty($customer_group)) ? $customer_group->id : NULL,
                'customer_group_name' => (!empty($customer_group)) ? $customer_group->name : NULL,
                'price_group_id' => (!empty($price_group)) ? $price_group->id : NULL,
                'price_group_name' => (!empty($price_group)) ? $price_group->name : NULL,
            ];

            $company_id = $this->shop_model->addCustomer($company_data);

            $additional_data = [
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'phone' => $this->input->post('phone'),
                'company' => $this->input->post('company'),
                'gender' => 'male',
                'company_id' => $company_id,
                'group_id' => 3
            ];
            $this->load->library('ion_auth');
        }

        if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data)) {
            $this->session->set_flashdata('message', lang("account_created"));
            redirect('login');
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect('login#register');
        }
    }

    function activate($id, $code) {
        if (!SHOP) { redirect('admin/auth/activate/'.$id.'/'.$code); }
        if ($code) {
            if ($activation = $this->ion_auth->activate($id, $code)) {
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("login");
            }
        } else {
            $this->session->set_flashdata('error', $this->ion_auth->errors());
            redirect("login");
        }
    }

    function forgot_password() {
        if (!SHOP) { redirect('admin/auth/forgot_password'); }
        $this->form_validation->set_rules('email', lang('email_address'), 'required|valid_email');

        if ($this->form_validation->run() == false) {
            $this->sma->send_json(validation_errors());
        } else {

            $identity = $this->ion_auth->where('email', strtolower($this->input->post('email')))->users()->row();
            if (empty($identity)) {
                $this->sma->send_json(lang('forgot_password_email_not_found'));
            }

            $forgotten = $this->ion_auth->forgotten_password($identity->email);
            if ($forgotten) {
                $this->sma->send_json(['status' => 'success', 'message' => $this->ion_auth->messages()]);
            } else {
                $this->sma->send_json(['status' => 'error', 'message' => $this->ion_auth->errors()]);
            }
        }
    }

    function reset_password($code = NULL) {
        if (!SHOP) { redirect('admin/auth/reset_password/'.$code); }
        if (!$code) {
            $this->session->set_flashdata('error', lang('page_not_found'));
            redirect('/');
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {

            $this->form_validation->set_rules('new', lang('password'), 'required|min_length[8]|max_length[25]|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', lang('confirm_password'), 'required');

            if ($this->form_validation->run() == false) {

                $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $this->data['message'] = $this->session->flashdata('message');
                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = [
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'class' => 'form-control',
                    'required' => 'required',
                    'pattern' => '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}',
                    'data-fv-regexp-message' => lang('pasword_hint'),
                    'placeholder' => lang('new_password')
                ];
                $this->data['new_password_confirm'] = [
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'class' => 'form-control',
                    'required' => 'required',
                    'data-fv-identical' => 'true',
                    'data-fv-identical-field' => 'new',
                    'data-fv-identical-message' => lang('pw_not_same'),
                    'placeholder' => lang('confirm_password')
                ];
                $this->data['user_id'] = [
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                ];
                $this->data['code'] = $code;
                $this->data['identity_label'] = $user->email;
                $this->data['page_title'] = lang('reset_password');
                $this->data['page_desc'] = '';
                $this->page_construct('user/reset_password', $this->data);

            } else {
                // do we have a valid request?
                if ($user->id != $this->input->post('user_id')) {

                    $this->ion_auth->clear_forgotten_password_code($code);
                    redirect('notify/csrf');

                } else {
                    // finally change the password
                    $identity = $user->email;

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));
                    if ($change) {
                        //if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect('login');
                    } else {
                        $this->session->set_flashdata('error', $this->ion_auth->errors());
                        redirect('reset_password/' . $code);
                    }
                }
            }
        } else {
            //if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('error', $this->ion_auth->errors());
            redirect('/');
        }
    }

    function captcha_check($cap) {
        $expiration = time() - 300; // 5 minutes limit
        $this->db->delete('captcha', ['captcha_time <' => $expiration]);

        $this->db->select('COUNT(*) AS count')
        ->where('word', $cap)
        ->where('ip_address', $this->input->ip_address())
        ->where('captcha_time >', $expiration);

        if ($this->db->count_all_results('captcha')) {
            return true;
        } else {
            $this->form_validation->set_message('captcha_check', lang('captcha_wrong'));
            return FALSE;
        }
    }

    function hide($id = NULL) {
        $this->session->set_userdata('hidden' . $id, 1);
        echo true;
    }

    function language($lang) {
        $folder = 'app/language/';
        $languagefiles = scandir($folder);
        if (in_array($lang, $languagefiles)) {
            set_cookie('shop_language', $lang, 31536000);
        }
        redirect($_SERVER["HTTP_REFERER"]);
    }

    function currency($currency) {
        set_cookie('shop_currency', $currency, 31536000);
        redirect($_SERVER["HTTP_REFERER"]);
    }

    function cookie($val) {
        set_cookie('shop_use_cookie', $val, 31536000);
        redirect($_SERVER["HTTP_REFERER"]);
    }

}
