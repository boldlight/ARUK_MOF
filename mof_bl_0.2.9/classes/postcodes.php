<?php


class Postcodes_List extends WP_List_Table {

	public function get_by_id($id)
	{
		global $wpdb;


		$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}" . MOF_TABLE_NAME . '_postcodes WHERE id = %d', $id));


		return $row;
	}

}