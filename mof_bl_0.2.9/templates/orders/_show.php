<div class="wrap">
	<h2>Materials Orders - #<?php echo $_GET['order_id'];?></h2>

	<form method="post">
		<?php $order = $this->orders_obj->get_by_id($_GET['order_id']);?>
		<table class="form-table">
			<tr>
				<th scope="row"><label>Name:</label></th>
				<td><input type="text" size="55" name="name" value="<?php echo esc_js($order->name);?>" readonly /></td>
			</tr>
			<tr>
				<th scope="row"><label>Address:</label></th>
				<td><textarea name="address" style="width: 50%; height: 150px;" readonly><?php echo str_replace('\n', "\n", esc_js($order->address));?></textarea></td>
			</tr>
			<tr>
				<th scope="row"><label>Order information:</label></th>
				<td><textarea name="address" style="width: 50%; height: 300px;" readonly><?php echo str_replace('\n', "\n", esc_js(utf8_encode($order->order_info)));?></textarea></td>
			</tr>
			<tr>
				<th scope="row"><label>Email:</label></th>
				<td><input type="text" size="55" name="email" value="<?php echo esc_js($order->email);?>" readonly /></td>
			</tr>
			<tr>
				<th scope="row"><label>Contact number:</label></th>
				<td><input type="text" size="45" name="contact_number" value="<?php echo esc_js($order->contact_number);?>" readonly /></td>
			</tr>
			<tr>
				<th scope="row"><label>Date of birth:</label></th>
				<td><input type="text" size="35" name="dob" value="<?php echo esc_js($order->dob);?>" readonly /></td>
			</tr>
			<tr>
				<th scope="row"><label>Are you a Parkrunner?</label></th>
				<td><input type="text" size="35" name="dob" value="<?php echo ucfirst(esc_js($order->parkrunner));?>" readonly /></td>
			</tr>
			<tr>
				<th scope="row"><label>Happy to talk to the press team?</label></th>
				<td><input type="text" size="35" name="dob" value="<?php echo ucfirst(esc_js($order->press_team));?>" readonly /></td>
			</tr>
			<tr>
				<th scope="row"><label>Permissions:</label></th>
				<td><textarea name="address" style="width: 50%; height: 100px;" readonly><?php echo str_replace('\n', "\n", esc_js($order->permissions));?></textarea></td>
			</tr>
		</table>
	</form>
</div>