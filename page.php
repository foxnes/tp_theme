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
		</div>
	</div>
	<div class="clear"></div>
	<div class="post-meta">
		<span style="width: 50%"><i class="fa fa-user"></i><a href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a></span>
	    <span style="width: 50%"><i class="fa fa-comment"></i><?php $this->commentsNum('%d 条'); ?></span>
	    <div class="clear"></div>
	</div>
</div>

<?php 
$this->need('comments.php');
$this->need('foot.php');