<?php $postcodes_obj = new Postcodes_List();


if (isset($_POST['update']))
{
	global $wpdb;


	$data['postcodes'] = serialize(explode("\n", trim($_POST['postcodes'])));


	$wpdb->update("{$wpdb->prefix}" . MOF_TABLE_NAME . '_postcodes', $data, ['id' => 1], ['%s'], ['%s']);
}


$postcodes = $postcodes_obj->get_by_id(1);
$postcodes_list = [];


if (!empty($postcodes->postcodes))
{
	$postcodes_list = unserialize($postcodes->postcodes);
} ?>

<div class="wrap">
	<h2>Blacklisted Postcodes</h2>

	<?php if (isset($_POST['update'])) {
		?><div class="updated"><p>Blacklisted postcodes updated</p></div><?php
	} ?>

	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<table class="form-table">
			<tr>
				<th scope="row"><label>Blacklisted Postcodes:</label></th>
				<td><textarea name="postcodes" style="width: 25%; height: 600px;"><?php echo implode("\n", $postcodes_list);?></textarea></td>
			</tr>
		</table>

		<input type='submit' name="update" value="Save" class="button">
	</form>
</div>