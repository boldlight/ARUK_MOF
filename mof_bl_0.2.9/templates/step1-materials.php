<script>
 jQuery(document).ready(function($){
	$.extend({
		getUrlVars: function(){
			var vars = [], hash;
			var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
			for(var i = 0; i < hashes.length; i++){
				hash = hashes[i].split('=');
				vars.push(hash[0]);
				vars[hash[0]] = hash[1];
			}
			return vars;
		},
		getUrlVar: function(name){
			url_var = $.getUrlVars();
			if(url_var[name]){
				return url_var[name];
			}
			return null;
		}
	});
	
	var tab = $.getUrlVar('tab');	
	if(tab){
		$('#'+tab).click();
	}    
 });

</script>

<div class="step1">
	<div class="container intro active">
		<div class="row">
			<div class="col-md-12">
				<a href="#" class="back-up" data-step="1">&#9660;</a>
				<h3><span>1</span>Select materials.</h3>
			</div>
		</div>
	</div>

	<!-- Desktop version -->
	<div class="container choices hidden-xs">
		<div class="row">
			<ul class="col-md-12">
				<li><a href="#" id="fundraising-pack" title="Fundraising pack" class="button active" data-panel="fundraising-pack">Fundraising<br />pack</a></li>
				<li><a href="#" id="cheer-squad-pack" title="Cheer Squad pack" class="button" data-panel="cheer-squad-pack">Cheer Squad<br />pack</a></li>
				<li><a href="#" id="fundraising-materials" title="Fundraising materials" class="button" data-panel="fundraising-materials">Fundraising materials</a></li>
				<li><a href="#" id="information-about-dementia" title="Information about dementia" class="button" data-panel="dementia-info">Information<br />about dementia</a></li>
				<li><a href="#" id="running-cycling-or-other-challenges" title="Running, cycling or other challenges" class="button" data-panel="challenges">Running, cycling<br />or other challenges</a></li>
			</ul>
		</div>
	</div>

	<div class="container hidden-xs">
		<section class="materials-select fundraising-pack active">
			<div class="image">
				<img src="<?php echo MOF_IMG_URL;?>step1/Fundraising-Pack.jpg" alt="Fundraising pack" class="img-responsive">
			</div>

			<div class="content">
				<h2>Fundraising pack</h2>
				<p>Be part of the fight back. Whether you want to run a bake-off or a marathon, order your fundraising pack with all you need to get started.</p>

				<a href="https://fundraise.alzheimersresearchuk.org/" class="button" >Get your pack</a>
			</div>
		</section>

		<section class="materials-select cheer-squad-pack">
			<div class="image">
				<img src="<?php echo MOF_IMG_URL;?>step1/Cheer-Squad.jpg" alt="Cheer Squad pack" class="img-responsive">
			</div>

			<div class="content">
				<h2>Cheer Squad pack</h2>
				<p>Everything you need to support someone's fundraising challenge! You can order up to five packs for you, your friends and family – please <a href="mailto:fundraising@alzheimersresearchuk.org">contact us</a> if you'd like more.</p>

				<a href="#" class="button internal" data-materials-select="cheer-squad-pack" data-materials-selected-title="Cheer Squad pack">Select this pack</a>
			</div>
		</section>

		<section class="materials-select fundraising-materials">
			<div class="image">
				<img src="<?php echo MOF_IMG_URL;?>step1/Fundraising-Materials.jpg" alt="Fundraising materials" class="img-responsive">
			</div>

			<div class="content">
				<h2>Fundraising materials</h2>
				<p>If you have a plan for your fundraising, we can support you with a great range of fantastic materials.</p>

				<a href="#" class="button internal" data-materials-select="fundraising-materials" data-materials-selected-title="Fundraising materials">Select</a>
			</div>
		</section>

		<section class="materials-select dementia-info">
			<div class="image">
				<img src="<?php echo MOF_IMG_URL;?>step1/Information-About-Dementia.jpg" alt="Information about dementia" class="img-responsive">
			</div>

			<div class="content">
				<h2>Information about dementia</h2>
				<p>Answering questions about the diagnosis and symptoms of dementia, the treatments currently available, and the risk factors for developing the condition, for personal or organisational use.</p>

				<a href="#" class="button internal" data-materials-select="dementia-info" data-materials-selected-title="Information about dementia">Select</a>
			</div>
		</section>

		<section class="materials-select challenges">
			<div class="image">
				<img src="<?php echo MOF_IMG_URL;?>step1/Running-Cycling-Swimming.jpg" alt="Running, cycling or other challenges" class="img-responsive">
			</div>

			<div class="content">
				<h2>Running, cycling or other challenges</h2>
				<p>Apply for a charity place in one of our amazing events, or register for your own place or event to help power essential research.</p>

				<a href="http://www.alzheimersresearchuk.org/support-us/fundraise/events/" class="button external" target="_blank">Apply now</a>
				<a href="http://shop.alzheimersresearchuk.org/product-category/merchandise/" class="button external" target="_blank">Already signed up? Buy your merchandise here</a>
			</div>
		</section>
	</div>


	<!-- Mobile version -->
	<div class="container choices visible-xs">
		<div class="row">
			<ul class="col-md-12">
				<li>
					<a href="#" title="Fundraising pack" class="button active" data-panel="fundraising-pack">Fundraising pack</a>
					<section class="materials-select fundraising-pack active">
						<div class="image">
							<img src="<?php echo MOF_IMG_URL;?>step1/Fundraising-Pack.jpg" alt="Fundraising pack" class="img-responsive">
						</div>

						<div class="content">
							<h2>Fundraising pack</h2>
							<p>Be part of the fight back. Whether you want to run a bake-off or a marathon, order your fundraising pack with all you need to get started.</p>

