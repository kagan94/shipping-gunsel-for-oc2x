<?php

class ModelShippingGunsel extends Model
{
    private $cost = 0.00;

    public function getQuote($address)
    {
        $this->load->language('shipping/gunsel');

        if ($this->config->get('gunsel_status')) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $this->config->get('gunsel_geo_zone_id') . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");

            if (!$this->config->get('gunsel_geo_zone_id')) {
                $status = true;
            } elseif ($query->num_rows) {
                $status = true;
            } else {
                $status = false;
            }
        } else {
            $status = false;
        }

        $method_data = array();

        if ($status) {
            $quote_data = array();

            // Включена фиксированная стоимость доставки
            if (trim($this->config->get('gunsel_fixed_price_for_delivery')) != "") {
                $this->cost = (float) $this->config->get('gunsel_fixed_price_for_delivery');
            }

            // Бесплатная доставка если сума заказа свыше суммы X
            // ИЛИ доставка бесплатная по-умолчанию
            if (($this->cart->getSubTotal() >= (float) $this->config->get('gunsel_min_total_for_free_delivery') && trim($this->config->get('gunsel_min_total_for_free_delivery')) != "")
                || $this->config->get('gunsel_free_shipping')
            ) {
                $free_shipping_text = $this->language->get('text_free_shipping');
                $this->cost         = 0.00;
            }

            $quote_data['gunsel'] = array(
                'code'         => 'gunsel.gunsel',
                'title'        => $this->language->get('text_description'),
                'cost'         => $this->cost,
                'tax_class_id' => 0,
                'text'         => isset($free_shipping_text) ? $free_shipping_text : $this->setCurrencyFormat($this->cost),
            );

            $method_data = array(
                'code'       => 'gunsel',
                'title'      => $this->language->get('text_title'),
                'quote'      => $quote_data,
                'sort_order' => $this->config->get('gunsel_sort_order'),
                'error'      => false,
            );
        }

        return $method_data;
    }

    public function setCurrencyFormat($val)
    {
        if ($this->getCurrentOCVersion() >= 2200) {
            return $this->currency->format($val, $this->session->data['currency']);
        } else {
            return $this->currency->format($val);
        }
    }

    public function getCurrentOCVersion()
    {
        $version = VERSION;
        $version = str_replace('.', '', $version);

        return (int) $version;
    }

}
