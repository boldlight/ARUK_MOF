<?php $items_obj = new Catalogue_List();


global $wpdb;


if (isset($_POST['delete'])) {
	$wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->prefix}" . MOF_TABLE_NAME . '_items WHERE id = %s', $_GET['item_id']));?>


	<div class="wrap">
		<h2>Items Catalogue</h2>

		<div class="updated"><p>Catalogue item deleted</p></div>
		<a href="<?php echo admin_url('admin.php?page=mof_items');?>">&laquo; Back to Items Catalogue</a>
	</div><?php

} else {
	if (isset($_POST['update'])) {
		$data = [
			'section' => trim($_POST['section']),
			'category' => trim($_POST['category']),
			'title' => trim($_POST['title']),
			'summary' => trim($_POST['summary']),
			'image' => trim($_POST['image']),
			'link' => trim($_POST['link']),
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


		$wpdb->update("{$wpdb->prefix}" . MOF_TABLE_NAME . '_items', $data, ['id' => $_GET['item_id']], ['%s'], ['%s']);
	}


	$item = $items_obj->get_by_id($_GET['item_id']);
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
	<h2>Items Catalogue - <?php echo stripslashes($item->title); ?></h2>

	<?php if (isset($_POST['update'])) {
		?>
		<div class="updated"><p>Catalogue item updated</p></div>
	<a href="<?php echo admin_url('admin.php?page=mof_items'); ?>">&laquo; Back to Items Catalogue</a><?php
	} ?>

	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<table class="form-table">
			<tr>
				<th scope="row"><label>Section:</label></th>
				<td><select name="section">
						<option <?php if ($item->section == 'Dementia Information') {
							echo 'selected';
						} ?>>Dementia Information
						</option>
						<option <?php if ($item->section == 'Fundraising Materials') {
							echo 'selected';
						} ?>>Fundraising Materials
						</option>
					</select></td>
			</tr>
			<tr>
				<th scope="row"><label>Category:</label></th>
				<td><select name="category">
						<option <?php if ($item->category == 'A3 Posters') {
							echo 'selected';
						} ?>>A3 Posters
						</option>
						<option <?php if ($item->category == 'A4 booklets') {
							echo 'selected';
						} ?>>A4 booklets
						</option>
						<option <?php if ($item->category == 'Booklets and leaflets') {
							echo 'selected';
						} ?>>Booklets and leaflets
						</option>
						<option <?php if ($item->category == 'Flyers') {
							echo 'selected';
						} ?>>Flyers
						</option>
						<option <?php if ($item->category == 'General materials') {
							echo 'selected';
						} ?>>General materials
						</option>
						<option <?php if ($item->category == 'Other booklets and leaflets (A5 and smaller)') {
							echo 'selected';
						} ?>>Other booklets and leaflets (A5 and smaller)
						</option>
						<option <?php if ($item->category == 'Booklets in other languages') {
							echo 'selected';
						} ?>>Booklets in other languages
						</option>
						<option <?php if ($item->category == 'Children\\\'s Books') {
							echo 'selected';
						} ?>>Children's Books
						</option>
					</select></td>
			</tr>
			<tr>
				<th scope="row"><label>Title:</label></th>
				<td><input type="text" size="85" name="title" value="<?php echo stripslashes($item->title); ?>" required /></td>
			</tr>
			<tr>
				<th scope="row"><label>Description:</label></th>
				<td><textarea id="summary" name="summary"
				              style="width: 50%; height: 120px;"><?php echo stripslashes($item->summary); ?></textarea>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Image:</label></th>
				<td><input type="text" size="85" name="image" value="<?php echo $item->image; ?>" required /></td>
			</tr>
			<tr>
				<th scope="row"><label>Link:</label></th>
				<td><input type="text" size="85" name="link" value="<?php echo $item->link; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label>Donation:</label></th>
				<td><textarea name="donation" style="width: 30%; height: 120px;"><?php echo implode("\n", $donations); ?></textarea>
					<br/>
					<small>New line for each donation requirement from 0-20, 21-100, 101-250, 251-500</small>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Restrictions:</label></th>
				<td><textarea name="restrictions"
				              style="width: 30%; height: 120px;"><?php echo implode("\n", $restrictions); ?></textarea>
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

		<input type="submit" name="update" value="Save" class="button">&nbsp;&nbsp;
		<input type="submit" name="delete" value="Delete" class="button"
		       onclick="return confirm('Are you sure you want to delete \'<?php echo $item->title; ?>\'?')">
	</form>
	</div><?php
}