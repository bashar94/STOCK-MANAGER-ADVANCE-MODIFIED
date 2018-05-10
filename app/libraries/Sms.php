<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  ==============================================================================
 *  Author  : Mian Saleem
 *  Email   : saleem@tecdiary.com
 *  For     : SMS Lib
 *  ==============================================================================
 */


class Sms
{
    public function __construct()
    {
        $this->lang->admin_load('sms', $this->Settings->language);
        $this->Settings->sms_lib = 'tec_twilio';
        $this->Settings->sms_id = '';
        $this->Settings->sms_secret = '';
        $this->load->library(
            $this->Settings->sms_lib,
            ['sid' => $this->Settings->sms_id, 'token' => $this->Settings->sms_secret],
            'tec_sms'
        );
        $this->load->library('parser');
    }

    public function __get($var)
    {
        return get_instance()->$var;
    }

    public function send($to, $from, $body)
    {
        try {
            $send = $this->tec_sms->send($to, $from, $body);
            return ['sending' => true, 'error' => false, 'message' => ''];
        } catch (Twilio\Exceptions\RestException $e) {
            return ['sending' => false, 'error' => true, 'message' => $e->getMessage()];
        }
    }

    public function saleNotification($sale_id, $body)
    {
        $sale = $this->site->getSaleByID($sale_id);
        $biller = $this->site->getCompanyByID($sale->biller_id);
        $customer = $this->site->getCompanyByID($sale->customer_id);
        $parse_data = array(
            'customer' => $customer->company && $customer->company != '-' ? $customer->company : $customer->name,
            'sale_reference' => $sale->reference_no,
            'grand_total' => $this->sma->formatMoney($sale->grand_total),
        );
        $body = $this->parser->parse_string($body, $parse_data);
        if ($biller->phone && $customer->phone) {
            return $this->send($customer->phone, $biller->phone, $body);
        }
        return false;
    }

    public function sendSaleNotification($sale_id)
    {
        $body = lang('sale_added');
        return $this->saleNotification($sale_id, $body);
    }

    public function sendPaymentNotification($payment_id)
    {
        $body = lang('payment_received');
        $payment = $this->sms_model->getPaymentByID($payment_id);
        $parse_data = array(
            'payment_reference' => $payment->reference_no,
            'amount' => $this->sma->formatMoney($payment->amount),
        );
        $body = $this->parser->parse_string($body, $parse_data);
        return $this->saleNotification($payment->sale_id, $body);
    }

    public function sendDeliveryNotification($delivery_id)
    {
        $body = lang('delivering');
        $delivery = $this->sms_model->getDeliveryByID($delivery_id);
        $parse_data = array(
            'delivery_reference' => $delivery->do_reference_no,
            'received_by' => $delivery->received_by,
        );
        $body = $this->parser->parse_string($body, $parse_data);
        return $this->saleNotification($delivery->sale_id, $body);
    }
}
