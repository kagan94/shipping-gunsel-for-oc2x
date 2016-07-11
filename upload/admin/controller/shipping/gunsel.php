<?php
class ControllerShippingGunsel extends Controller
{
    private $error = array();

    public function __construct($registry)
    {
        parent::__construct($registry);

        $data = $this->load->language('shipping/gunsel');
        $this->load->model('setting/setting');
    }

    public function index()
    {
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('gunsel', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('shipping/gunsel', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->document->setTitle($this->language->get('heading_title'));

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        // Show success msg
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_shipping'),
            'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('shipping/gunsel', 'token=' . $this->session->data['token'], 'SSL'),
        );

        $data['action'] = $this->url->link('shipping/gunsel', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
        $data['token']  = $this->session->data['token'];

        if (isset($this->request->post['gunsel_min_total_for_free_delivery'])) {
            $data['gunsel_min_total_for_free_delivery'] = $this->request->post['gunsel_min_total_for_free_delivery'];
        } else {
            $data['gunsel_min_total_for_free_delivery'] = $this->config->get('gunsel_min_total_for_free_delivery');
        }

        if (isset($this->request->post['gunsel_fixed_price_for_delivery'])) {
            $data['gunsel_fixed_price_for_delivery'] = $this->request->post['gunsel_fixed_price_for_delivery'];
        } else {
            $data['gunsel_fixed_price_for_delivery'] = $this->config->get('gunsel_fixed_price_for_delivery');
        }

        if (isset($this->request->post['gunsel_geo_zone_id'])) {
            $data['gunsel_geo_zone_id'] = $this->request->post['gunsel_geo_zone_id'];
        } else {
            $data['gunsel_geo_zone_id'] = $this->config->get('gunsel_geo_zone_id');
        }

        if (isset($this->request->post['gunsel_status'])) {
            $data['gunsel_status'] = $this->request->post['gunsel_status'];
        } else {
            $data['gunsel_status'] = $this->config->get('gunsel_status');
        }

        if (isset($this->request->post['gunsel_sort_order'])) {
            $data['gunsel_sort_order'] = $this->request->post['gunsel_sort_order'];
        } else {
            $data['gunsel_sort_order'] = $this->config->get('gunsel_sort_order');
        }

        $this->load->model('localisation/geo_zone');

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        // Lang
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_all_zones'] = $this->language->get('text_all_zones');

        $data['text_disabled']                    = $this->language->get('text_disabled');
        $data['text_enabled']                     = $this->language->get('text_enabled');
        $data['text_select']                      = $this->language->get('text_select');
        $data['text_shipping']                    = $this->language->get('text_shipping');
        $data['text_success']                     = $this->language->get('text_success');
        $data['text_edit']                        = $this->language->get('text_edit');
        $data['text_fixed_shipping_price']        = $this->language->get('text_fixed_shipping_price');
        $data['text_min_total_for_free_delivery'] = $this->language->get('text_min_total_for_free_delivery');
        $data['text_free_shipping']               = $this->language->get('text_free_shipping');
        $data['entry_geo_zone']                   = $this->language->get('entry_geo_zone');
        $data['entry_status']                     = $this->language->get('entry_status');
        $data['entry_sort_order']                 = $this->language->get('entry_sort_order');

        $data['text_general_settings'] = $this->language->get('text_general_settings');
        $data['text_support']          = $this->language->get('text_support');

        $data['button_save']   = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['link_to_support'] = 'http://opencart-modules.com/en/tab-modules?lang=' . trim($this->config->get('config_admin_language'));

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('shipping/gunsel.tpl', $data));
    }

    private function validate()
    {
        if (!$this->user->hasPermission('modify', 'shipping/gunsel')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}
