<?php
namespace Opencart\Catalog\Controller\Extension\Megafilterpack\Module;
use \Opencart\System\Helper as Helper;
class Tmdcmafilter extends \Opencart\System\Engine\Controller {

	public function index() {
		$this->load->language('extension/megafilterpack/module/tmd_cmafilter');
		$this->load->model('extension/megafilterpack/module/tmd_cmafilter');
		$this->load->model('tool/image');

		$data['VERSION']=VERSION;

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
		$data['price_range_status']  =  $this->config->get('module_tmd_cmafilter_price_range');
		$data['tmd_text_color']      =  $this->config->get('module_tmd_cmafilter_text_color');
		$data['tmd_btn_bg_color']    =  $this->config->get('module_tmd_cmafilter_btn_bg_color');
		$data['tmd_title_color']     =  $this->config->get('module_tmd_cmafilter_title_color');
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

		$attribute_id  =  $this->config->get('module_tmd_cmafilter_attribute_id');

		$module_language =  $this->config->get('module_tmd_cmafilter_language');
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

		if(!empty($module_language[$this->config->get('config_language_id')]['price_range'])){
			$data['entry_price_range'] = $module_language[$this->config->get('config_language_id')]['price_range'];
		} else {
		  	$data['entry_price_range'] = $this->language->get('entry_price_range');
		}

		if(!empty($module_language[$this->config->get('config_language_id')]['button_filter'])){
			$data['button_filter'] = $module_language[$this->config->get('config_language_id')]['button_filter'];
		} else {
		  	$data['button_filter'] = $this->language->get('button_filter');
		}
		
		$this->load->model('extension/megafilterpack/tmd/cmaattribute');
		$data['attributes'] = $this->model_extension_megafilterpack_tmd_cmaattribute->getAttributes();
		
		$this->load->model('catalog/manufacturer');
		$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers($data);
		
		$this->load->model('catalog/category');
		$data['categories'] = $this->model_catalog_category->getCategories();
		
		if(!empty($this->session->data['currency'])) {
			$this->load->model('localisation/currency');
			$currency_info = $this->model_localisation_currency->getCurrencyByCode($this->session->data['currency']);
			if(!empty($currency_info['symbol_left'])) {
				$data['currency_prefix'] = $currency_info['symbol_left'];
			}elseif(!empty($currency_info['symbol_right'])) {
				$data['currency_prefix'] = $currency_info['symbol_right'];
			} else {
				$data['currency_prefix'] = '$';
			}
		}
		return $this->load->view('extension/megafilterpack/module/tmd_cmafilter', $data);	
	}

