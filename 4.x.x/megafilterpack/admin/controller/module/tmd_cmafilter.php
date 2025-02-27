<?php
namespace Opencart\Admin\Controller\Extension\Megafilterpack\Module;
// Lib Include 
require_once(DIR_EXTENSION.'/megafilterpack/system/library/tmd/system.php');
// Lib Include
class Tmdcmafilter extends \Opencart\System\Engine\Controller {
	
	public function index() {
		$this->registry->set('tmd', new  \Megafilterpack\System\Library\Tmd\System($this->registry));
		$keydata=array(
		'code'=>'tmdkey_tmd_cmafilter',
		'eid'=>'NDM0Njc=',
		'route'=>'extension/megafilterpack/module/tmd_cmafilter',
		);
		$tmd_cmafilter=$this->tmd->getkey($keydata['code']);
		$data['getkeyform']=$this->tmd->loadkeyform($keydata);
		
		$this->load->language('extension/megafilterpack/module/tmd_cmafilter');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->setTitle($this->language->get('heading_title1'));
		
		if (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];
		
			unset($this->session->data['warning']);
		} else {
			$data['error_warning'] = '';
		}

		$this->load->model('setting/setting');
		
		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];
		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title1'),
			'href' => $this->url->link('extension/megafilterpack/module/tmd_cmafilter', 'user_token=' . $this->session->data['user_token'])
		];
       

        if(VERSION>='4.0.2.0'){
          	$data['save'] = $this->url->link('extension/megafilterpack/module/tmd_cmafilter.save', 'user_token=' . $this->session->data['user_token']);
        }else{
			$data['save'] = $this->url->link('extension/megafilterpack/module/tmd_cmafilter|save', 'user_token=' . $this->session->data['user_token']);
	    }

		$data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

		$data['HTTP_CATALOG']=HTTP_CATALOG;

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

		if (isset($this->request->post['module_tmd_cmafilter_heading_bgcolor'])) {
			$data['module_tmd_cmafilter_heading_bgcolor'] = $this->request->post['module_tmd_cmafilter_heading_bgcolor'];
		} else {
			$data['module_tmd_cmafilter_heading_bgcolor'] = $this->config->get('module_tmd_cmafilter_heading_bgcolor');
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
		$this->response->setOutput($this->load->view('extension/megafilterpack/module/tmd_cmafilter', $data));
	}

	public function save(): void {
		$this->load->language('extension/megafilterpack/module/tmd_cmafilter');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/megafilterpack/module/tmd_cmafilter')) {
			$json['error'] = $this->language->get('error_permission');
		}
		
		$tmd_cmafilter=$this->config->get('tmdkey_tmd_cmafilter');
		if (empty(trim($tmd_cmafilter))) {			
		$json['error'] ='Module will Work after add License key!';
		}
		
		if (!$json) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('module_tmd_cmafilter', $this->request->post);

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	//  EVENT 
	
	public function keysubmit() {
		$json = array(); 
		
      	if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$keydata=array(
			'code'=>'tmdkey_tmd_cmafilter',
			'eid'=>'NDM0Njc=',
			'route'=>'extension/megafilterpack/module/tmd_cmafilter',
			'moduledata_key'=>$this->request->post['moduledata_key'],
			);
			$this->registry->set('tmd', new  \Megafilterpack\System\Library\Tmd\System($this->registry));
		
            $json=$this->tmd->matchkey($keydata);       
		} 
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function install(){

    $this->load->model('setting/event');

    $this->load->model('user/user_group');

    $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/megafilterpack/module/tmd_cmafilter');

    $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/megafilterpack/module/tmd_cmafilter');

    $this->model_setting_event->deleteEventByCode('module_cmafilter');

    if(VERSION>='4.0.2.0')
        {
            $eventaction='extension/megafilterpack/module/tmd_cmafilter.menu';
        }
        else{
            $eventaction='extension/megafilterpack/module/tmd_cmafilter|menu';
        }
      $eventrequest=[

            'code'=>'module_cmafilter',
            'description'=>'TMD CMA FILTER',
            'trigger'=>'admin/view/common/column_left/before',
            'action'=>$eventaction,
            'status'=>'1',
            'sort_order'=>'1',

        ];

        if(VERSION=='4.0.0.0')

        {

        $this->model_setting_event->addEvent('module_cmafilter', 'TMD CMA FILTER', 'admin/view/common/column_left/before','extension/megafilterpack/module/tmd_cmafilter|menu', true, 1);

        }else{

            $this->model_setting_event->addEvent($eventrequest);

        }

       // product search event

       if(VERSION>='4.0.2.0')
        {
            $eventaction='extension/megafilterpack/module/tmd_cmafilter.Productsearch';
        }
        else{
            $eventaction='extension/megafilterpack/module/tmd_cmafilter|Productsearch';
        }
       $eventrequest=[

            'code'=>'module_product_search',
            'description'=>'TMD CMA SEARCH',
            'trigger'=>'catalog/view/product/search/before',
            'action'=>$eventaction,
            'status'=>'1',
            'sort_order'=>'1',


        ];

        if(VERSION=='4.0.0.0')

        {

        $this->model_setting_event->addEvent('module_product_search', 'TMD CMA SEARCH', 'catalog/view/product/search/before','extension/megafilterpack/module/tmd_cmafilter|Productsearch', true, 1);

        }else{

            $this->model_setting_event->addEvent($eventrequest);

        }


        // front model filter

         if(VERSION>='4.0.2.0')
        {
            $eventaction='extension/megafilterpack/module/tmd_cmafilter.getProducts';
        }
        else{
            $eventaction='extension/megafilterpack/module/tmd_cmafilter|getProducts';
        }
       $eventrequest=[

            'code'=>'module_product_search_model',
            'description'=>'TMD CMA SEARCH MODEL',
            'trigger'=>'catalog/model/catalog/product/getProducts/after',
            'action'=>$eventaction,
            'status'=>'1',
            'sort_order'=>'1',

        ];

        if(VERSION=='4.0.0.0')

        {

        $this->model_setting_event->addEvent('module_product_search_model', 'TMD CMA SEARCH MODEL', 'catalog/model/catalog/product/getProducts/after','extension/megafilterpack/module/tmd_cmafilter|getProducts', true, 1);

        }else{

            $this->model_setting_event->addEvent($eventrequest);

        }

    }

    public function uninstall() {

    $this->load->model('setting/event');

    $this->load->model('user/user_group');    

    $this->model_setting_event->deleteEventByCode('module_cmafilter');


        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/megafilterpack/module/tmd_cmafilter');

        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/megafilterpack/module/tmd_cmafilter');

    }

       public function menu(string&$route, array&$args, mixed&$output):void {
        $this->load->language('extension/megafilterpack/module/tmd_cmafilter');

        $args['modulestatus'] = $this->config->get('module_tmd_cmafilter_status');

        $modulestatus         = $this->config->get('module_tmd_cmafilter_status');

        if(!empty($modulestatus)){

   

        if ($this->user->hasPermission('access', 'extension/megafilterpack/module/tmd_cmafilter')) {		
				$args['menus'][] = [
					'id'       => 'menu-dashboard',
					'icon'	   => 'fa fa-filter',
					'name'	   => $this->language->get('text_tmd_cmafilter'),
					'href'     => $this->url->link('extension/megafilterpack/module/tmd_cmafilter', 'user_token=' . $this->session->data['user_token'], true),
					'children' => []
				];	


			}
		}
    }

	
}