<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Toolbox
 * @since Toolbox 0.1
 */
?>
	</div>

	<footer id="colophon" role="contentinfo">
		<?php dynamic_sidebar('footer'); ?>
		<aside>
			<p class="cc-by-nc-sa">Dieser Inhalt steht unter einer <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/" rel="license">Creative Commons BY-NC-SA</a> Lizenz.</p>	
			<p><a href="http://wordpress.org/" rel="generator">WordPress</a></p>
			<p><a href="https://github.com/neapel/wp-theme-green" rel="designer">Theme</a> basiert auf <a href="http://automattic.com/" rel="designer">Toolbox</a></p>
		</aside>
	</footer>
</div>

<?php wp_footer(); ?>

</body>
</html>
