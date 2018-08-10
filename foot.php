</div><!-- .article-list -->
<div class="clear"></div>
</div><!-- .body -->

<div class="foot">
	&copy; <?php echo date("Y"); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a>.
	<?php if ($this->options->beian){$this->options->beian();echo ". ";} ?>
	Powered By <a href="http://typecho.org/">Typecho</a> &amp; Theme <a href="http://blog.lljh.bid">Vblog</a>.
	<?php if ($this->options->footcode): ?><?php $this->options->footcode(); ?><?php endif; ?>
	<!-- 请勿删除主题版权，谢谢合作！ -->
</div>

<div id="gotop" onclick="window.scrollTo(0,0)"><i class="fa fa-arrow-up"></i></div>

<?php
$this->footer();
?>

<script src="//code.jquery.com/jquery-1.8.3.js" crossorigin="anonymous"></script>
<script src="<?php $this->options->themeUrl('s/jquery.slimscroll.js'); ?>"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl('s/qrcode.min.js'); ?>"></script>
<script type="text/javascript" src="//apps.bdimg.com/libs/jquery-lazyload/1.9.5/jquery.lazyload.min.js"></script>
<script charset="UTF-8" src="<?php $this->options->themeUrl('s/i.js'); ?>"></script>

<div id="zooming"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAC0lEQVQYV2NgAAIAAAUAAarVyFEAAAAASUVORK5CYII="></div>

<script type="text/javascript">
window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"16"},"share":{"bdSize":16}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
window.onload=function(){
	myrandomimg = "<?php if ($this->options->sidebarrandomimg): ?><?php $this->options->sidebarrandomimg(); ?><?php else: ?>https://picsum.photos/276/300/?random<?php endif; ?>";
	randomimg.src=myrandomimg;
}
</script>

</body>
</html>