	public function subcategory() {
		$json = array();
		$this->load->language('extension/megafilterpack/module/tmd_cmafilter');
		$this->load->model('extension/megafilterpack/module/tmd_cmafilter');
		$category_infos = $this->model_extension_megafilterpack_module_tmd_cmafilter->getCategories($this->request->get['filter_first_level']);
		
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
		$this->load->language('extension/megafilterpack/module/tmd_cmafilter');
		$this->load->model('extension/megafilterpack/module/tmd_cmafilter');
		$category_infos = $this->model_extension_megafilterpack_module_tmd_cmafilter->getCategories($this->request->get['filter_second_level']);
		
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

	public function Productsearch(string&$route,array&$args,mixed &$output){
		$modulestatus     = $this->config->get('module_tmd_cmafilter_status');
        if(!empty($modulestatus)){
		    $this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$this->load->model('extension/megafilterpack/tmd/cmaattribute');
			$this->load->model('tool/image');

			if (isset($this->request->get['search'])) {
				$search = $this->request->get['search'];
			} else {
				$search = '';
			}

			if (isset($this->request->get['tag'])) {
				$tag = $this->request->get['tag'];
			} elseif (isset($this->request->get['search'])) {
				$tag = $this->request->get['search'];
			} else {
				$tag = '';
			}

			if (isset($this->request->get['description'])) {
				$description = $this->request->get['description'];
			} else {
				$description = '';
			}

			if (isset($this->request->get['category_id'])) {
				$category_id = (int)$this->request->get['category_id'];
			} else {
				$category_id = 0;
			}

			if (isset($this->request->get['sub_category'])) {
				$sub_category = $this->request->get['sub_category'];
			} else {
				$sub_category = 0;
			}

			if (isset($this->request->get['filter_search'])) {
				$filter_search = $this->request->get['filter_search'];
			} else {
				$filter_search = '';
			}

			if (isset($this->request->get['filter_brand'])) {
				$filter_brand = $this->request->get['filter_brand'];
			} else {
				$filter_brand = '';
			}

			if (isset($this->request->get['filter_first_level'])) {
				$filter_first_level = $this->request->get['filter_first_level'];
			} else {
				$filter_first_level = '';
			}

			if (isset($this->request->get['filter_second_level'])) {
				$filter_second_level = $this->request->get['filter_second_level'];
			} else {
				$filter_second_level = '';
			}

			if (isset($this->request->get['filter_third_level'])) {
				$filter_third_level = $this->request->get['filter_third_level'];
			} else {
				$filter_third_level = '';
			}

			if (!empty($this->request->get['filter_range'])) {
				$price_info = explode(';', $this->request->get['filter_range']);
				$filter_price_from = $price_info[0];
				$filter_price_to = $price_info[1];
			} else {
				$filter_price_from = false;
				$filter_price_to = false;
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}
			
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
			} else {
				$sort = 'p.sort_order';
			}

			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
			} else {
				$order = 'ASC';
			}

			if (isset($this->request->get['page'])) {
				$page = (int)$this->request->get['page'];
			} else {
				$page = 1;
			}

			if (isset($this->request->get['limit']) && (int)$this->request->get['limit']) {
				$limit = (int)$this->request->get['limit'];
			} else {
				$limit = $this->config->get('config_pagination');
			}

			if (isset($this->request->get['search'])) {
				$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->request->get['search']);
			} elseif (isset($this->request->get['tag'])) {
				$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->language->get('heading_tag') . $this->request->get['tag']);
			} else {
				$this->document->setTitle($this->language->get('heading_title'));
			}

			$args['breadcrumbs'] = [];

			$args['breadcrumbs'][] = [
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home', 'language=' . $this->config->get('config_language'))
			];

			$url = '';

			if (isset($this->request->get['filter_range'])) {
				$url .= '&filter_range=' . $this->request->get['filter_range'];
			}

			if (isset($this->request->get['filter_search'])) {
				$url .= '&filter_search=' . $this->request->get['filter_search'];
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
			
			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$args['breadcrumbs'][] = [
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('product/search', 'language=' . $this->config->get('config_language') . $url)
			];

			if (isset($this->request->get['search'])) {
				$args['heading_title'] = $this->language->get('heading_title') .  ' - ' . $this->request->get['search'];
			} else {
				$args['heading_title'] = $this->language->get('heading_title');
			}

			$args['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

			$args['compare'] = $this->url->link('product/compare', 'language=' . $this->config->get('config_language'));

			$this->load->model('catalog/category');

			// 3 Level Category Search
			$args['categories'] = [];

			$categories_1 = $this->model_catalog_category->getCategories(0);

			foreach ($categories_1 as $category_1) {
				$level_2_data = [];

				$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);

				foreach ($categories_2 as $category_2) {
					$level_3_data = [];

					$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

					foreach ($categories_3 as $category_3) {
						$level_3_data[] = [
							'category_id' => $category_3['category_id'],
							'name'        => $category_3['name'],
						];
					}

					$level_2_data[] = [
						'category_id' => $category_2['category_id'],
						'name'        => $category_2['name'],
						'children'    => $level_3_data
					];
				}

				$args['categories'][] = [
					'category_id' => $category_1['category_id'],
					'name'        => $category_1['name'],
					'children'    => $level_2_data
				];
			}

			$args['products'] = [];

			if (isset($this->request->get['search']) || isset($this->request->get['tag']) || isset($this->request->get['filter_first_level']) || isset($this->request->get['filter_second_level']) || isset($this->request->get['filter_third_level']) || isset($this->request->get['filter_brand']) || isset($this->request->get['filter_range']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_search'])) {
				$filter_data = [
					'filter_search'        => $filter_search,
					'filter_brand'         => $filter_brand,
					'filter_first_level'   => $filter_first_level,
					'filter_second_level'  => $filter_second_level,
					'filter_third_level'   => $filter_third_level,
					'filter_price_from'    => $filter_price_from,
					'filter_price_to'      => $filter_price_to,
					'filter_model'         => $filter_model,
					'filter_name'         => $search,
					'filter_tag'          => $tag,
					'filter_description'  => $description,
					'filter_category_id'  => $category_id,
					'filter_sub_category' => $sub_category,
					'sort'                => $sort,
					'order'               => $order,
					'start'               => ($page - 1) * $limit,
					'limit'               => $limit
				];

				$product_total = $this->model_extension_megafilterpack_tmd_cmaattribute->getTotalProducts($filter_data);

				$results = $this->model_extension_megafilterpack_tmd_cmaattribute->getProducts($filter_data);


				foreach ($results as $result) {
					if (is_file(DIR_IMAGE . html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'))) {
						$image = $this->model_tool_image->resize(html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'), $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
					}

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$price = false;
					}

					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
					} else {
						$tax = false;
					}

					if(VERSION>='4.0.2.0'){

					$product_data = [
						'product_id'  => $result['product_id'],
						'thumb'       => $image,
						'name'        => $result['name'],
					   'description' => oc_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('config_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
						'rating'      => $result['rating'],
						'href'        => $this->url->link('product/product', 'language=' . $this->config->get('config_language') . '&product_id=' . $result['product_id'] . $url)
					];
				}else{
	                $product_data = [
						'product_id'  => $result['product_id'],
						'thumb'       => $image,
						'name'        => $result['name'],
					   'description' =>  Helper\Utf8\substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('config_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
						'rating'      => $result['rating'],
						'href'        => $this->url->link('product/product', 'language=' . $this->config->get('config_language') . '&product_id=' . $result['product_id'] . $url)
					];

				}

				$args['products'][] = $this->load->controller('product/thumb', $product_data);
			}

			$url = '';

			if (isset($this->request->get['filter_range'])) {
				$url .= '&filter_range=' . $this->request->get['filter_range'];
			}

			if (isset($this->request->get['filter_search'])) {
				$url .= '&filter_search=' . $this->request->get['filter_search'];
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
		
			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$args['sorts'] = [];

			$args['sorts'][] = [
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/search', 'language=' . $this->config->get('config_language') . '&sort=p.sort_order&order=ASC' . $url)
			];

			$args['sorts'][] = [
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/search', 'language=' . $this->config->get('config_language') . '&sort=pd.name&order=ASC' . $url)
			];

			$args['sorts'][] = [
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/search', 'language=' . $this->config->get('config_language') . '&sort=pd.name&order=DESC' . $url)
			];

			$args['sorts'][] = [
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/search', 'language=' . $this->config->get('config_language') . '&sort=p.price&order=ASC' . $url)
			];

			$args['sorts'][] = [
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/search', 'language=' . $this->config->get('config_language') . '&sort=p.price&order=DESC' . $url)
			];

			if ($this->config->get('config_review_status')) {
				$args['sorts'][] = [
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/search', 'language=' . $this->config->get('config_language') . '&sort=rating&order=DESC' . $url)
				];

				$args['sorts'][] = [
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/search', 'language=' . $this->config->get('config_language') . '&sort=rating&order=ASC' . $url)
				];
			}

			$args['sorts'][] = [
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/search', 'language=' . $this->config->get('config_language') . '&sort=p.model&order=ASC' . $url)
			];

			$args['sorts'][] = [
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/search', 'language=' . $this->config->get('config_language') . '&sort=p.model&order=DESC' . $url)
			];

			$url = '';

			// CMA Filter

			if (isset($this->request->get['filter_range'])) {
				$url .= '&filter_range=' . $this->request->get['filter_range'];
			}

			if (isset($this->request->get['filter_search'])) {
				$url .= '&filter_search=' . $this->request->get['filter_search'];
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

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$args['limits'] = [];

			$limits = array_unique([$this->config->get('config_pagination'), 25, 50, 75, 100]);

			sort($limits);

			foreach ($limits as $value) {
				$args['limits'][] = [
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/search', 'language=' . $this->config->get('config_language') . $url . '&limit=' . $value)
				];
			}

			$url = '';

			if (isset($this->request->get['filter_range'])) {
				$url .= '&filter_range=' . $this->request->get['filter_range'];
			}

			if (isset($this->request->get['filter_search'])) {
				$url .= '&filter_search=' . $this->request->get['filter_search'];
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

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$args['pagination'] = $this->load->controller('common/pagination', [
				'total' => $product_total,
				'page'  => $page,
				'limit' => $limit,
				'url'   => $this->url->link('product/search', 'language=' . $this->config->get('config_language') . $url . '&page={page}')
			]);

			$args['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

			if (isset($this->request->get['search']) && $this->config->get('config_customer_search')) {
				$this->load->model('account/search');

				if ($this->customer->isLogged()) {
					$customer_id = $this->customer->getId();
				} else {
					$customer_id = 0;
				}

				if (isset($this->request->server['REMOTE_ADDR'])) {
					$ip = $this->request->server['REMOTE_ADDR'];
				} else {
					$ip = '';
				}

				$search_data = [
					'keyword'      => $search,
					'category_id'  => $category_id,
					'sub_category' => $sub_category,
					'description'  => $description,
					'products'     => $product_total,
					'customer_id'  => $customer_id,
					'ip'           => $ip
				];

				$this->model_account_search->addSearch($search_data);
			}
		}

		$args['language'] = $this->config->get('config_language');
		$args['search'] = $search;
		
		$args['filter_search']       = $filter_search;
		$args['filter_brand']        = $filter_brand;
		$args['filter_first_level']  = $filter_first_level;
		$args['filter_second_level'] = $filter_second_level;
		$args['filter_third_level']  = $filter_third_level;
		$args['filter_model']        = $filter_model;
		$args['filter_price_from']   = $filter_price_from;
		$args['filter_price_to']     = $filter_price_to;

		$args['description'] = $description;
		$args['category_id'] = $category_id;
		$args['sub_category'] = $sub_category;

		$args['sort'] = $sort;
		$args['order'] = $order;
		$args['limit'] = $limit;

 		$template_buffer = $this->getTemplateBuffer($route,$output);            

		$find='location = url;';
		$replace='var filter_first_level = $("select[name=\"filter_first_level\"]").val();
	    if (filter_first_level!="0") {
	      url += "&filter_first_level=" + encodeURIComponent(filter_first_level);
	    }

	    var filter_second_level = $("select[name=\"filter_second_level\"]").val();

	    if (filter_second_level!="0") {
	      url += "&filter_second_level=" + encodeURIComponent(filter_second_level);
	    }

	    var filter_third_level = $("select[name=\"filter_third_level\"]").val();

	    if (filter_third_level!="0") {
	      url += "&filter_third_level=" + encodeURIComponent(filter_third_level);
	    }

	    var filter_brand = $("select[name=\'filter_brand\"]").val();

	    if (filter_brand!="0") {
	      url += "&filter_brand=" + encodeURIComponent(filter_brand);
	    }

	    var filter_range = $("input[name=\'filter_range\"]").prop("value");

	    if (filter_range) {
	      url += "&filter_range=" + encodeURIComponent(filter_range);
	    }

	    var filter_model = $("select[name=\"filter_model\"]").val();

		if (filter_model!="0") {
		url += "&filter_model=" + encodeURIComponent(filter_model);
		}'.' location = url;';
		$output = str_replace( $find, $replace, $template_buffer );

		}
	}

	 protected function getTemplateBuffer($route, $event_template_buffer) {
        // if there already is a modified template from view/*/before events use that one
        if ($event_template_buffer) {
            return $event_template_buffer;
        }

        // load the template file (possibly modified by ocmod and vqmod) into a string buffer

        if ($this->config->get('config_theme') == 'default') {
            $theme = $this->config->get('theme_default_directory');
        } else {
            $theme = $this->config->get('config_theme');
        }
        $dir_template = DIR_TEMPLATE;

        $template_file = $dir_template.$route.'.twig';
        if (file_exists($template_file) && is_file($template_file)) {

            return file_get_contents($template_file);
        }
        
        $dir_template  = DIR_TEMPLATE.'default/template/';
        $template_file = $dir_template.$route.'.twig';
        if (file_exists($template_file) && is_file($template_file)) {

            return file_get_contents($template_file);
        }
        trigger_error("Cannot find template file for route '$route'");
        exit;
    }

}
