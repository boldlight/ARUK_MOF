<section class="requirements-select fundraising-materials">
	<div class="stage1">
		<div class="col-md-8 content-block">
			<p>Thank you for joining the fightback against dementia by fundraising for Alzheimer's Research UK.</p>
			<p>We have a wide range of materials to support your fundraising. Please tell us a little about your plans: *Required</p>

			<div class="form-group">
				<label>*What type of event are you planning?</label>
				<div class="row">
					<div class="col-md-4">
						<select name="event-planned" class="form-control">
							<option disabled selected>Select</option>
							<option>Bake Sale</option>
							<option>Coffee Morning</option>
							<option>Collection</option>
							<option>Dress Up/Down Day</option>
							<option>Gala Dinner/Party</option>
							<option>Golf Event</option>
							<option>Quiz</option>
							<option>Sponsored Walk</option>
							<option>Trek</option>
							<option>Sporting Event</option>
							<option>Don't know yet</option>
							<option>Other</option>
						</select>
					</div>
				</div>
			</div>

			<div class="row form-group event-planned-other">
				<div class="col-md-6">
					<label>*Other: please specify</label>
					<input type="text" name="event-planned-other" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label>*When will your event start?</label>
				<div class="row">
					<div class="col-md-6">
						<input type="text" id="date_start" name="date-start" placeholder="Select date" class="form-control datepicker" />
					</div>
				</div>
			</div>

			<div class="form-group">
				<label>*When will your event finish?</label>
				<div class="row">
					<div class="col-md-6">
						<input type="text" id="date_finish" name="date-finish" placeholder="Select date" class="form-control datepicker" />
					</div>
				</div>
			</div>

			<div class="form-group">
				<label>*How much do you expect to raise?</label>
				<div class="row">
					<div class="col-md-4">
						<select name="money-raised" class="form-control">
							<option value="0-20">&pound;0 - 20</option>
							<option value="21-100">&pound;21 - 100</option>
							<option value="101-250">&pound;101 - 250</option>
							<option value="251-500">over &pound;250</option>
						</select>
					</div>
				</div>
			</div>

			<div class="row form-group money-raised-other">
				<div class="col-md-6">
					<label>*How much do you think you will raise?</label>
					<input type="text" name="money-raised-other" class="form-control">
				</div>
			</div>

			<p class="error">Please ensure all the fields above marked as required have a value to continue.</p>

			<p><br /><a href="#" class="button stage2">Next</a></p>
		</div>
		<div class="col-md-4">
			<div class="panel-overview">
				<img src="<?php echo MOF_IMG_URL;?>step2/FundraisingMaterials.jpg" class="img-responsive" />
				<h3>What your fundraising could power</h3>

				<div class="button-group">
					<a href="#" class="button active" data-text-switch="score">&pound;20</a>
					<a href="#" class="button" data-text-switch="ton">&pound;100</a>
					<a href="#" class="button" data-text-switch="half-monkey">&pound;250</a>
					<a href="#" class="button" data-text-switch="monkey">&pound;500</a>
				</div>

				<div class="text-switch">
					<p class="score active">&pound;20 could buy slides for scientists to study 200 samples under the microscope helping them to focus in on the molecular detail of what causes dementia – crucial for developing new treatments.</p>
					<p class="ton">&pound;100 could help provide the tools for scientists to map 5000 genes in minute detail, identifying targets for the development of new treatments.</p>
					<p class="half-monkey">&pound;250 could pay for 500 test tubes, the lifeblood of effective dementia research.</p>
					<p class="monkey">&pound;500 could cover the cost of a sensitive brain scan for a patient involved in a research study, tracking the effectiveness of new drug treatments, improving diagnosis and furthering our understanding of how diseases like Alzheimer’s wreak their havoc in the brain.</p>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-12 stage2">
		<?php foreach($data['fundraising-materials'] as $block) {
			?><fieldset>
			<legend><?php echo $block['title'];?></legend>

			<div class="row">
				<?php foreach($block['items'] as $item) {
				?>
				<div class="col-xs-12 col-sm-6 col-md-3 panel-item<?php foreach ($item['donation'] as $donation_required) { ?> donation<?php echo $donation_required; ?><?php } ?>">
					<div class="item-wrapper">
						<div class="image-wrapper">
							<?php if ($item['summary'] != '') { ?>
								<button type="button" class="info" data-toggle="popover" data-placement="top" data-content="<?php echo stripslashes($item['summary']); ?>">i</button><?php } ?>
							<img src="<?php echo MOF_IMG_URL . 'step2/' . $item['image']; ?>" class="img-responsive"/>
						</div>

						<div class="content-wrapper">
							<div class="text-wrapper">
								<h3><?php echo stripslashes($item['title']); ?></h3>
								<?php if (stripslashes($item['title']) == 'T-shirts') {
									?><p style="padding: 0 10%;">Not sure what size you need? <a id="sizingGuideModal2" href="#sizingGuide2">View our size guide</a>.</p>

									<div id="sizingGuide2">
										<h3>Sizing Guide
											<br /><small style="font-size: 65%;">All sizes in cm</small></h3>
										<img src="<?php echo MOF_IMG_URL;?>step2/Sizing-Guide.png" class="img-responsive" />
									</div><?php
								} ?>
							</div>

							<?php if ($item['link']) {
								?><a href="<?php echo MOF_DOWNLOADS_URL . $item['link']; ?>" class="button" target="_blank">
									Download</a><?php
							}

							foreach ($item['restrictions'] as $key => $value)
							{
								?><select name="<?php echo strtolower(stripslashes($block['title'])); ?>[<?php echo stripslashes($item['title']); ?>]" class="form-control restriction<?php echo $key; if (stripslashes($item['title']) == 'T-shirts') { ?> quantity-selector<?php } ?>">
									<option value="0" selected disabled>Number required?</option>
									<?php for ($i = 0; $i <= $value; $i++) {
										?><option><?php echo $i;?></option><?php
									} ?>
								</select><?php
							} ?>
						</div>
					</div>
					</div><?php
				} ?>
			</div>
			</fieldset><?php
		} ?>

		<p><div class="checkbox"><label><input type="checkbox" name="additional-items" value="yes">&nbsp;I would like additional items, and would like a member of Alzheimer’s Research UK staff to contact me about this before processing my order.</label></div></p>

		<p class="error quantities">Please ensure at least one of the material items above has been selected.</p>

		<div class="row" style="margin-bottom: 40px;">
			<p class="col-xs-12 size-prompt">You have selected t-shirts, please specify the sizes you require:</p>
			<div class="size-selector"></div>
			<div class="col-xs-12 col-sm-2 size-selector-clone">
				<select name="size[]" class="form-control">
					<option selected disabled>Select</option>
					<option>Adult T-Shirt - L</option>
					<option>Adult T-Shirt - M</option>
					<option>Adult T-Shirt - S</option>
					<option>Adult T-Shirt - XL</option>
				</select>
			</div>
		</div>

		<p class="error sizes">Please ensure all size selectors above have a value to continue.</p>

		<a href="#" class="button next">Next</a>
	</div>
</section>