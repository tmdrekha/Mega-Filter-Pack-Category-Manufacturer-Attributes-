<?php
namespace Opencart\Catalog\Model\Extension\Megafilterpack\Tmd;
use \Opencart\System\Helper as Helper;
class Cmaattribute extends \Opencart\System\Engine\Model {


	public function addAttribute($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute SET attribute_group_id = '" . (int)$data['attribute_group_id'] . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$attribute_id = $this->db->getLastId();

		foreach ($data['attribute_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		return $attribute_id;
	}

	public function editAttribute($attribute_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "attribute SET attribute_group_id = '" . (int)$data['attribute_group_id'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE attribute_id = '" . (int)$attribute_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'");

		foreach ($data['attribute_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
	}

	public function deleteAttribute($attribute_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute WHERE attribute_id = '" . (int)$attribute_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'");
	}

	public function getAttribute($attribute_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE a.attribute_id = '" . (int)$attribute_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getAttributes($data = array()) {
		$sql = "SELECT *, (SELECT agd.name FROM " . DB_PREFIX . "attribute_group_description agd WHERE agd.attribute_group_id = a.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute_group FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_attribute_group_id'])) {
			$sql .= " AND a.attribute_group_id = '" . $this->db->escape($data['filter_attribute_group_id']) . "'";
		}

		$sort_data = array(
			'ad.name',
			'attribute_group',
			'a.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY attribute_group, ad.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getAttributeDescriptions($attribute_id) {
		$attribute_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'");

		foreach ($query->rows as $result) {
			$attribute_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $attribute_data;
	}

	public function getTotalAttributes() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attribute");

		return $query->row['total'];
	}

	public function getTotalAttributesByAttributeGroupId($attribute_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attribute WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");

		return $query->row['total'];
	}

	// new code

	public function getProducts(array $data = []): array {
    $sql = "SELECT p.`product_id`, 
        (SELECT AVG(`rating`) AS `total` FROM `" . DB_PREFIX . "review` r1 WHERE r1.`product_id` = p.`product_id` AND r1.`status` = '1' GROUP BY r1.`product_id`) AS `rating`, 
        (SELECT `price` FROM `" . DB_PREFIX . "product_discount` pd2 WHERE pd2.`product_id` = p.`product_id` AND pd2.`customer_group_id` = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.`quantity` = '1' AND ((pd2.`date_start` = '0000-00-00' OR pd2.`date_start` < NOW()) AND (pd2.`date_end` = '0000-00-00' OR pd2.`date_end` > NOW())) ORDER BY pd2.`priority` ASC, pd2.`price` ASC LIMIT 1) AS `discount`";

    if (!empty($data['filter_category_id'])) {
        if (!empty($data['filter_sub_category'])) {
            $sql .= " FROM `" . DB_PREFIX . "category_path` cp LEFT JOIN `" . DB_PREFIX . "product_to_category` p2c ON (cp.`category_id` = p2c.`category_id`)";
        } else {
            $sql .= " FROM `" . DB_PREFIX . "product_to_category` p2c";
        }

        if (!empty($data['filter_filter'])) {
            $sql .= " LEFT JOIN `" . DB_PREFIX . "product_filter` pf ON (p2c.`product_id` = pf.`product_id`) LEFT JOIN `" . DB_PREFIX . "product` p ON (pf.`product_id` = p.`product_id`)";
        } else {
            $sql .= " LEFT JOIN `" . DB_PREFIX . "product` p ON (p2c.`product_id` = p.`product_id`)";
        }
    } else {
        $sql .= " FROM `" . DB_PREFIX . "product` p";
    }
    // CMA Filter

    if (!empty($data['filter_first_level'])) {
        if (!empty($data['filter_second_level'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c2 ON (p2c2.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "category_path cpf ON (cpf.category_id = p2c2.category_id)";
        } else if (!empty($data['filter_third_level'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c2 ON (p2c2.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "category_path cpf ON (cpf.category_id = p2c2.category_id)";
        } else {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c2 ON (p2c2.product_id = p.product_id)";
        }
    }

    if (!empty($data['filter_model'])) {
        $sql .= " LEFT JOIN " . DB_PREFIX . "product_attribute pa on (p.product_id = pa.product_id)";
    }
    // CMA Filter

    $sql .= " LEFT JOIN `" . DB_PREFIX . "product_description` pd ON (p.`product_id` = pd.`product_id`) LEFT JOIN `" . DB_PREFIX . "product_to_store` p2s ON (p.`product_id` = p2s.`product_id`) WHERE pd.`language_id` = '" . (int)$this->config->get('config_language_id') . "' AND p.`status` = '1' AND p.`date_available` <= NOW() AND p2s.`store_id` = '" . (int)$this->config->get('config_store_id') . "'";

    // CMA Filter
    if (!empty($data['filter_first_level'])) {
        if (!empty($data['filter_second_level'])) {
            $sql .= " AND cpf.path_id = '" . (int)$data['filter_second_level'] . "'";
        } else if (!empty($data['filter_third_level'])) {
            $sql .= " AND cpf.path_id = '" . (int)$data['filter_third_level'] . "'";
        } else {
            $sql .= " AND p2c2.category_id = '" . (int)$data['filter_first_level'] . "'";
        }
    }

    if (!empty($data['filter_brand'])) {
        $sql .= " AND p.manufacturer_id = '" . (int)$data['filter_brand'] . "'";
    }

    if (!empty($data['filter_model'])) {
        $sql .= " AND pa.attribute_id = '" . (int)$data['filter_model'] . "'";
    }

    if (!empty($data['filter_search'])) {
        $sql .= " AND pd.name LIKE '%" . $this->db->escape($data['filter_search']) . "%'";
    }

    if (!empty($data['filter_price_from'])) {
        $sql .= " AND p.price >= '" . $data['filter_price_from'] . "'";
    }

    if (!empty($data['filter_price_to'])) {
        $sql .= " AND p.price <= '" . $data['filter_price_to'] . "'";
    }
    // CMA Filter

    if (!empty($data['filter_category_id'])) {
        if (!empty($data['filter_sub_category'])) {
            $sql .= " AND cp.`path_id` = '" . (int)$data['filter_category_id'] . "'";
        } else {
            $sql .= " AND p2c.`category_id` = '" . (int)$data['filter_category_id'] . "'";
        }

        if (!empty($data['filter_filter'])) {
            $implode = [];

            $filters = explode(',', $data['filter_filter']);

            foreach ($filters as $filter_id) {
                $implode[] = (int)$filter_id;
            }

            $sql .= " AND pf.`filter_id` IN (" . implode(',', $implode) . ")";
        }
    }

    if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
        $sql .= " AND (";

        if (!empty($data['filter_name'])) {
            $implode = [];

            $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

            foreach ($words as $word) {
                $implode[] = "pd.`name` LIKE '" . $this->db->escape('%' . $word . '%') . "'";
            }

            if ($implode) {
                $sql .= " " . implode(" AND ", $implode) . "";
            }

            if (!empty($data['filter_description'])) {
                $sql .= " OR pd.`description` LIKE '" . $this->db->escape('%' . (string)$data['filter_name'] . '%') . "'";
            }
        }

        if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
            $sql .= " OR ";
        }

        if (!empty($data['filter_tag'])) {
            $implode = [];

            $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

            foreach ($words as $word) {
                $implode[] = "pd.`tag` LIKE '" . $this->db->escape('%' . $word . '%') . "'";
            }

            if ($implode) {
                $sql .= " " . implode(" AND ", $implode) . "";
            }
        }

        if (!empty($data['filter_name'])) {
            if (VERSION >= '4.0.2.0') {
                $sql .= " OR LCASE(p.`model`) = '" . $this->db->escape(oc_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.`sku`) = '" . $this->db->escape(oc_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.`upc`) = '" . $this->db->escape(oc_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.`ean`) = '" . $this->db->escape(oc_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.`jan`) = '" . $this->db->escape(oc_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.`isbn`) = '" . $this->db->escape(oc_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.`mpn`) = '" . $this->db->escape(oc_strtolower($data['filter_name'])) . "'";
            } else {
                $sql .= " OR LCASE(p.`model`) = '" . $this->db->escape(Helper\Utf8\strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.`sku`) = '" . $this->db->escape(Helper\Utf8\strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.`upc`) = '" . $this->db->escape(Helper\Utf8\strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.`ean`) = '" . $this->db->escape(Helper\Utf8\strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.`jan`) = '" . $this->db->escape(Helper\Utf8\strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.`isbn`) = '" . $this->db->escape(Helper\Utf8\strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.`mpn`) = '" . $this->db->escape(Helper\Utf8\strtolower($data['filter_name'])) . "'";
            }
        }

        $sql .= ")";
    }

    if (!empty($data['filter_manufacturer_id'])) {
        $sql .= " AND p.`manufacturer_id` = '" . (int)$data['filter_manufacturer_id'] . "'";
    }

    $sql .= " GROUP BY p.product_id";

    $sort_data = [
        'pd.name',
        'p.model',
        'p.quantity',
        'p.price',
        'rating',
        'p.sort_order',
        'p.date_added'
    ];

    if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
        if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
            $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
        } elseif ($data['sort'] == 'p.price') {
            // Removed special from this CASE statement
            $sql .= " ORDER BY (CASE WHEN discount IS NOT NULL THEN discount ELSE p.`price` END)";
        } else {
            $sql .= " ORDER BY " . $data['sort'];
        }
    } else {
        $sql .= " ORDER BY p.`sort_order`";
    }

    if (isset($data['order']) && ($data['order'] == 'DESC')) {
        $sql .= " DESC, LCASE(pd.`name`) DESC";
    } else {
        $sql .= " ASC, LCASE(pd.`name`) ASC";
    }

    if (isset($data['start']) || isset($data['limit'])) {
        if ($data['start'] < 0) {
            $data['start'] = 0;
        }

        if ($data['limit'] < 1) {
            $data['limit'] = 20;
        }

        $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
    }

    $product_data = [];

    $query = $this->db->query($sql);

    foreach ($query->rows as $result) {
        // for never get one more time with same product id
        if (!isset($product_data[$result['product_id']])) {
            $product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
        }
    }

    return $product_data;
}


	public function getTotalProducts(array $data = []): int {
		$sql = "SELECT COUNT(DISTINCT p.`product_id`) AS total";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM `" . DB_PREFIX . "category_path` cp LEFT JOIN `" . DB_PREFIX . "product_to_category` p2c ON (cp.`category_id` = p2c.`category_id`)";
			} else {
				$sql .= " FROM `" . DB_PREFIX . "product_to_category` p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN `" . DB_PREFIX . "product_filter` pf ON (p2c.`product_id` = pf.`product_id`) LEFT JOIN `" . DB_PREFIX . "product` p ON (pf.`product_id` = p.`product_id`)";
			} else {
				$sql .= " LEFT JOIN `" . DB_PREFIX . "product` p ON (p2c.`product_id` = p.`product_id`)";
			}
		} else {
			$sql .= " FROM `" . DB_PREFIX . "product` p";
		}

		// CMA Filter
		if (!empty($data['filter_first_level'])) {
			if (!empty($data['filter_second_level'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c2 ON (p2c2.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "category_path cpf ON (cpf.category_id = p2c2.category_id)";
			} else if (!empty($data['filter_third_level'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c2 ON (p2c2.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "category_path cpf ON (cpf.category_id = p2c2.category_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c2 ON (p2c2.product_id = p.product_id)";
			}
		}
		
		if (!empty($data['filter_model'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_attribute pa on (p.product_id = pa.product_id)";
		}
		// CMA Filter

		$sql .= " LEFT JOIN `" . DB_PREFIX . "product_description` pd ON (p.`product_id` = pd.`product_id`) LEFT JOIN `" . DB_PREFIX . "product_to_store` p2s ON (p.`product_id` = p2s.`product_id`) WHERE pd.`language_id` = '" . (int)$this->config->get('config_language_id') . "' AND p.`status` = '1' AND p.`date_available` <= NOW() AND p2s.`store_id` = '" . (int)$this->config->get('config_store_id') . "'";

		// CMA Filter
		if (!empty($data['filter_first_level'])) {
			if (!empty($data['filter_second_level'])) {
				$sql .= " AND cpf.path_id = '" . (int)$data['filter_second_level'] . "'";
			} else if (!empty($data['filter_third_level'])) {
				$sql .= " AND cpf.path_id = '" . (int)$data['filter_third_level'] . "'";
			} else {
				$sql .= " AND p2c2.category_id = '" . (int)$data['filter_first_level'] . "'";
			}
		}
		
		if (!empty($data['filter_brand'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_brand'] . "'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND pa.attribute_id = '" . (int)$data['filter_model'] . "'";
		}

		if (!empty($data['filter_search'])) {
			$sql .= " AND pd.name LIKE '%" . $this->db->escape($data['filter_search']) . "%'";
		}

		if (!empty($data['filter_price_from'])) {
			$sql .= " AND p.price >= '" . $data['filter_price_from'] . "'";
		}

		if (!empty($data['filter_price_to'])) {
			$sql .= " AND p.price <= '" . $data['filter_price_to'] . "'";
		}
		// CMA Filter

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.`path_id` = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.`category_id` = '" . (int)$data['filter_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = [];

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.`filter_id` IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = [];

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.`name` LIKE '" . $this->db->escape('%' . $word . '%') . "'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.`description` LIKE '" . $this->db->escape('%' . (string)$data['filter_name'] . '%') . "'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$implode = [];

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

				foreach ($words as $word) {
					$implode[] = "pd.`tag` LIKE '" . $this->db->escape('%' . $word . '%') . "'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}
			}

			if (!empty($data['filter_name'])) {

      if(VERSION>='4.0.2.0'){

				$sql .= " OR LCASE(p.`model`) = '" . $this->db->escape(oc_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.`sku`) = '" . $this->db->escape(oc_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.`upc`) = '" . $this->db->escape(oc_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.`ean`) = '" . $this->db->escape(oc_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.`jan`) = '" . $this->db->escape(oc_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.`isbn`) = '" . $this->db->escape(oc_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.`mpn`) = '" . $this->db->escape(oc_strtolower($data['filter_name'])) . "'";
			}else{

				$sql .= " OR LCASE(p.`model`) = '" . $this->db->escape(Helper\Utf8\strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.`sku`) = '" . $this->db->escape(Helper\Utf8\strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.`upc`) = '" . $this->db->escape(Helper\Utf8\strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.`ean`) = '" . $this->db->escape(Helper\Utf8\strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.`jan`) = '" . $this->db->escape(Helper\Utf8\strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.`isbn`) = '" . $this->db->escape(Helper\Utf8\strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.`mpn`) = '" . $this->db->escape(Helper\Utf8\strtolower($data['filter_name'])) . "'";
			}
			}

			$sql .= ")";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.`manufacturer_id` = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$query = $this->db->query($sql);

		return (int)$query->row['total'];
	}



}
