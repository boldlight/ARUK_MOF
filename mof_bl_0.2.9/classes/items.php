<?php


class Catalogue_List extends WP_List_Table {


	/**
	 * Retrieve items data from the database
	 *
	 * @return mixed
	 */
	public static function get_catalogue()
	{
		global $wpdb;


		$sql = "SELECT * FROM {$wpdb->prefix}" . MOF_TABLE_NAME . '_items';


		if (!empty($_REQUEST['orderby'])) {
			$sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
			$sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';

		} else {
			$sql .= ' ORDER BY id';
		}


		return $wpdb->get_results($sql, 'ARRAY_A');
	}


	/**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	public static function record_count() {
		global $wpdb;


		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}" . MOF_TABLE_NAME . '_items';


		return $wpdb->get_var($sql);
	}


	/** Text displayed when no order data is available */
	public function no_items() {
		_e('No catalogue items found.', 'mof');
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
				return sprintf('<a href="?page=%s&amp;action=%s&amp;item_id=%s">#' . $item[$column_name] . '</a>', $_REQUEST['page'], 'edit', $item[$column_name]);

			case 'title':
			case 'section':
			case 'category':
				return stripslashes($item[$column_name]);

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
	function column_title($item) {
		$title = '<strong>' . sprintf('<a href="?page=%s&amp;action=%s&amp;item_id=%s">' . stripslashes($item['title']) . '</a>', $_REQUEST['page'], 'edit', $item['id']) . '</strong>';
		$actions = null;

		/*
		// Chris - Removed due to PHP upgrade incompatibility 
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
			'id' => __('Item ID', 'mof'),
			'title' => __('Title', 'mof'),
			'section' => __('Section', 'mof'),
			'category' => __('Category', 'mof'),
			'created_at' => __('Created', 'mof'),
			'updated_at' => __('Updated', 'mof')
		];


		return $columns;
	}


	/**
	 * Define which columns are hidden
	 *
	 * @return Array
	 */
	public function get_hidden_columns()
	{
		return [];
	}


	/**
	 * Define the sortable columns
	 *
	 * @return Array
	 */
	public function get_sortable_columns()
	{
		return ['title' => ['title', false]];
	}


	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {
		$columns = $this->get_columns();
		$hidden = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();


		$this->_column_headers = [$columns, $hidden, $sortable];
		$this->items = self::get_catalogue();
	}


	public function get_by_id($id)
	{
		global $wpdb;


		$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}" . MOF_TABLE_NAME . '_items WHERE id = %d', $id));


		return $row;
	}
}