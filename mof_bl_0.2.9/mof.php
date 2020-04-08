<?php
/*
 * Plugin Name: Materials Order Form
 * Plugin URI: http://www.rallyagency.co.uk
 * Version: 0.2.9
 * Author: Chris Southam (chris@rallyagency.co.uk) / Updated by BoldLight
 * Description: Alzheimer's Research Materials Order Form
*/


define('MOF_VERSION', '0.2.9');
define('MOF_BASE_NAME', plugin_basename(__FILE__));
define('MOF_TABLE_NAME', 'mof');
define('MOF_BASE_DIR_SHORT', dirname(MOF_BASE_NAME));
define('MOF_BASE_DIR_LONG', dirname(__FILE__));
define('MOF_DATA_DIR', MOF_BASE_DIR_LONG . '/data/');
define('MOF_TEMPLATE_DIR', MOF_BASE_DIR_LONG . '/templates/');
define('MOF_BASE_URL', plugin_dir_url(__FILE__));
define('MOF_CSS_URL', MOF_BASE_URL . 'css/');
define('MOF_DOWNLOADS_URL', MOF_BASE_URL . 'downloads/');
define('MOF_IMG_URL', MOF_BASE_URL . 'images/');
define('MOF_JS_URL', MOF_BASE_URL . 'js/');


//register_activation_hook(__FILE__, 'mof_create_table');
//register_activation_hook(__FILE__, 'mof_items_create_table');
//register_activation_hook(__FILE__, 'mof_postcodes_create_table');


function mof_create_table()
{
	global $wpdb;


	$table_name = $wpdb->prefix . MOF_TABLE_NAME;


	$sql = 'CREATE TABLE ' . $table_name . ' (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `dob` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `gender` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `contact_number` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `address` text COLLATE utf8_unicode_ci,
	  `parkrunner` char(3) COLLATE utf8_unicode_ci DEFAULT \'no\',
	  `parkrunner_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `press_team` char(3) COLLATE utf8_unicode_ci DEFAULT \'no\',
	  `additional_items` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `updates` text COLLATE utf8_unicode_ci,
	  `permissions` text COLLATE utf8_unicode_ci,
	  `order_info` text COLLATE utf8_unicode_ci,
	  `export` text COLLATE utf8_unicode_ci,
	  `status` varchar(32) COLLATE utf8_unicode_ci DEFAULT \'pending\',
	  `created_at` datetime NOT NULL,
	  `updated_at` datetime NOT NULL,
      UNIQUE KEY id (id)
   );';


	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


	dbDelta($sql);
}


function mof_items_create_table()
{
	global $wpdb;


	$table_name = $wpdb->prefix . MOF_TABLE_NAME . '_items';

	//-- if doesn't exist ? --//
	$sql = 'CREATE TABLE ' . $table_name . ' (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `section` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `summary` text COLLATE utf8_unicode_ci,
	  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `donation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `restrictions` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `created_at` datetime NOT NULL,
	  `updated_at` datetime NOT NULL,
      UNIQUE KEY id (id)
    );';


	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


	dbDelta($sql);


	$import = [];


	require_once('import/dementia-info.php');


	foreach ($import['dementia-info'] as $category)
	{
		foreach ($category['items'] as $item)
		{
			$data = $item;
			$data['section'] = 'Dementia Information';
			$data['category'] = $category['title'];


			$data['title'] = addslashes($data['title']);
			$data['summary'] = addslashes($data['summary']);


			$data['created_at'] = date('Y-m-d H:i:s');
			$data['updated_at'] = $data['created_at'];


			$wpdb->insert($table_name, $data, '%s');
		}
	}


	require_once('import/fundraising-materials.php');


	foreach ($import['fundraising-materials'] as $category)
	{
		foreach ($category['items'] as $item)
		{
			$data = $item;
			$data['section'] = 'Fundraising Materials';
			$data['category'] = $category['title'];


			$data['title'] = addslashes($data['title']);
			$data['summary'] = addslashes($data['summary']);


			$data['donation'] = serialize($data['donation']);
			$data['restrictions'] = serialize($data['restrictions']);


			$data['created_at'] = date('Y-m-d H:i:s');
			$data['updated_at'] = $data['created_at'];


			$wpdb->insert($table_name, $data, '%s');
		}
	}
}


function mof_postcodes_create_table()
{
	global $wpdb;


	$table_name = $wpdb->prefix . MOF_TABLE_NAME . '_postcodes';


	$sql = 'CREATE TABLE ' . $table_name . ' (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `postcodes` text COLLATE utf8_unicode_ci,
	  `created_at` datetime NOT NULL,
	  `updated_at` datetime NOT NULL,
      UNIQUE KEY id (id)
	)';


	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


	dbDelta($sql);


	$data = ['id' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];


	$wpdb->insert($table_name, $data, '%s');
}


if (!class_exists('WP_List_Table')) {
	require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}


require_once('classes/orders.php');
require_once('classes/items.php');
require_once('classes/postcodes.php');


require_once('classes/mof.php');


add_action('plugins_loaded', function () {
	MOF_Plugin::get_instance();
});


