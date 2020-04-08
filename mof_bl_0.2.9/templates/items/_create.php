<?php $items_obj = new Catalogue_List();


global $wpdb;


if (isset($_POST['insert'])) {
	$data = [
		'section' => trim($_POST['section']),
		'category' => trim($_POST['category']),
		'title' => trim($_POST['title']),
		'summary' => trim($_POST['summary']),
		'image' => trim($_POST['image']),
		'link' => trim($_POST['link']),
		'created_at' => date('Y-m-d H:i:s'),
		'updated_at' => date('Y-m-d H:i:s')
	];

	if (trim($_POST['donation']) == '') {
		$data['donation'] = null;

	} else {
		$data['donation'] = serialize(explode("\n", trim($_POST['donation'])));
	}

	$restrictions_array = explode("\n", trim($_POST['restrictions']));


	if (trim($_POST['restrictions']) == '') {
		$data['restrictions'] = null;

	} else {
		foreach ($restrictions_array as $restriction) {
			$restriction_array = explode(':', trim($restriction));
			$restrictions[trim($restriction_array[0])] = trim($restriction_array[1]);
		}


		$data['restrictions'] = serialize($restrictions);
	}


	$wpdb->insert("{$wpdb->prefix}" . MOF_TABLE_NAME . '_items', $data, '%s');
}

if (isset($_GET['item_id'])) {
	$item = $items_obj->get_by_id($_GET['item_id']);
}
$donations = [];
$restrictions = [];


if (!empty($item->donation)) {
	$donations = unserialize($item->donation);
}


if (!empty($item->restrictions)) {
	foreach (unserialize($item->restrictions) as $key => $value) {
		$restrictions[] = $key . ': ' . $value;
	}
} ?>

<div class="wrap">
<h2>Items Catalogue - New Item</h2>

<?php if (isset($_POST['insert'])) {
	?>
	<div class="updated"><p>Catalogue item inserted</p></div>
<a href="<?php echo admin_url('admin.php?page=mof_items'); ?>">&laquo; Back to Items Catalogue</a><?php
} ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<table class="form-table">
		<tr>
			<th scope="row"><label>Section:</label></th>
			<td><select name="section">
					<option>Dementia Information</option>
					<option>Fundraising Materials</option>
				</select></td>
		</tr>
		<tr>
			<th scope="row"><label>Category:</label></th>
			<td><select name="category">
				<option>A3 Posters</option>
				<option>A4 booklets</option>
				<option>Booklets and leaflets</option>
				<option>Flyers</option>
				<option>General materials</option>
				<option>Other booklets and leaflets (A5 and smaller)</option>
				<option>Booklets in other languages</option>
				<option>Children's Books</option>
			</select></td>
		</tr>
		<tr>
			<th scope="row"><label>Title:</label></th>
			<td><input type="text" size="85" name="title" required /></td>
		</tr>
		<tr>
			<th scope="row"><label>Description:</label></th>
			<td><textarea id="summary" name="summary" style="width: 50%; height: 120px;"></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"><label>Image:</label></th>
			<td><input type="text" size="85" name="image" required /></td>
		</tr>
		<tr>
			<th scope="row"><label>Link:</label></th>
			<td><input type="text" size="85" name="link" /></td>
		</tr>
		<tr>
			<th scope="row"><label>Donation:</label></th>
			<td><textarea name="donation" style="width: 30%; height: 120px;"></textarea>
				<br/>
				<small>New line for each donation requirement from 0-20, 21-100, 101-250, 251-500</small>
			</td>
		</tr>
		<tr>
			<th scope="row"><label>Restrictions:</label></th>
			<td><textarea name="restrictions"
			              style="width: 30%; height: 120px;"></textarea>
				<br/>
				<small>New line for restriction requirement from 0-20, 21-100, 101-250, 251-500 separated by colon
					for the amount.
					<br/>Example:
					<br/>0-20: 10
					<br/>21-100: 20
					<br/>101-250: 50
					<br/>251-500: 100
				</small>
			</td>
		</tr>
	</table>

	<input type="submit" name="insert" value="Save" class="button">
</form>
</div>