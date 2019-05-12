</div><!-- .article-list -->
<div class="clear"></div>
</div><!-- .body -->

<div class="foot">
	&copy; <?php echo date("Y"); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a>.
	<?php if ($this->options->beian){$this->options->beian();echo ". ";} ?>
	Powered By <a onclick="window.open('http://typecho.org/');" href="javascript:void 0">Typecho</a> &amp; Theme <a href="https://github.com/1443691826/vblog/" target="_blank">Vblog</a>.
	<?php if ($this->options->footcode): ?><?php $this->options->footcode(); ?><?php endif; ?>
</div>

<div id="gotop" onclick="window.scrollTo(0,0)"><i class="fa fa-arrow-up"></i></div>

<?php
$this->footer();
?>

<div id="zooming"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAC0lEQVQYV2NgAAIAAAUAAarVyFEAAAAASUVORK5CYII="></div>

<script type="text/javascript">
$(function(){
	var rdimgurl = "<?php if ($this->options->sidebarrandomimg): ?><?php $this->options->sidebarrandomimg(); ?><?php else: ?>https://picsum.photos/276/300/?random<?php endif; ?>";
	try{
		randomimg.src = rdimgurl;
	}catch(e){}
});
</script>

</body>
</html>