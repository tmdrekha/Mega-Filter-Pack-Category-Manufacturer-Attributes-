<?php
//lib
require_once(DIR_SYSTEM.'library/tmd/system.php');
//lib
class ControllerExtensionModuleTmdcmafilter extends Controller {
	private $error = array();

	public function index() {
		$this->registry->set('tmd', new TMD($this->registry));
		$keydata=array(
		'code'=>'tmdkey_tmd_cmafilter',
		'eid'=>'NDM0Njc=',
		'route'=>'extension/module/tmd_cmafilter',
		);
		$tmd_cmafilter=$this->tmd->getkey($keydata['code']);
		$data['getkeyform']=$this->tmd->loadkeyform($keydata);
		
		$this->load->language('extension/module/tmd_cmafilter');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->setTitle($this->language->get('heading_title1'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_tmd_cmafilter', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];
		
			unset($this->session->data['warning']);
		} else {
			$data['error_warning'] = '';
		}
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title1'),
			'href' => $this->url->link('extension/module/tmd_cmafilter', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/tmd_cmafilter', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);


		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['module_tmd_cmafilter_status'])) {
			$data['module_tmd_cmafilter_status'] = $this->request->post['module_tmd_cmafilter_status'];
		} else {
			$data['module_tmd_cmafilter_status'] = $this->config->get('module_tmd_cmafilter_status');
		}

		if (isset($this->request->post['module_tmd_cmafilter_category'])) {
			$data['module_tmd_cmafilter_category'] = $this->request->post['module_tmd_cmafilter_category'];
		} else {
			$data['module_tmd_cmafilter_category'] = $this->config->get('module_tmd_cmafilter_category');
		}

		if (isset($this->request->post['module_tmd_cmafilter_sub_category'])) {
			$data['module_tmd_cmafilter_sub_category'] = $this->request->post['module_tmd_cmafilter_sub_category'];
		} else {
			$data['module_tmd_cmafilter_sub_category'] = $this->config->get('module_tmd_cmafilter_sub_category');
		}

		if (isset($this->request->post['module_tmd_cmafilter_sub_sub_category'])) {
			$data['module_tmd_cmafilter_sub_sub_category'] = $this->request->post['module_tmd_cmafilter_sub_sub_category'];
		} else {
			$data['module_tmd_cmafilter_sub_sub_category'] = $this->config->get('module_tmd_cmafilter_sub_sub_category');
		}

		if (isset($this->request->post['module_tmd_cmafilter_brand'])) {
			$data['module_tmd_cmafilter_brand'] = $this->request->post['module_tmd_cmafilter_brand'];
		} else {
			$data['module_tmd_cmafilter_brand'] = $this->config->get('module_tmd_cmafilter_brand');
		}

		if (isset($this->request->post['module_tmd_cmafilter_attribute'])) {
			$data['module_tmd_cmafilter_attribute'] = $this->request->post['module_tmd_cmafilter_attribute'];
		} else {
			$data['module_tmd_cmafilter_attribute'] = $this->config->get('module_tmd_cmafilter_attribute');
		}

		if (isset($this->request->post['module_tmd_cmafilter_search_input'])) {
			$data['module_tmd_cmafilter_search_input'] = $this->request->post['module_tmd_cmafilter_search_input'];
		} else {
			$data['module_tmd_cmafilter_search_input'] = $this->config->get('module_tmd_cmafilter_search_input');
		}

		if (isset($this->request->post['module_tmd_cmafilter_price_range'])) {
			$data['module_tmd_cmafilter_price_range'] = $this->request->post['module_tmd_cmafilter_price_range'];
		} else {
			$data['module_tmd_cmafilter_price_range'] = $this->config->get('module_tmd_cmafilter_price_range');
		}

		if (isset($this->request->post['module_tmd_cmafilter_heading_bgcolor'])) {
			$data['module_tmd_cmafilter_heading_bgcolor'] = $this->request->post['module_tmd_cmafilter_heading_bgcolor'];
		} else {
			$data['module_tmd_cmafilter_heading_bgcolor'] = $this->config->get('module_tmd_cmafilter_heading_bgcolor');
		}
		

		if (isset($this->request->post['module_tmd_cmafilter_price_min'])) {
			$data['module_tmd_cmafilter_price_min'] = $this->request->post['module_tmd_cmafilter_price_min'];
		} else {
			$data['module_tmd_cmafilter_price_min'] = $this->config->get('module_tmd_cmafilter_price_min');
		}

		if (isset($this->request->post['module_tmd_cmafilter_price_max'])) {
			$data['module_tmd_cmafilter_price_max'] = $this->request->post['module_tmd_cmafilter_price_max'];
		} else {
			$data['module_tmd_cmafilter_price_max'] = $this->config->get('module_tmd_cmafilter_price_max');
		}

		if (isset($this->request->post['module_tmd_cmafilter_attribute_id'])) {
			$data['module_tmd_cmafilter_attribute_id'] = $this->request->post['module_tmd_cmafilter_attribute_id'];
		} else {
			$data['module_tmd_cmafilter_attribute_id'] = $this->config->get('module_tmd_cmafilter_attribute_id');
		}

		// Language Tab
		if (isset($this->request->post['module_tmd_cmafilter_language'])) {
			$data['module_tmd_cmafilter_language'] = $this->request->post['module_tmd_cmafilter_language'];
		} else {
			$data['module_tmd_cmafilter_language'] = $this->config->get('module_tmd_cmafilter_language');
		}

		if (isset($this->request->post['module_tmd_cmafilter_title_color'])) {
			$data['module_tmd_cmafilter_title_color'] = $this->request->post['module_tmd_cmafilter_title_color'];
		} else {
			$data['module_tmd_cmafilter_title_color'] = $this->config->get('module_tmd_cmafilter_title_color');
		}

		if (isset($this->request->post['module_tmd_cmafilter_text_color'])) {
			$data['module_tmd_cmafilter_text_color'] = $this->request->post['module_tmd_cmafilter_text_color'];
		} else {
			$data['module_tmd_cmafilter_text_color'] = $this->config->get('module_tmd_cmafilter_text_color');
		}

		if (isset($this->request->post['module_tmd_cmafilter_btn_bg_color'])) {
			$data['module_tmd_cmafilter_btn_bg_color'] = $this->request->post['module_tmd_cmafilter_btn_bg_color'];
		} else {
			$data['module_tmd_cmafilter_btn_bg_color'] = $this->config->get('module_tmd_cmafilter_btn_bg_color');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tmd_cmafilter', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tmd_cmafilter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$tmd_cmafilter=$this->config->get('tmdkey_tmd_cmafilter');
		if (empty(trim($tmd_cmafilter))) {			
		$this->session->data['warning'] ='Module will Work after add License key!';
		$this->response->redirect($this->url->link('extension/module/tmd_cmafilter', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		return !$this->error;
	}
	public function keysubmit() {
		$json = array(); 
		
      	if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$keydata=array(
			'code'=>'tmdkey_tmd_cmafilter',
			'eid'=>'NDM0Njc=',
			'route'=>'extension/module/tmd_cmafilter',
			'moduledata_key'=>$this->request->post['moduledata_key'],
			);
			$this->registry->set('tmd', new TMD($this->registry));
            $json=$this->tmd->matchkey($keydata);       
		} 
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}