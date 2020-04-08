<?php


class MOF_Plugin {

	static $instance;


	public function __construct() {
		add_filter('set-screen-option', [__CLASS__, 'set_screen'], 10, 3);
		add_action('admin_menu', [$this, 'plugin_menu']);
	}


	public static function set_screen($status, $option, $value) {
		return $value;
	}


	public function plugin_menu() {
		$hook = add_menu_page('Materials Orders', 'Materials Orders', 'manage_options', 'mof', [$this, 'orders']);


		add_submenu_page(null, 'Export Materials Orders', 'Export Materials Orders', 'manage_options', 'mof_orders_export', [$this, 'orders_export']);
		add_submenu_page('mof', 'Items Catalogue', 'Items Catalogue', 'manage_options', 'mof_items', [$this, 'items_catalogue']);
		add_submenu_page('mof', 'New Catalogue Item', 'New Catalogue Item', 'manage_options', 'mof_items_create', [$this, 'item_catalogue_create']);
		add_submenu_page('mof', 'Blacklisted Postcodes', 'Blacklisted Postcodes', 'manage_options', 'mof_postcodes', [$this, 'postcodes_blacklist']);


		add_action("load-$hook", [$this, 'screen_option']);
	}


	/**
	 * Material orders
	 */
	public function orders()
	{
		if (!empty($_GET['order_id']))
		{
			require(MOF_TEMPLATE_DIR . 'orders/_show.php');

		} else {
			require(MOF_TEMPLATE_DIR . 'orders/_list.php');
		}
	}


	/**
	 * Items catalogue
	 */
	public function items_catalogue()
	{
		if (!empty($_GET['item_id']))
		{
			require(MOF_TEMPLATE_DIR . 'items/_edit.php');

		} else {
			require(MOF_TEMPLATE_DIR . 'items/_list.php');
		}
	}


	/**
	 * Items catalogue create
	 */
	public function item_catalogue_create()
	{
		require(MOF_TEMPLATE_DIR . 'items/_create.php');
	}


	/**
	 * Postcodes Blacklist
	 */
	public function postcodes_blacklist()
	{
		require(MOF_TEMPLATE_DIR . 'postcodes/_edit.php');
	}


	/**
	 * Screen options
	 */
	public function screen_option()
	{
		$option = 'per_page';
		$args   = [
			'label' => 'Materials Orders',
			'default' => 20,
			'option' => 'orders_per_page'
		];


		add_screen_option($option, $args);


		$this->orders_obj = new Orders_List();
	}