add_action('admin_post_mof_orders_export', 'mof_orders_export');


function mb_unserialize($string) {
	$reserialize_string = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m)
	{
		$len = strlen($m[2]);
		$result = "s:$len:\"{$m[2]}\";";


		return $result;
	}, $string);


	return unserialize($reserialize_string);
}


function mof_orders_export() {
	global $wpdb;


	if (!empty($_REQUEST['start_date'])) {
		$start_date = implode('-', array_reverse(explode('/', $_REQUEST['start_date'])));
	}


	if (!empty($_REQUEST['end_date'])) {
		$end_date = implode('-', array_reverse(explode('/', $_REQUEST['end_date'])));
	}


	$sql = "SELECT id, export, created_at, updated_at FROM {$wpdb->prefix}" . MOF_TABLE_NAME;


	if (isset($start_date) && isset($end_date)) {
		$sql .= ' WHERE created_at BETWEEN "' . $start_date . ' 00:00:00" AND "' . $end_date . ' 23:59:59"';

	} elseif (isset($start_date)) {
		$sql .= ' WHERE created_at >= "' . $start_date . '"';

	} elseif (isset($end_date)) {
		$sql .= ' WHERE created_at <= "' . $end_date . '"';
	}


	if (!empty($_REQUEST['orderby'])) {
		$sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
		$sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';

	} else {
		$sql .= ' ORDER BY created_at DESC';
	}


	header("Content-Type: text/csv; charset=utf-8");
	header("Content-Disposition: attachment; filename=orders_export.csv");
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Pragma: no-cache");
	header("Expires: 0");


	$title_row = ['Order ID', 'Date', 'Time', 'Title', 'First name', 'Surname', 'Date of Birth', 'Gender', 'Gender (Other)', 'Contact Number', 'Email', 'Address line 1', 'Address line 2', 'Town', 'Postcode', 'Are you a parkrunner', 'parkrun ID', 'Press team', 'Information by post', 'Information by phone', 'Updates by email', 'Updates by SMS', 'Order type', 'What type of event are you planning?', 'Other: please specify', 'When will your event start?', 'When will your event finish?', 'How much do you expect to raise?', 'I would like additional items', 'Are you ordering these materials on behalf of an organisation?', 'Where will these items be offered?', 'Other: please specify', 'Age permisson granted', 'Heard about', 'Heard about (other)'];


	for ($i = 1; $i <= 35; $i++)
	{
		$title_row[] = 'Item ' . $i;
		$title_row[] = 'Quantity';
	}

	$data[] = $title_row;


	foreach ($wpdb->get_results($sql, 'ARRAY_A') as $order)
	{
		$export = mb_unserialize($order['export']);


		$row = [];


		$row[] = $order['id'];
		$row[] = explode(' ', $order['created_at'])[0];
		$row[] = explode(' ', $order['created_at'])[1];


		$details_column_count = 0;
		foreach ($export['details'] as $detail) {
			$row[] = $detail;


			$details_column_count++;
		}


		// Add three additional columns to counter for old data without the new fields (14/09/2016)
		if ($details_column_count !== 32) {
			$row[] = null;
			$row[] = null;
			$row[] = null;
		}


		if (isset($export['items'])) {
			foreach ($export['items'] as $item) {
				$row[] = $item['title'];
				$row[] = $item['quantity'];
			}
		}


		$data[] = $row;
	};


	outputCSV($data);


	exit();
}


function outputCSV($data) {
	$output = fopen("php://output", "w");


	foreach ($data as $row) {
		fputcsv($output, $row);
	}


	fclose($output);
}


add_action('wp_ajax_nopriv_mof_postcode_check', 'mof_postcode_check');
add_action('wp_ajax_mof_postcode_check', 'mof_postcode_check');


function mof_postcode_check()
{
	global $wpdb;


	$sql = "SELECT postcodes FROM {$wpdb->prefix}" . MOF_TABLE_NAME . '_postcodes WHERE id = 1';
	$postcodes_array = $wpdb->get_results($sql, 'ARRAY_A');


	$blacklisted_postcodes = unserialize($postcodes_array[0]['postcodes']);


	if ($blacklisted_postcodes) {
		foreach ($blacklisted_postcodes as $postcode) {
			if (trim($_GET['postcode']) == str_replace("\r", '', trim($postcode))) {
				echo "false";
				die();
			}
		}
	}


	echo "true";
	die();
}


/**
 * Shortcode [mof] output
 */
