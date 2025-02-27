<?php
class ControllerExtensionModuleTmdcmafilter extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/tmd_cmafilter');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->setTitle($this->language->get('heading_title1'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('tmd_cmafilter', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/tmd_cmafilter', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/tmd_cmafilter', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();


		$data['heading_title']       = $this->language->get('heading_title');
		$data['text_edit']           = $this->language->get('text_edit');
		$data['text_yes']            = $this->language->get('text_yes');
		$data['text_no']             = $this->language->get('text_no');
		$data['text_enabled']        = $this->language->get('text_enabled');
		$data['text_disabled']       = $this->language->get('text_disabled');
		$data['text_select']         = $this->language->get('text_select');
		$data['entry_status']        = $this->language->get('entry_status');
		$data['entry_category']      = $this->language->get('entry_category');
		$data['entry_sb_category']   = $this->language->get('entry_sb_category');
		$data['entry_ssb_category']  = $this->language->get('entry_ssb_category');
		$data['entry_brand']         = $this->language->get('entry_brand');
		$data['entry_attributes']    = $this->language->get('entry_attributes');
		$data['entry_search_input']  = $this->language->get('entry_search_input');
		$data['entry_attriname']     = $this->language->get('entry_attriname');
		$data['entry_heading_title'] = $this->language->get('entry_heading_title');
		$data['entry_title_color']   = $this->language->get('entry_title_color');
		$data['entry_text_color']    = $this->language->get('entry_text_color');
		$data['entry_bgcolor']       = $this->language->get('entry_bgcolor');

		$data['tab_general']         = $this->language->get('tab_general');
		$data['tab_language']        = $this->language->get('tab_language');

		$data['button_save']         = $this->language->get('button_save');
		$data['button_cancel']       = $this->language->get('button_cancel');


		if (isset($this->request->post['tmd_cmafilter_status'])) {
			$data['tmd_cmafilter_status'] = $this->request->post['tmd_cmafilter_status'];
		} else {
			$data['tmd_cmafilter_status'] = $this->config->get('tmd_cmafilter_status');
		}

		if (isset($this->request->post['tmd_cmafilter_category'])) {
			$data['tmd_cmafilter_category'] = $this->request->post['tmd_cmafilter_category'];
		} else {
			$data['tmd_cmafilter_category'] = $this->config->get('tmd_cmafilter_category');
		}

		if (isset($this->request->post['tmd_cmafilter_sub_category'])) {
			$data['tmd_cmafilter_sub_category'] = $this->request->post['tmd_cmafilter_sub_category'];
		} else {
			$data['tmd_cmafilter_sub_category'] = $this->config->get('tmd_cmafilter_sub_category');
		}

		if (isset($this->request->post['tmd_cmafilter_sub_sub_category'])) {
			$data['tmd_cmafilter_sub_sub_category'] = $this->request->post['tmd_cmafilter_sub_sub_category'];
		} else {
			$data['tmd_cmafilter_sub_sub_category'] = $this->config->get('tmd_cmafilter_sub_sub_category');
		}

		if (isset($this->request->post['tmd_cmafilter_brand'])) {
			$data['tmd_cmafilter_brand'] = $this->request->post['tmd_cmafilter_brand'];
		} else {
			$data['tmd_cmafilter_brand'] = $this->config->get('tmd_cmafilter_brand');
		}

		if (isset($this->request->post['tmd_cmafilter_attribute'])) {
			$data['tmd_cmafilter_attribute'] = $this->request->post['tmd_cmafilter_attribute'];
		} else {
			$data['tmd_cmafilter_attribute'] = $this->config->get('tmd_cmafilter_attribute');
		}

		if (isset($this->request->post['tmd_cmafilter_search_input'])) {
			$data['tmd_cmafilter_search_input'] = $this->request->post['tmd_cmafilter_search_input'];
		} else {
			$data['tmd_cmafilter_search_input'] = $this->config->get('tmd_cmafilter_search_input');
		}

		if (isset($this->request->post['tmd_cmafilter_attribute_id'])) {
			$data['tmd_cmafilter_attribute_id'] = $this->request->post['tmd_cmafilter_attribute_id'];
		} else {
			$data['tmd_cmafilter_attribute_id'] = $this->config->get('tmd_cmafilter_attribute_id');
		}

		// Language Tab
		if (isset($this->request->post['tmd_cmafilter_language'])) {
			$data['tmd_cmafilter_language'] = $this->request->post['tmd_cmafilter_language'];
		} else {
			$data['tmd_cmafilter_language'] = $this->config->get('tmd_cmafilter_language');
		}

		if (isset($this->request->post['tmd_cmafilter_title_color'])) {
			$data['tmd_cmafilter_title_color'] = $this->request->post['tmd_cmafilter_title_color'];
		} else {
			$data['tmd_cmafilter_title_color'] = $this->config->get('tmd_cmafilter_title_color');
		}

		if (isset($this->request->post['tmd_cmafilter_text_color'])) {
			$data['tmd_cmafilter_text_color'] = $this->request->post['tmd_cmafilter_text_color'];
		} else {
			$data['tmd_cmafilter_text_color'] = $this->config->get('tmd_cmafilter_text_color');
		}

		if (isset($this->request->post['tmd_cmafilter_btn_bg_color'])) {
			$data['tmd_cmafilter_btn_bg_color'] = $this->request->post['tmd_cmafilter_btn_bg_color'];
		} else {
			$data['tmd_cmafilter_btn_bg_color'] = $this->config->get('tmd_cmafilter_btn_bg_color');
		}

		$this->load->model('catalog/attribute');
		$data['attributes'] = $this->model_catalog_attribute->getAttributes();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tmd_cmafilter', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tmd_cmafilter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}