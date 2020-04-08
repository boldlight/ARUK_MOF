<div class="step3">
	<div class="container intro">
		<div class="row">
			<div class="col-md-12">
				<h3><span>3</span>Provide us with your details.</h3>
			</div>
		</div>
	</div>

	<div class="container form">
		<p>
			Please complete your details below. *Required.
		</p>

		<p>
			If you are under the age of 14 please gain permission from a parent or guardian before completing this form.
		</p>

		<div class="form-group">
			<label for="date-of-birth">*Date of birth:</label>
			<div class="row">
				<div class="col-xs-4 col-sm-3 col-md-2">
					<select id="dob_day" name="dob_day" class="form-control dob" required>
						<option value="" selected disabled>Select</option>
						<?php for($i = 1; $i <= 31; $i++) {
							?><option value="<?php echo str_pad($i, 2, 0, STR_PAD_LEFT);?>"><?php echo str_pad($i, 2, 0, STR_PAD_LEFT);?></option><?php
						} ?>
					</select>
				</div>
				<div class="col-xs-4 col-sm-3 col-md-2">
					<select id="dob_month" name="dob_month" class="form-control dob" required>
						<option value="" selected disabled>Select</option>
						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
				</div>
				<div class="col-xs-4 col-sm-3 col-md-2">
					<select id="dob_year" name="dob_year" class="form-control dob" required>
						<option value="" selected disabled>Select</option>
						<?php for($i = date('Y') - 1; $i >= 1920; $i--) {
							?><option value="<?php echo $i;?>"><?php echo $i;?></option><?php
						} ?>
					</select>
				</div>
			</div>
		</div>

		<div class="form-group permission-granted-checkbox">
			<div class="checkbox no-left-push"><label><input type="checkbox" id="permission_granted" name="permission_granted" value="yes">&nbsp;*I confirm that I have received permission from my parent or guardian before filling out this form.</label></div>
		</div>

		<div class="row form-group">
			<div class="col-md-2">
				<label for="title">*Title:</label>
				<select id="title" name="title" class="form-control" required>
					<option value="" selected disabled>Select</option>
					<option>Mr</option>
					<option>Mrs</option>
					<option>Ms</option>
					<option>Miss</option>
					<option>Dr</option>
					<option>Prof</option>
				</select>
			</div>
		</div>

		<div class="row form-group">
			<div class="col-md-4">
				<label for="first-name">*First name:</label>
				<input type="text" id="first_name" name="first_name" class="form-control" placeholder="First name" required />
			</div>
		</div>

		<div class="row form-group">
			<div class="col-md-4">
				<label for="surname">*Surname:</label>
				<input type="text" id="last_name" name="last_name" class="form-control" placeholder="Surname" required />
			</div>
		</div>

		<div class="row form-group">
			<div class="col-md-4">
				<label for="contact-number">Contact number: <button type="button" class="info" data-toggle="popover" data-placement="top" data-content="Your contact number and email will only be used in reference to your order unless you choose to hear from us by giving consent below.">i</button></label>
				<input type="text" id="contact_number" name="contact_number" class="form-control" placeholder="Contact number" minlength="11" maxlength="11" pattern="[0-9]{11}" />
			</div>
		</div>

		<div class="row form-group">
			<div class="col-md-6">
				<label for="email">*Email: <button type="button" class="info" data-toggle="popover" data-placement="top" data-content="Your contact number and email will only be used in reference to your order unless you choose to hear from us by giving consent below.">i</button></label>
				<input type="email" id="email" name="email" class="form-control" placeholder="Email address" required />
			</div>
		</div>

		<div class="row form-group">
			<div class="col-md-6">
				<label for="email">*Confirm email:</label>
				<input type="email" id="email_confirm" name="email_confirm" class="form-control" placeholder="Confirm email address" required />
			</div>
		</div>

		<div class="row form-group">
			<div class="col-md-6">
				<label for="email">*Address:</label>
				<input type="text" id="address1" name="address1" class="form-control" placeholder="Address line 1" required />
				<input type="text" id="address2" name="address2" class="form-control" placeholder="Address line 2" />
			</div>
		</div>

		<div class="row form-group">
			<div class="col-md-6">
				<label for="town">*Town:</label>
				<input type="text" id="town" name="town" class="form-control" placeholder="Town" required />
			</div>
		</div>

		<div class="row form-group">
			<div class="col-md-4">
				<label for="postcode">*Postcode:</label>
				<input type="text" id="postcode" name="postcode" class="form-control" placeholder="Postcode" required />
			</div>
		</div>

		<div class="row form-group">
			<div class="col-md-4">
				<label for="heard_about">How did you hear about us?</label>
				<select id="heard_about" name="heard_about" class="form-control">
					<option value="" selected disabled>Select</option>
					<option>ARUK website</option>
					<option>ARUK mailing/email</option>
					<option>Friend/Relative</option>
					<option>Social Media</option>
					<option>parkrun</option>
					<option>Other</option>
				</select>
			</div>
		</div>

		<div class="row form-group heard_about_other">
			<div class="col-md-4">
				<label for="postcode">Other, please specify:</label>
				<input type="text" id="heard_about_other" name="heard_about_other" class="form-control" placeholder="Other, please specify" />
			</div>
		</div>

		<div class="form-group">
			<div class="checkbox no-left-push"><label><input type="checkbox" id="parkrunner" name="parkrunner" value="yes">&nbsp;<strong>I am a parkrunner</strong></label> <button type="button" class="info" data-toggle="popover" data-placement="top" data-content="Alzheimer’s Research UK is proud to be an official parkrun partner. To help us and parkrun measure the impact of our partnership we would like to understand how many of our supporters are parkrunners.">i</button></div>
		</div>

		<div class="form-group">
			<div class="checkbox no-left-push"><label><input type="checkbox" id="press_awareness" name="press_awareness" value="yes">&nbsp;<strong>I am happy to talk to the press</strong></label></div>
		</div>

		<p>
			We’d like you to be the first to know about the latest research and how your support makes a difference, as well as ways you can get involved and help fund our life-changing work.
		</p>

		<p>
			We’ll keep your information safe and never sell or swap it with anyone.
		</p>

		<div class="form-group">
			<label for="permissions">Let us know how we can contact you (tick below):</label>
			<div class="checkbox"><label><input type="checkbox" id="permissions" name="permissions[post]" value="yes">&nbsp;Post</label></div>
			<div class="checkbox"><label><input type="checkbox" id="permissions" name="permissions[email]" value="yes">&nbsp;Email</label></div>
			<div class="checkbox"><label><input type="checkbox" id="permissions" name="permissions[phone]" value="yes">&nbsp;Telephone</label></div>
			<div class="checkbox"><label><input type="checkbox" id="permissions" name="permissions[SMS]" value="yes">&nbsp;Text message</label></div>
		</div>

		<p>
			You can change how we talk to you at any time, by calling 0300 111 5555 or emailing <a href="mailto:enquiries@alzheimersresearchuk.org">enquiries@alzheimersresearchuk.org</a>.
		</p>

		<p>
			Our Privacy Notice can be found at <a href="http://www.alzheimersresearchuk.org/privacy-notice/" target="_blank">www.alzheimersresearchuk.org/privacy-notice/</a> and explains how we will use and store your information.
		</p>

		<div class="form-group terms-checkbox">
			<div class="checkbox no-left-push"><label><input type="checkbox" id="terms" name="terms" value="yes" required> *By ticking this box you confirm that you have read and agree to our <a href="http://www.alzheimersresearchuk.org/materials-order-form-terms-conditions/" target="_blank">terms and conditions</a>.</label></div>
		</div>

		<h3>Your order will arrive within two weeks.
			<br />If you need it sooner, please <a href="mailto:fundraising@alzheimersresearchuk.org">contact us</a> before submitting this form.</h3>

		<div class="row place-order">
			<div class="col-md-12">
				<button class="button"  id="submit-mofForm">Place my order</button>
			</div>
		</div>
	</div>
</div>