<a id="fundraising-pack" href="https://fundraise.alzheimersresearchuk.org/" class="button" >Get your pack</a>
						</div>
					</section>
				</li>
				<li>
					<a href="#" title="Cheer Squad pack" class="button" data-panel="cheer-squad-pack">Cheer Squad pack</a>
					<section class="materials-select cheer-squad-pack">
						<div class="image">
							<img src="<?php echo MOF_IMG_URL;?>step1/Cheer-Squad.jpg" alt="Cheer Squad pack" class="img-responsive">
						</div>

						<div class="content">
							<h2>Cheer Squad pack</h2>
							<p>Everything you need to support someone's fundraising challenge! You can order up to five packs for you, your friends and family – please <a href="mailto:fundraising@alzheimersresearchuk.org">contact us</a> if you'd like more.</p>

							<a href="#" class="button internal" data-materials-select="cheer-squad-pack" data-materials-selected-title="Cheer Squad pack">Select this pack</a>
						</div>
					</section>
				</li>
				<li>
					<a href="#" title="Fundraising materials" class="button" data-panel="fundraising-materials">Fundraising materials</a>
					<section class="materials-select fundraising-materials">
						<div class="image">
							<img src="<?php echo MOF_IMG_URL;?>step1/Fundraising-Materials.jpg" alt="Fundraising materials" class="img-responsive">
						</div>

						<div class="content">
							<h2>Fundraising materials</h2>
							<p>If you have a plan for your fundraising, we can support you with a great range of fantastic materials.</p>

							<a href="#" class="button internal" data-materials-select="fundraising-materials" data-materials-selected-title="Fundraising materials">Select</a>
						</div>
					</section>
				</li>
				<li>
					<a href="#" title="Information about dementia" class="button" data-panel="dementia-info">Information about dementia</a>
					<section class="materials-select dementia-info">
						<div class="image">
							<img src="<?php echo MOF_IMG_URL;?>step1/Information-About-Dementia.jpg" alt="Information about dementia" class="img-responsive">
						</div>

						<div class="content">
							<h2>Information about dementia</h2>
							<p>Answering questions about the diagnosis and symptoms of dementia, the treatments currently available, and the risk factors for developing the condition, for personal or organisational use.</p>

							<a href="#" class="button internal" data-materials-select="dementia-info" data-materials-selected-title="Information about dementia">Select</a>
						</div>
					</section>
				</li>
				<li>
					<a href="#" title="Running, cycling or other challenges" class="button" data-panel="challenges">Running, cycling or other challenges</a>
					<section class="materials-select challenges">
						<div class="image">
							<img src="<?php echo MOF_IMG_URL;?>step1/Running-Cycling-Swimming.jpg" alt="Running, cycling or other challenges" class="img-responsive">
						</div>

						<div class="content">
							<h2>Running, cycling or other challenges</h2>
							<p>Apply for a charity place in one of our amazing events, or register for your own place or event to help power essential research.</p>

							<a href="http://www.alzheimersresearchuk.org/fundraising/sign-run-us/" class="button external" target="_blank">Running Challenges</a>
							<a href="http://www.alzheimersresearchuk.org/fundraising/sign-cycling-challenge/" class="button external" target="_blank">Cycling Challenges</a>
							<a href="http://www.alzheimersresearchuk.org/fundraising/sign-up-for-a-challenge-event/" class="button external" target="_blank">Other Challenges</a>
						</div>
					</section>
				</li>
			</ul>
		</div>
	</div>
</div>