	public static function get_instance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}


		return self::$instance;
	}


	public static function form_validation($post)
	{
		global $wpdb;


		$valid = true;
		$check_data_items = $check_data_items_titles = [];


		// Loop through absolutely every dropdown and check the key and value are within the correct tolerances
		// If not throw the user out to an error page


		if (isset($post['quantity'])) {
			if ((int) $post['quantity'] < 1 || (int) $post['quantity'] > 5) {
				// echo 'Failed because quantity is less than 1 or greater than 5';
				$valid = false;
			}
		}


		if (isset($post['size']))
		{
			$check_tshirt_sizes = ['Adult T-Shirt - L', 'Adult T-Shirt - M', 'Adult T-Shirt - S', 'Adult T-Shirt - XL'];


			foreach ($post['size'] as $size)
			{
				if (!in_array($size, $check_tshirt_sizes)) {
					// echo 'Failed because no match for T-shirt title';
					$valid = false;
				}
			}
		}


		// Fundraising materials
		$section = 'Fundraising Materials';
		$categories = ['General materials', 'Booklets and leaflets'];


		foreach ($categories as $category) {
			$category_form_handle = str_replace(' ', '_', strtolower(stripslashes($category)));
			// var_dump($category_form_handle);


			if (isset($post[$category_form_handle])) {
				$sql = "SELECT * FROM {$wpdb->prefix}" . MOF_TABLE_NAME . "_items WHERE section = '" . $section . "' AND category = '" . $category . "' ORDER BY id";
				$data_items = $wpdb->get_results($sql);


				foreach ($data_items as $data_item) {
					$data_item = (array) $data_item;
					$data_item['restrictions'] = unserialize($data_item['restrictions']);


					$check_data_items[] = (array) $data_item;
				}


				foreach ($check_data_items as $check_key => $check_item) {
					$check_data_items_titles[$check_key] = stripslashes($check_item['title']);
				}


				foreach ($post[$category_form_handle] as $title => $value) {
					if (!in_array(stripslashes($title), $check_data_items_titles)) {
						// echo 'Failed because title is set to "' . $title . '" which no match anything in the titles array.<br />';
						$valid = false;

					} else {
						$key = array_search(stripslashes($title), $check_data_items_titles);


						if ((int) $value < 1 || (int) $value > $check_data_items[$key]['restrictions'][$post['money-raised']]) {
							// echo 'Failed because "' . $title . '" is set to ' . $value . ' should be ' . $check_data_items[$key]['restrictions'][$post['money-raised']] . '.<br />';
							$valid = false;
						}
					}
				}
			}
		}


		// Information for dementia
		$section = 'Dementia Information';
		$categories = ['A4 booklets', 'Other booklets and leaflets (A5 and smaller)', 'Booklets in other languages', 'A3 Posters', 'Flyers'];


		foreach ($categories as $category) {
			$category_form_handle = str_replace(' ', '_', strtolower(stripslashes($category)));
			// var_dump($category_form_handle);


			if (isset($post[$category_form_handle])) {
				$sql = "SELECT * FROM {$wpdb->prefix}" . MOF_TABLE_NAME . "_items WHERE section = '" . $section . "' AND category = '" . $category . "' ORDER BY id";
				$data_items = $wpdb->get_results($sql);


				foreach ($data_items as $data_item) {
					$check_data_items[] = (array) $data_item;
				}


				foreach ($check_data_items as $check_key => $check_item) {
					$check_data_items_titles[$check_key] = stripslashes($check_item['title']);
				}


				foreach ($post[$category_form_handle] as $title => $value) {
					if (!in_array(stripslashes($title), $check_data_items_titles)) {
						// echo 'Failed because title is set to "' . $title . '" which no match anything in the titles array.<br />';
						$valid = false;

					} else {
						if ((int) $value < 1 || (int) $value > 50) {
							// echo 'Failed because quantity is less than 1 or greater than 50';
							$valid = false;
						}
					}
				}
			}
		}


		return $valid;
	}


	public static function form_details($post)
	{
		$data = [];


		foreach ($post as $key => $value)
		{
			if (!is_array($value)) { $value = sanitize_text_field($value); }


			$post[$key] = $value;
		}


		$data['name'] = $post['title'] . ' ' . $post['first_name'] . ' ' . $post['last_name'];
		$data['dob'] = $post['dob_day'] . '/' . $post['dob_month'] . '/' . $post['dob_year'];


		$data['contact_number'] = $post['contact_number'];
		$data['email'] = $post['email'];


		$data['address'] = $post['address1'] . "\r\n";
		if (isset($post['address2'])) { $data['address'] .= $post['address2'] . "\r\n"; }
		$data['address'] .= $post['town'] . "\r\n";
		$data['address'] .= $post['postcode'];


		$data['parkrunner'] = (isset($post['parkrunner'])) ? $post['parkrunner'] : null;
		$data['press_team'] = (isset($post['press_awareness'])) ? $post['press_awareness'] : null;


		if (isset($post['additional-items'])) { $data['additional_items'] = 'Additional items requested.' . "\r\n"; }


		if (isset($post['permissions'])) {
			$data['permissions'] = null;


			foreach ($post['permissions'] as $optin => $value) {
				if ($optin == 'post' || $optin == 'phone') {
					$data['permissions'] .= 'Do not contact via ' . $optin . "\r\n";

				} else {
					$data['permissions'] .= 'Can be contacted via ' . $optin . "\r\n";
				}
			}
		}


		$data['order_info'] = self::order_details($post);
		$data['export'] = self::export_data($post);


		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_at'] = $data['created_at'];


		return $data;
	}


	public static function order_details($post)
	{
		if ($post['materials-required'] == 'Cheer Squad pack') {
			$order_info = $post['quantity'] . ' x ' . $post['materials-required'] . "\r\n";


			foreach ($post['size'] as $size) {
				$order_info .= "\r\n" . '1 x ' . $size;
			}

		} else if ($post['materials-required'] == 'Fundraising materials') {
			$order_info = $post['materials-required'];
			$order_info .= "\r\n\r\n" . 'What type of event are you planning?' . "\r\n" . $post['event-planned'];
			if (isset($post['event-planned-other'])) { $order_info .= ': ' . $post['event-planned-other']; }
			$order_info .= "\r\n\r\n" . 'When will your event start?' . "\r\n" . $post['date-start'];
			$order_info .= "\r\n\r\n" . 'When will your event finish?' . "\r\n" . $post['date-finish'];
			$order_info .= "\r\n\r\n" . 'How much do you expect to raise?' . "\r\n" . '£' . $post['money-raised'];
			if (isset($post['money-raised-other'])) { $order_info .= ': ' . $post['money-raised-other']; }
			$order_info .=  "\r\n\r\n";


			if (isset($post['general_materials'])) {
				foreach ($post['general_materials'] as $title => $quantity) {
					$order_info .= "\r\n" . 'General materials: ' . $title . ' x ' . $quantity;
				}
			}


			if (isset($post['booklets_and_leaflets'])) {
				foreach ($post['booklets_and_leaflets'] as $title => $quantity) {
					$order_info .= "\r\n" . 'Booklets and leaflets: ' . $title . ' x ' . $quantity;
				}
			}

		} else if ($post['materials-required'] == 'Information about dementia') {
			$order_info = $post['materials-required'];
			$order_info .= "\r\n\r\n" . 'Are you ordering these materials on behalf of an organisation? ' . ucfirst($post['on-behalf-of-organisation']) . "\r\n";
			if ($post['on-behalf-of-organisation-type']) { $order_info .= 'Organisation type: ' . $post['on-behalf-of-organisation-type']; }
			if ($post['on-behalf-of-organisation-type-other']) { $order_info .= ': ' . $post['on-behalf-of-organisation-type-other']; }
			$order_info .=  "\r\n\r\n";


			if (isset($post['a4_booklets'])) {
				foreach ($post['a4_booklets'] as $title => $quantity) {
					$order_info .= "\r\n" . 'A4 booklets: ' . $title . ' x ' . $quantity;
				}
			}


			if (isset($post['other_booklets_and_leaflets_(a5_and_smaller)'])) {
				foreach ($post['other_booklets_and_leaflets_(a5_and_smaller)'] as $title => $quantity) {
					$order_info .= "\r\n" . 'Other booklets and leaflets (A5 and smaller): ' . $title . ' x ' . $quantity;
				}
			}

			if (isset($post['booklets_in_other_languages'])) {
				foreach ($post['booklets_in_other_languages'] as $title => $quantity) {
					$order_info .= "\r\n" . 'Booklets in other languages: ' . $title . ' x ' . $quantity;
				}
			}

			if (isset($post['flyers'])) {
				foreach ($post['flyers'] as $title => $quantity) {
					$order_info .= "\r\n" . 'Flyers: ' . $title . ' x ' . $quantity;
				}
			}

			if (isset($post['a3_posters'])) {
				foreach ($post['a3_posters'] as $title => $quantity) {
					$order_info .= "\r\n" . 'A3 Posters: ' . $title . ' x ' . $quantity;
				}
			}

			if (isset($post['childrens_books'])) {
				foreach ($post['childrens_books'] as $title => $quantity) {
					$order_info .= "\r\n" . 'Children\'s Books: ' . $title . ' x ' . $quantity;
				}
			}

		} else {
			$order_info = '1 x ' . $post['materials-required'];
		}


		return $order_info;
	}


	public static function export_data($post)
	{
		$export = [];


		$export['details']['title'] = $post['title'];
		$export['details']['first_name'] = $post['first_name'];
		$export['details']['last_name'] = $post['last_name'];
		$export['details']['dob'] = $post['dob_day'] . '/' . $post['dob_month'] . '/' . $post['dob_year'];
		$export['details']['gender'] = (isset($post['gender'])) ? ucfirst($post['gender']) : null;
		$export['details']['gender_other'] = (isset($post['gender_other'])) ? $post['gender_other'] : null;


		$export['details']['contact_number'] = $post['contact_number'];
		$export['details']['email'] = $post['email'];


		$export['details']['address1'] = $post['address1'];
		$export['details']['address2'] = $post['address2'];
		$export['details']['town'] = $post['town'];
		$export['details']['postcode'] = $post['postcode'];


		$export['details']['parkrunner'] = (isset($post['parkrunner'])) ? ucfirst($post['parkrunner']) : null;
		$export['details']['parkrunner_id'] = (isset($post['parkrun_id'])) ? $post['parkrun_id'] : null;
		$export['details']['press_team'] = (isset($post['press_awareness'])) ? ucfirst($post['press_awareness']) : null;


		$export['details']['updates_post'] = (isset($post['permissions']['post'])) ? 'No' : '-';
		$export['details']['updates_phone'] = (isset($post['permissions']['phone'])) ? 'No' : '-';
		$export['details']['updates_email'] = (isset($post['permissions']['email'])) ? ucfirst($post['permissions']['email']) : '-';
		$export['details']['updates_sms'] = (isset($post['permissions']['SMS'])) ? ucfirst($post['permissions']['SMS']) : '-';


		$export['details']['order_type'] = $post['materials-required'];


		$export['details']['event-planned'] = (isset($post['event-planned'])) ? $post['event-planned'] : '';
		$export['details']['event-planned-other'] = (isset($post['event-planned-other'])) ? $post['event-planned-other'] : '';
		$export['details']['date-start'] = (isset($post['date-start'])) ? $post['date-start'] : '';
		$export['details']['date-finish'] = (isset($post['date-finish'])) ? $post['date-finish'] : '';


		if ($post['materials-required'] == 'Fundraising materials') {
			$export['details']['money-raised'] = ($post['money-raised-other']) ? $post['money-raised-other'] : explode('-', $post['money-raised'])[1];

		} else {
			$export['details']['money-raised'] = '';
		}


		$export['details']['additional-items'] = (isset($post['additional-items'])) ? ucfirst($post['additional-items']) : '';


		$export['details']['on-behalf-of-organisation'] = (isset($post['on-behalf-of-organisation'])) ? ucfirst($post['on-behalf-of-organisation']) : '';
		$export['details']['on-behalf-of-organisation-type'] = (isset($post['on-behalf-of-organisation-type'])) ? $post['on-behalf-of-organisation-type'] : '';
		$export['details']['on-behalf-of-organisation-type-other'] = (isset($post['on-behalf-of-organisation-type-other'])) ? $post['on-behalf-of-organisation-type-other'] : '';


		$export['details']['permission_granted'] = (isset($post['permission_granted'])) ? $post['permission_granted'] : null;
		$export['details']['heard_about'] = (isset($post['heard_about'])) ? $post['heard_about'] : null;
		$export['details']['heard_about_other'] = (isset($post['heard_about_other'])) ? $post['heard_about_other'] : null;


		if (isset($post['size'])) {
			foreach ($post['size'] as $size) {
				$export['items'][] = ['title' => $size, 'quantity' => 1];
			}
		}


		if (isset($post['general_materials'])) {
			foreach ($post['general_materials'] as $title => $quantity) {
				$export['items'][] = ['title' => 'General materials: ' . $title, 'quantity' => $quantity];
			}
		}


		if (isset($post['booklets_and_leaflets'])) {
			foreach ($post['booklets_and_leaflets'] as $title => $quantity) {
				$export['items'][] = ['title' => 'Booklets and leaflets: ' . $title, 'quantity' => $quantity];
			}
		}


		if (isset($post['a4_booklets'])) {
			foreach ($post['a4_booklets'] as $title => $quantity) {
				$export['items'][] = ['title' => 'A4 booklets: ' . $title, 'quantity' => $quantity];
			}
		}


		if (isset($post['other_booklets_and_leaflets_(a5_and_smaller)'])) {
			foreach ($post['other_booklets_and_leaflets_(a5_and_smaller)'] as $title => $quantity) {
				$export['items'][] = ['title' => 'Other booklets and leaflets (A5 and smaller): ' . $title, 'quantity' => $quantity];
			}
		}


		if (isset($post['booklets_in_other_languages'])) {
			foreach ($post['booklets_in_other_languages'] as $title => $quantity) {
				$export['items'][] = ['title' => 'Booklets in other languages: ' . $title, 'quantity' => $quantity];
			}
		}


		if (isset($post['flyers'])) {
			foreach ($post['flyers'] as $title => $quantity) {
				$export['items'][] = ['title' => 'Flyers: ' . $title, 'quantity' => $quantity];
			}
		}


		if (isset($post['a3_posters'])) {
			foreach ($post['a3_posters'] as $title => $quantity) {
				$export['items'][] = ['title' => 'A3 Posters: ' . $title, 'quantity' => $quantity];
			}
		}

		
		if (isset($post['childrens_books'])) {
			foreach ($post['childrens_books'] as $title => $quantity) {
				$export['items'][] = ['title' => 'Children\\\'s Books: ' . $title, 'quantity' => $quantity];
			}
		}


		return serialize($export);
	}
}