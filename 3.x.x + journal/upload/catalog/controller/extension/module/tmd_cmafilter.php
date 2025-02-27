<?php
class ControllerExtensionModuleTmdcmafilter extends Controller {
	public function index() {
		$this->load->language('extension/module/tmd_cmafilter');
		$this->load->model('extension/module/tmd_cmafilter');
		$this->load->model('tool/image');

		if (!empty($this->request->get['search'])) {
			$search = $this->request->get['search'];
			$data['search'] = $this->request->get['search'];
		} else {
			$search = '';
			$data['search'] = '';
		}

		if (!empty($this->request->get['filter_brand'])) {
			$filter_brand = $this->request->get['filter_brand'];
			$data['filter_brand'] = $this->request->get['filter_brand'];
		} else {
			$filter_brand = '';
			$data['filter_brand'] = '';
		}

		if (!empty($this->request->get['filter_first_level'])) {
			$filter_first_level = $this->request->get['filter_first_level'];
			$data['filter_first_level'] = $this->request->get['filter_first_level'];
		} else {
			$filter_first_level = '';
			$data['filter_first_level'] = '';
		}

		if (!empty($this->request->get['filter_second_level'])) {
			$filter_second_level = $this->request->get['filter_second_level'];
			$data['filter_second_level'] = $this->request->get['filter_second_level'];
		} else {
			$filter_second_level = '';
			$data['filter_second_level'] = '';
		}

		if (!empty($this->request->get['filter_third_level'])) {
			$filter_third_level = $this->request->get['filter_third_level'];
			$data['filter_third_level'] = $this->request->get['filter_third_level'];
		} else {
			$filter_third_level = '';
			$data['filter_third_level'] = '';
		}

		if (!empty($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
			$data['filter_model'] = $this->request->get['filter_model'];
		} else {
			$filter_model = '';
			$data['filter_model'] = '';
		}

		if (!empty($this->request->get['filter_range'])) {
			$price_info = explode(';', $this->request->get['filter_range']);
			$data['filter_price_from'] = $price_info[0];
			$data['filter_price_to'] = $price_info[1];
			$filter_price_from = $price_info[0];
			$filter_price_to = $price_info[1];
		} else {
			$filter_price_from = false;
			$filter_price_to = false;
			$data['filter_price_from'] = false;
			$data['filter_price_to'] = false;
		}

		$url = '';

		if (isset($this->request->get['search'])) {
			$url .= '&search=' . $this->request->get['search'];
		}

		if (isset($this->request->get['filter_range'])) {
			$url .= '&filter_range=' . $this->request->get['filter_range'];
		}

		if (isset($this->request->get['filter_brand'])) {
			$url .= '&filter_brand=' . $this->request->get['filter_brand'];
		}

		if (isset($this->request->get['filter_first_level'])) {
			$url .= '&filter_first_level=' . $this->request->get['filter_first_level'];
		}

		if (isset($this->request->get['filter_second_level'])) {
			$url .= '&filter_second_level=' . $this->request->get['filter_second_level'];
		}

		if (isset($this->request->get['filter_third_level'])) {
			$url .= '&filter_third_level=' . $this->request->get['filter_third_level'];
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . $this->request->get['filter_model'];
		}

		$data['tmd_status']          =  $this->config->get('module_tmd_cmafilter_status');
		$data['tmd_category']        =  $this->config->get('module_tmd_cmafilter_category');
		$data['tmd_sub_category']    =  $this->config->get('module_tmd_cmafilter_sub_category');
		$data['tmd_sub_subcategory'] =  $this->config->get('module_tmd_cmafilter_sub_sub_category');
		$data['tmd_brand']           =  $this->config->get('module_tmd_cmafilter_brand');
		$data['tmd_attribute']       =  $this->config->get('module_tmd_cmafilter_attribute');
		$data['tmd_search_input']    =  $this->config->get('module_tmd_cmafilter_search_input');
		$attribute_id                =  $this->config->get('module_tmd_cmafilter_attribute_id');
	    $data['price_range_status']  =  $this->config->get('module_tmd_cmafilter_price_range');
	    $data['heading_bgcolor']     =  $this->config->get('module_tmd_cmafilter_heading_bgcolor');

	    if($this->config->get('module_tmd_cmafilter_price_min')) {
			$data['price_min'] =  $this->config->get('module_tmd_cmafilter_price_min');
		} else {
			$data['price_min'] = 0;
		}

		if($this->config->get('module_tmd_cmafilter_price_max')) {
			$data['price_max'] =  $this->config->get('module_tmd_cmafilter_price_max');
		} else {
			$data['price_max'] = '100';
		}


		$module_language        =  $this->config->get('module_tmd_cmafilter_language');
		if(!empty($module_language[$this->config->get('config_language_id')]['heading_title'])){
		  $data['heading_title1'] = $module_language[$this->config->get('config_language_id')]['heading_title'];
		} else {
		  $data['heading_title1'] = $this->language->get('heading_title1');
		}

		if(!empty($module_language[$this->config->get('config_language_id')]['category'])){
		  $data['text_category'] = $module_language[$this->config->get('config_language_id')]['category'];
		} else {
		  $data['text_category'] = $this->language->get('entry_category');
		}

		if(!empty($module_language[$this->config->get('config_language_id')]['sb_category'])){
		  $data['text_sb_category'] = $module_language[$this->config->get('config_language_id')]['sb_category'];
		} else {
		  $data['text_sb_category'] = $this->language->get('entry_sb_category');
		}

		if(!empty($module_language[$this->config->get('config_language_id')]['ssb_category'])){
		  $data['text_ssb_category'] = $module_language[$this->config->get('config_language_id')]['ssb_category'];
		} else {
		  $data['text_ssb_category'] = $this->language->get('entry_ssb_category');
		}

		if(!empty($module_language[$this->config->get('config_language_id')]['brand'])){
		  $data['text_brand'] = $module_language[$this->config->get('config_language_id')]['brand'];
		} else {
		  $data['text_brand'] = $this->language->get('entry_brand');
		}

		if(!empty($module_language[$this->config->get('config_language_id')]['attributes'])){
		  $data['text_attributes'] = $module_language[$this->config->get('config_language_id')]['attributes'];
		} else {
		  $data['text_attributes'] = $this->language->get('entry_attributes');
		}

		if(!empty($module_language[$this->config->get('config_language_id')]['search'])){
		  $data['text_search'] = $module_language[$this->config->get('config_language_id')]['search'];
		} else {
		  $data['text_search'] = $this->language->get('entry_search_input');
		}

		$data['tmd_text_color']      =  $this->config->get('module_tmd_cmafilter_text_color');
		$data['tmd_btn_bg_color']    =  $this->config->get('module_tmd_cmafilter_btn_bg_color');
		$data['tmd_title_color']    =  $this->config->get('module_tmd_cmafilter_title_color');
		

		$this->load->model('extension/cmaattribute');
		$data['attributes'] = $this->model_extension_cmaattribute->getAttributes();
		
		$this->load->model('catalog/manufacturer');
		$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers($data);
		
		$this->load->model('catalog/category');
		$data['categories'] = $this->model_catalog_category->getCategories();
				
		return $this->load->view('extension/module/tmd_cmafilter', $data);	
	}

	public function subcategory() {
		$json = array();
		$this->load->language('extension/module/tmd_cmafilter');
		$this->load->model('extension/module/tmd_cmafilter');
		$category_infos = $this->model_extension_module_tmd_cmafilter->getCategories($this->request->get['filter_first_level']);
		
		foreach($category_infos as $category_info){
			if($category_info) {
				$json['subcategory'][]= array(
					'category_id'      => $category_info['category_id'],
					'name'             => $category_info['name'],
				);
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function subsubcategory() {
		$json = array();
		$this->load->language('extension/module/tmd_cmafilter');
		$this->load->model('extension/module/tmd_cmafilter');
		$category_infos = $this->model_extension_module_tmd_cmafilter->getCategories($this->request->get['filter_second_level']);
		
		if(!empty($this->request->get['filter_second_level'])){
			foreach($category_infos as $category_info){
				if ($category_info) {
					$json['subsubcategory'][]= array(
						'category_id'      => $category_info['category_id'],
						'name'             => $category_info['name'],
					);
				}
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
