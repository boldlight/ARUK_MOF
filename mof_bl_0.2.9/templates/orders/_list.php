<div class="wrap">
	<h2>Materials Orders
		<a href="<?php echo admin_url('admin-post.php?action=mof_orders_export');?>&amp;start_date=<?php echo isset($_REQUEST['start_date']);?>&amp;end_date=<?php echo isset($_REQUEST)['end_date'];?>" class="add-new-h2">Export to CSV</a>
	</h2>

	<h3>Filtering</h3>
	<form action="<?php echo admin_url('admin.php');?>" method="get">
		<input type="hidden" name="page" value="mof" />

		<label>Start Date</label>
		<input type="text" id="start_date" name="start_date" value="<?php echo isset($_REQUEST['start_date']);?>" class="datepicker" />
		&nbsp;&nbsp;&nbsp;&nbsp;<label>End Date</label>
		<input type="text" id="end_date" name="end_date" value="<?php echo isset($_REQUEST['end_date']);?>" class="datepicker" />

		<input type="submit" class="button action" />
	</form>

	<?php $this->orders_obj->prepare_items();
	$this->orders_obj->display(); ?>
</div>


<script>
	jQuery(document).ready(function(){
		jQuery('.datepicker').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy'
		});
	});
</script>