function mof_output() {
	global $wpdb;


	$data = [];


	$section = 'Dementia Information';
	$categories = ['A4 booklets', 'Other booklets and leaflets (A5 and smaller)', 'Booklets in other languages', 'A3 Posters', 'Flyers', 'Children\\\'s Books'];


	foreach ($categories as $category) {
		$sql = "SELECT * FROM {$wpdb->prefix}" . MOF_TABLE_NAME . "_items WHERE section = '" . $section . "' AND category = '" . addslashes($category) . "' ORDER BY id";
		$dementia_info = $wpdb->get_results($sql);

		$items_array = [];

		foreach ($dementia_info as $item) {
			$items_array[] = (array) $item;
		}


		$data['dementia-info'][] = ['title' => $category, 'items' => $items_array];
		
	}


	$section = 'Fundraising Materials';
	$categories = ['General materials', 'Booklets and leaflets'];


	foreach ($categories as $category) {
		$sql = "SELECT * FROM {$wpdb->prefix}" . MOF_TABLE_NAME . "_items WHERE section = '" . $section . "' AND category = '" . $category . "' ORDER BY id";
		$fundraising_materials = $wpdb->get_results($sql);


		$items_array = [];


		foreach ($fundraising_materials as $item) {
			$item = (array) $item;


			$item['donation'] = unserialize($item['donation']);
			$item['restrictions'] = unserialize($item['restrictions']);


			$items_array[] = (array) $item;
		}


		$data['fundraising-materials'][] = ['title' => $category, 'items' => $items_array];
	}


	wp_enqueue_style('mof', MOF_CSS_URL . 'mof.min.css', [], MOF_VERSION);

	wp_enqueue_script('mof-jquery-validate', MOF_JS_URL . 'jquery.validate.min.js', [], '1.14.0', true);
	wp_enqueue_script('mof-pikaday', MOF_JS_URL . 'pikaday/pikaday.js', [], '1.3.3', true);
	wp_enqueue_script('mof-pikaday-jquery', MOF_JS_URL . 'pikaday/pikaday.jquery.js', [], '1.3.3', true);
	wp_enqueue_script('mof', MOF_JS_URL . 'mof.min.js', [], MOF_VERSION, true);


	echo '<div class="mof-wrapper">'; // Wrapper class to identify the order form


	if (isset($_GET['thanks'])) {
		require(MOF_TEMPLATE_DIR . 'thanks.php');

	} else if (isset($_GET['failure'])) {
		require(MOF_TEMPLATE_DIR . 'failure.php');

	} else {
		echo '<form method="POST" id="mofForm" novalidate>';
		echo '<input type="hidden" name="materials-required" value="" />';


		wp_nonce_field('mof', 'mof_nonce', true, true);


		require(MOF_TEMPLATE_DIR . 'masthead.php');
		require(MOF_TEMPLATE_DIR . 'step1-materials.php');
		require(MOF_TEMPLATE_DIR . 'step2-requirements.php');
		require(MOF_TEMPLATE_DIR . 'step3-details.php');


		echo '</form>';
	}


	echo '</div>';
}


add_shortcode('mof', 'mof_output');


/**
 * Returning POST with data format and save
 */
add_action('template_redirect', function() {
	if ((is_single() || is_page()) && isset($_POST['mof_nonce']) && wp_verify_nonce($_POST['mof_nonce'], 'mof')) {
		// Data validation
		$valid = MOF_Plugin::form_validation($_POST);


		if ($valid !== true)
		{
			wp_redirect($_POST['_wp_http_referer'] . '?failure=true');
			exit();
		}


		// Data filtering
		$data = MOF_Plugin::form_details($_POST);


		global $wpdb;


		$wpdb->insert($wpdb->prefix . MOF_TABLE_NAME, $data, '%s');


		$subject = 'Your Alzheimer\'s Research UK Order has been received';
		$email_template = file_get_contents(MOF_TEMPLATE_DIR . 'email.php');
		$content = '<br />Thank you for your order of: ' . nl2br(stripslashes($data['order_info'])) . '<br /><br />Your order will be with you within two weeks. If you have any questions or problems, or you need your items sooner, please <a href="http://www.alzheimersresearchuk.org/contact">contact us</a>.';

		$email_body = str_replace('{{ ORDER_DATA }}', $content, $email_template);


		add_filter('wp_mail_content_type', 'set_html_content_type');


		$email = wp_mail($data['email'], $subject, $email_body);


		// Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
		remove_filter('wp_mail_content_type', 'set_html_content_type');


		$donation = '&donation=5';


		if ($_POST['materials-required'] == 'Cheer Squad pack') {
			$donation = '&donation=3';
		}

		if ($_POST['materials-required'] == 'Fundraising pack') {
			$donation = '&donation=3';
		}

		if ($_POST['materials-required'] == 'Fundraising materials') {
			if ($_POST['money-raised'] == '0-20') {
				$donation = '&donation=3';

			} else if ($_POST['money-raised'] == '21-100') {
				$donation = '&donation=5';

			} else if ($_POST['money-raised'] == '101-250') {
				$donation = '&donation=10';

			} else if ($_POST['money-raised'] == '251-500') {
				$donation = '&donation=25';
			}
		}


		if ($_POST['additional-items']) {
			wp_redirect($_POST['_wp_http_referer'] . '?thanks=additional-items' . $donation);

		} else {
			wp_redirect($_POST['_wp_http_referer'] . '?thanks=true' . $donation);
		}


		exit();
	}
});


function set_html_content_type() {
	return 'text/html';
}


add_action('admin_enqueue_scripts', 'enqueue_date_picker');


function enqueue_date_picker() {
	wp_enqueue_script('jquery-ui-datepicker', ['jquery']);


	wp_register_style('jquery-ui', '//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.min.css');
	wp_enqueue_style('jquery-ui');
}