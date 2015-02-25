<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package landscape
 */
?>

</div><!-- #main .site-main -->
</div><!-- #page .hfeed .site -->
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'landscape_credits' ); ?>
			Written with love
			<span class="sep"> | </span>
			<span class="fuck-coding">Because fuck code</span>
		</div><!-- .site-info -->
	</footer><!-- #colophon .site-footer -->


<?php wp_footer(); ?>

</body>
</html>