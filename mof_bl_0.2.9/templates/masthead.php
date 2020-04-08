<div class="container">
	<div class="row">
		<div class="col-md-12">
			<article role="article" class="content">
				<h1>Materials and literature</h1>
				<h2 class="heading--introduction">Alzheimer's Research UK has a wide range of fundraising materials and information. Use the form below to make your order.</h2>
				<h3>Your order will arrive within two weeks. If you need it sooner, please <a href="mailto:fundraising@alzheimersresearchuk.org">contact us</a> before completing this form.</h3>

				<?php
				/**
				 * Component: Sharing
				 *
				 * @package Alzheimers Research UK
				 */

				// Get current URL
				$current_url = get_site_url() . $_SERVER['REQUEST_URI'];

				// Title
				$title = get_bloginfo('name') . ' - ' . get_the_title();

				// Email body
				$email_body = 'I saw this on the ' . get_bloginfo('name') . ' website and thought you might be interested: ' . $current_url; ?>

				<div class="component-sharing cf">
					<a href="https://twitter.com/share?url=<?php echo $current_url; ?>&amp;text=<?php echo $title; ?>: " class="component-sharing__button component-sharing__button--twitter" title="Tweet" target="_blank">Tweet</a>

					<a href="http://www.facebook.com/sharer.php?u=<?php echo $current_url; ?>" class="component-sharing__button component-sharing__button--facebook" title="Share" target="_blank">Share</a>

					<a href="mailto:?subject=<?php echo $title; ?>&amp;body=<?php echo $email_body; ?>" class="component-sharing__button component-sharing__button--email" title="Email">Email</a>

					<script type="IN/Share"></script>

					<div class="g-plusone" data-size="tall" data-annotation="none"></div>
				</div>
			</article>
		</div>
	</div>
</div>