<?php
$this->need('head.php');
?>
<div class="post">
	<?php $this->author->gravatar('60','','','post-head') ?>
	<div class="post-article">
		<div class="post-info-i">
			<h2><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>
			<small><?php $this->date('Y年m月d日'); ?><?php if($this->user->hasLogin()): ?> <a href="<?php $this->options->adminUrl("write-post.php?cid=".$this->cid); ?>">编辑</a><?php endif; ?></small>
		</div>
		<div class="post-content">
			<?php echo preg_replace("/<img(.*?)src=[\"|'](.*?)[\"|'](.*?)>/i",
			"<img$1data-original='$2'$3>",
			$this->content); ?>
			<br />
			<div class="pay">
				<span>￥打赏这个不要脸的博主</span><img style="display: none;" src="<?php if ($this->options->ewmurl): ?><?php $this->options->ewmurl(); ?><?php else:?>https://i.loli.net/2018/08/08/5b6a6e13031b1.jpg<?php endif; ?>">
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="post-meta">
		<span><i class="fa fa-user"></i><a href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a></span>
		<span><i class="fa fa-inbox"></i><?php $this->category(','); ?></span>
		<span><i class="fa fa-comment"></i><?php $this->commentsNum('%d 条'); ?></span>
		<div class="clear"></div>
	</div>
</div>

<ul class="post post-near">
	<li><?php $this->thePrev('<i class="fa fa-arrow-circle-left"></i> %s','<i class="fa fa-close"></i>'); ?></li>
	<li><?php $this->theNext('%s <i class="fa fa-arrow-circle-right"></i>','<i class="fa fa-close"></i>'); ?></li>
	<div class="clear"></div>
</ul>

<?php 
$this->need('comments.php');
$this->need('foot.php');