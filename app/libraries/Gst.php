<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 *  ==============================================================================
 *  Author    : Mian Saleem
 *  Email     : saleem@tecdiary.com
 *  For       : Stock Manager Advance
 *  Web       : http://tecdiary.com
 *  ==============================================================================
 */

class Gst
{

    public function __construct() {
    }

    public function __get($var) {
        return get_instance()->$var;
    }

    function summary($rows = [], $return_rows = [], $product_tax = 0, $onCost = false) {
        $code = '';
        if ($this->Settings->invoice_view > 0 && !empty($rows)) {
            $tax_summary = $this->taxSummary($rows, $onCost);
            if (!empty($return_rows)) {
                $return_tax_summary = $this->taxSummary($return_rows, $onCost);
                $tax_summary = $tax_summary + $return_tax_summary;
            }
            $code = $this->genHTML($tax_summary, $product_tax);
        }
        return $code;
    }

    function taxSummary($rows = [], $onCost = false) {
        $tax_summary = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                if (isset($tax_summary[$row->tax_code])) {
                    $tax_summary[$row->tax_code]['items'] += $row->unit_quantity;
                    $tax_summary[$row->tax_code]['tax'] += $row->item_tax;
                    $tax_summary[$row->tax_code]['amt'] += ($row->unit_quantity * ($onCost ? $row->net_unit_cost : $row->net_unit_price));
                } else {
                    $tax_summary[$row->tax_code]['items'] = $row->unit_quantity;
                    $tax_summary[$row->tax_code]['tax'] = $row->item_tax;
                    $tax_summary[$row->tax_code]['amt'] = ($row->unit_quantity * ($onCost ? $row->net_unit_cost : $row->net_unit_price));
                    $tax_summary[$row->tax_code]['name'] = $row->tax_name;
                    $tax_summary[$row->tax_code]['code'] = $row->tax_code;
                    $tax_summary[$row->tax_code]['rate'] = $row->tax_rate;
                }
            }
        }
        return $tax_summary;
    }

    function genHTML($tax_summary = [], $product_tax = 0) {
        $html = '';
        if (!empty($tax_summary)) {
            $html .= '<div style="text-align:left;"><h4 style="font-weight:bold;">' . lang('tax_summary') . '</h4></div>';
            $html .= '<table class="table table-bordered table-striped print-table order-table table-condensed"><thead><tr><th>' . lang('name') . '</th><th>' . lang('code') . '</th><th>' . lang('qty') . '</th><th>' . lang('tax_excl') . '</th><th>' . lang('tax_amt') . '</th></tr></td><tbody>';
            foreach ($tax_summary as $summary) {
                $html .= '<tr><td>' . $summary['name'] . '</td><td style="text-align:center;">' . $summary['code'] . '</td><td class="text-center">' . $this->sma->formatQuantity($summary['items']) . '</td><td style="text-align:right;">' . $this->sma->formatMoney($summary['amt']) . '</td><td class="text-right">' . $this->sma->formatMoney($summary['tax']) . '</td></tr>';
            }
            $html .= '</tbody></tfoot>';
            $html .= '<tr class="active"><th colspan="4" style="text-align:right;">' . lang('total_tax_amount') . '</th><th class="text-right">' . $this->sma->formatMoney($product_tax) . '</th></tr>';
            $html .= '</tfoot></table>';
        }
        return $html;
    }

    function calculteIndianGST($item_tax, $state, $tax_details) {
        if ($this->Settings->indian_gst) {
            $cgst = $sgst = $igst = 0;
            if ($state) {
                $gst = $tax_details->type == 1 ? $this->sma->formatDecimal(($tax_details->rate/2), 0).'%' : $this->sma->formatDecimal(($tax_details->rate/2), 0);
                $cgst = $this->sma->formatDecimal(($item_tax / 2), 4);
                $sgst = $this->sma->formatDecimal(($item_tax / 2), 4);
            } else {
                $gst = $tax_details->type == 1 ? $this->sma->formatDecimal(($tax_details->rate), 0).'%' : $this->sma->formatDecimal(($tax_details->rate), 0);
                $igst = $item_tax;
            }
            return ['gst' => $gst, 'cgst' => $cgst, 'sgst' => $sgst, 'igst' => $igst];
        }
        return [];
    }

    function getIndianStates($blank = false) {
        $istates  = [
            'AN' => 'Andaman & Nicobar',
            'AP' => 'Andhra Pradesh',
            'AR' => 'Arunachal Pradesh',
            'AS' => 'Assam',
            'BR' => 'Bihar',
            'CH' => 'Chandigarh',
            'CT' => 'Chhattisgarh',
            'DN' => 'Dadra and Nagar Haveli',
            'DD' => 'Daman & Diu',
            'DL' => 'Delhi',
            'GA' => 'Goa',
            'GJ' => 'Gujarat',
            'HR' => 'Haryana',
            'HP' => 'Himachal Pradesh',
            'JK' => 'Jammu & Kashmir',
            'JH' => 'Jharkhand',
            'KA' => 'Karnataka',
            'KL' => 'Kerala',
            'LD' => 'Lakshadweep',
            'MP' => 'Madhya Pradesh',
            'MH' => 'Maharashtra',
            'MN' => 'Manipur',
            'ML' => 'Meghalaya',
            'MZ' => 'Mizoram',
            'NL' => 'Nagaland',
            'OR' => 'Odisha',
            'PY' => 'Puducherry',
            'PB' => 'Punjab',
            'RJ' => 'Rajasthan',
            'SK' => 'Sikkim',
            'TN' => 'Tamil Nadu',
            'TS' => 'Telangana',
            'TR' => 'Tripura',
            'UK' => 'Uttarakhand',
            'UP' => 'Uttar Pradesh',
            'WB' => 'West Bengal',
        ];
        if ($blank) {
            array_unshift($istates, lang('select'));
        }
        return $istates;
    }



}
