<div class="error">
	<p>WordPress Radio error: Your environment doesn't meet all of the system requirements listed below.</p>
	
	<ul class="ul-disc">
		<li><strong>PHP <?php echo WPR_REQUIRE_PHP; ?>+</strong>
			<em>(You're running version <?php echo PHP_VERSION; ?>)</em></li>
		<li><strong>WordPress <?php echo WPR_REQUIRE_WP; ?>+</strong>
			<em>(You're running version <?php echo esc_html( $wp_version ); ?>)</em></li>
		<?php //<li><strong>Plugin XYZ</strong> activated</em></li> ?>
	</ul>

	<p>If you need to upgrade your version of PHP you can ask your hosting company for assistance, and if you need help upgrading WordPress you can refer to <a href="http://codex.wordpress.org/Upgrading_WordPress">the Codex</a>.</p>
</div>