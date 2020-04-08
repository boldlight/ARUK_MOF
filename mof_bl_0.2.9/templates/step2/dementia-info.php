<section class="requirements-select dementia-info">
	<div class="col-md-12 content-block">
		<p>We have a wide selection of information booklets, leaflets and posters. Order them for personal use, or offer them to colleagues and the public. If you need more than 50 of any individual item, please contact us. *Required.</p>

		<div class="form-group">
			<label>*Are you ordering these materials on behalf of an organisation?</label>
			<div class="checkbox"><label><input type="radio" name="on-behalf-of-organisation" value="yes">&nbsp;Yes</label></div>
			<div class="checkbox"><label><input type="radio" name="on-behalf-of-organisation" value="no">&nbsp;No</label></div>
		</div>

		<div class="row form-group on-behalf-of-organisation-type">
			<div class="col-md-6">
				<label>*Where will these items be offered?</label>
				<select name="on-behalf-of-organisation-type" class="form-control">
					<option selected disabled>Select</option>
					<option>Care home</option>
					<option>Charity</option>
					<option>Council</option>
					<option>GP surgery</option>
					<option>Higher education (e.g. University, College)</option>
					<option>Hospital</option>
					<option>Library</option>
					<option>Memory clinic</option>
					<option>Pharmacy</option>
					<option>School</option>
					<option>Other</option>
				</select>
			</div>
		</div>

		<div class="row form-group on-behalf-of-organisation-type-other">
			<div class="col-md-4">
				<label>*Other: please specify</label>
				<input type="text" name="on-behalf-of-organisation-type-other" class="form-control">
			</div>
		</div>

		<p><strong>Please choose from the following literature. Download them directly or request a number of printed copies.</strong></p>
	</div>

	<div class="col-md-12">
		<?php foreach($data['dementia-info'] as $block) {?>
		<fieldset>
				<legend><?php echo stripslashes($block['title']);?></legend>

				<div class="row">
					<?php foreach($block['items'] as $item) {
						?>
						<div class="col-xs-12 col-sm-6 col-md-3 panel-item">
							<div class="item-wrapper">
								<div class="image-wrapper">
									<button type="button" class="info" data-toggle="popover" data-placement="top" data-content="<?php echo stripslashes($item['summary']);?>">i</button>
									<img src="<?php echo MOF_IMG_URL . 'step2/' . $item['image'];?>" class="img-responsive" />
								</div>

								<div class="content-wrapper">
									<h3><?php echo stripslashes($item['title']);?></h3>
									<a href="<?php echo MOF_DOWNLOADS_URL . $item['link'];?>" class="button" target="_blank">Download</a>

<?php 
$res = unserialize($item['restrictions']);

$title_ = str_replace('\'', '', strtolower(stripslashes($block['title'])));
//childrens books
if($title_ == 'childrens books'){
?>
<select name="<?php echo str_replace('\'', '', strtolower(stripslashes($block['title']))); ?>[<?php echo $item['title'];?>]" class="form-control">
	<option value="0" selected disabled>Request printed copies</option>
	<option>0</option>
	<option>1</option>
	<option>2</option>
	<option>3</option>
	<option>4</option>
	<option>5</option>
	<option>6</option>
	<option>7</option>
	<option>8</option>
	<option>9</option>
	<option>10</option>
</select>
<?php
}elseif (isset($res['max'])){
?>
<select name="<?php echo str_replace('\'', '', strtolower(stripslashes($block['title']))); ?>[<?php echo $item['title'];?>]" class="form-control">
	<option value="0" selected disabled>Request printed copies</option>
	<?php for ($i = 0; $i <= $res['max']; $i++) {
			?><option><?php echo $i;?></option><?php
		} ?>
</select>
<?php
}else{
?>
<select name="<?php echo str_replace('\'', '', strtolower(stripslashes($block['title']))); ?>[<?php echo $item['title'];?>]" class="form-control">
	<option value="0" selected disabled>Request printed copies</option>
	<option>0</option>
	<option>1</option>
	<option>2</option>
	<option>3</option>
	<option>4</option>
	<option>5</option>
	<option>10</option>
	<option>20</option>
	<option>30</option>
	<option>40</option>
	<option>50</option>
</select>
<?php } ?>
								</div>
							</div>
						</div><?php
					} ?>
				</div>
			</fieldset><?php
		} ?>

		<p class="error">Please ensure all the fields above marked as required have a value to continue.</p>
		<p class="error quantities">Please ensure at least one of the material items above has been selected.</p>

		<a href="#" class="button next">Next</a>
	</div>
</section>