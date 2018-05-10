<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
*  ==============================================================================
*  Author   : Mian Saleem
*  Email    : saleem@tecdiary.com
*  Web      : http://tecdiary.com
*  ==============================================================================
*/

require FCPATH . 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

class Tec_mail
{

    public function __construct() {

    }

    public function __get($var) {
        return get_instance()->$var;
    }

    public function send_mail($to, $subject, $body, $from = NULL, $from_name = NULL, $attachment = NULL, $cc = NULL, $bcc = NULL) {

        try {
            $mail = new PHPMailer;
            $mail->isSMTP();
            // $mail->SMTPDebug = 4;
            $mail->Host = $this->Settings->smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $this->Settings->smtp_user;
            $mail->Password = $this->Settings->smtp_pass;
            $mail->SMTPSecure = !empty($this->Settings->smtp_crypto) ? $this->Settings->smtp_crypto : false;
            $mail->Port = $this->Settings->smtp_port;

            if ($from && $from_name) {
                $mail->setFrom($from, $from_name);
                $mail->setaddReplyToFrom($from, $from_name);
            } elseif ($from) {
                $mail->setFrom($from, $this->Settings->site_name);
                $mail->addReplyTo($from, $this->Settings->site_name);
            } else {
                $mail->setFrom($this->Settings->default_email, $this->Settings->site_name);
                $mail->addReplyTo($this->Settings->default_email, $this->Settings->site_name);
            }

            $mail->addAddress($to);
            if ($cc) { $mail->addCC($cc); }
            if ($bcc) { $mail->addBCC($bcc); }
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $body;
            if ($attachment) {
                if (is_array($attachment)) {
                    foreach ($attachment as $attach) {
                        $mail->addAttachment($attach);
                    }
                } else {
                    $mail->addAttachment($attachment);
                }
            }

            if (!$mail->send()) {
                throw new Exception($mail->ErrorInfo);
                return FALSE;
            }
            return TRUE;
        } catch (phpmailerException $e) {
            throw new Exception($e->errorMessage());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}
