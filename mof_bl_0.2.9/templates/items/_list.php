<?php
$items_obj = new Catalogue_List();?>

<div class="wrap">
	<h2>Items Catalogue
		<a href="<?php echo admin_url('admin.php?page=mof_items_create'); ?>" class="add-new-h2">Add New</a>
	</h2>

	<?php $items_obj->prepare_items();
	$items_obj->display(); ?>
</div>