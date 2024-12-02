<?php


class Orders_List extends WP_List_Table {

	public function __construct()
	{
		parent::__construct([
			'singular' => __('Materials Order', 'mof'),
			'plural' => __('Materials Orders', 'mof'),
			'ajax' => false
		]);
	}


	/**
	 * Retrieve orders data from the database
	 *
	 * @param int $per_page
	 * @param int $page_number
	 *
	 * @return mixed
	 */
	public function get_orders($per_page = 20, $page_number = 1)
	{
		global $wpdb;


		$sql = "SELECT * FROM {$wpdb->prefix}" . MOF_TABLE_NAME;
		$sql = $this->date_filter($sql);


		if (!empty($_REQUEST['orderby'])) {
			$sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
			$sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';

		} else {
			$sql .= ' ORDER BY created_at DESC';
		}


		$sql .= ' LIMIT ' . $per_page;
		$sql .= ' OFFSET ' . ($page_number - 1) * $per_page;


		return $wpdb->get_results($sql, 'ARRAY_A');
	}


	/**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	public function record_count() {
		global $wpdb;


		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}" . MOF_TABLE_NAME;
		$sql = $this->date_filter($sql);


		return $wpdb->get_var($sql);
	}


	/** Text displayed when no order data is available */
	public function no_items() {
		_e('No material orders found.', 'mof');
	}


	/**
	 * Render a column when no column specific method exist.
	 *
	 * @param array $item
	 * @param string $column_name
	 *
	 * @return mixed
	 */
	public function column_default($item, $column_name) {
		switch ($column_name) {
			case 'id':
				return sprintf('<a href="?page=%s&amp;action=%s&amp;order_id=%s">#' . $item[$column_name] . '</a>', $_REQUEST['page'], 'edit', $item[$column_name]);

			case 'address':
				return nl2br($item[$column_name]);

			case 'contact_number':
			case 'email':
				return $item[$column_name];

			case 'status':
				return ucfirst($item[$column_name]);

			case 'created_at':
			case 'updated_at':
				return date('d/m/Y H:i:s', strtotime($item[$column_name]));

			default:
				return print_r($item, true);
		}
	}


	/**
	 * Method for name column
	 *
	 * @param array $item an array of DB data
	 *
	 * @return string
	 */
	function column_name($item) {
		$title = '<strong>' . sprintf('<a href="?page=%s&amp;action=%s&amp;order_id=%s">' . $item['name'] . '</a>', $_REQUEST['page'], 'edit', $item['id']) . '</strong>';
		$actions = null;

		/* REMOVED DUE TO INCOMPATIBILITY WITH PHPv8.2
		return $title . $this->row_actions($actions);
		*/
		return $title;
	}


	/**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {
		$columns = [
			'id' => __('Order ID', 'mof'),
			'name' => __('Name', 'mof'),
			'address' => __('Address', 'mof'),
			'contact_number' => __('Contact Number', 'mof'),
			'email' => __('Email', 'mof'),
			'created_at' => __('Created', 'mof'),
			'updated_at' => __('Updated', 'mof')
		];


		return $columns;
	}


	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {

		$this->_column_headers = $this->get_column_info();


		$per_page     = $this->get_items_per_page('orders_per_page', 20);
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();


		$this->set_pagination_args([
			'total_items' => $total_items,
			'per_page'    => $per_page
		]);


		$this->items = self::get_orders($per_page, $current_page);
	}


	public function get_by_id($id)
	{
		global $wpdb;


		$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}" . MOF_TABLE_NAME . ' WHERE id = %d', $id));


		return $row;
	}


	private function date_filter($sql) {
		if (!empty($_REQUEST['start_date'])) {
			$start_date = implode('-', array_reverse(explode('/', $_REQUEST['start_date'])));
		}


		if (!empty($_REQUEST['end_date'])) {
			$end_date = implode('-', array_reverse(explode('/', $_REQUEST['end_date'])));
		}


		if (isset($start_date) && isset($end_date)) {
			$sql .= ' WHERE created_at BETWEEN "' . $start_date . ' 00:00:00" AND "' . $end_date . ' 23:59:59"';

		} elseif (isset($start_date)) {
			$sql .= ' WHERE created_at >= "' . $start_date . '"';

		} elseif (isset($end_date)) {
			$sql .= ' WHERE created_at <= "' . $end_date . '"';
		}


		return $sql;
	}

}