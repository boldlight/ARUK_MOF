<div class="container thank-you">
	<div class="row">
		<div class="col-md-12">
			<article role="article" class="content">
				<h1>Thank you</h1>
				<h2 class="heading--introduction">Your order is on its way.</h2>

				<?php if ($_GET['thanks'] == 'additional-items') {
					?><p>Your order has been received – we'll be in touch as you requested.</p>
					<p>We'll try to contact you via phone or email over the next three working days to discuss the extra items you would like. If we can't reach you, we'll post what you've requested. You can always contact us to discuss how else we can support you.</p>
					<p>After we speak (or after three days) we will despatch your order (we'll email you to let you know when it's been posted). It will be with you within the following two weeks. If you need your items urgently, please contact us and we'll do our best to help.</p>
					<p>For every £1 donated, 84p powers our research and helps the fightback against dementia. Why not help Alzheimer's Research UK fund more groundbreaking work by donating towards the cost of your materials?</p><?php

				} else {
					?><p>If you've given us permission to send you emails, you should receive an order confirmation shortly. We'll also email you when your package has been despatched: it will be delivered within the next two weeks. If you need your items urgently, please contact us and we'll do our best to help.</p>
					<p>For every £1 donated, 84p powers our research and helps the fightback against dementia. Why not help Alzheimer's Research UK fund more groundbreaking work by donating towards the cost of your materials?</p><?php
				} ?>

				<p><a href="https://donate.alzheimersresearchuk.org/publicnew/single.aspx?donationtype=single<?php if (isset($_GET['donation'])) { echo '&donationamount=' . $_GET['donation']; } else { echo '&donationamount=5'; } ?>" class="button" target="_blank">Donate online now</a></p>
			</article>
		</div>
	</div>
</div>
