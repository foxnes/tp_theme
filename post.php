<?php
$this->need('head.php');
?>
<div class="post">
	<img class="post-head" src="<?php if ($this->options->face): ?><?php $this->options->face();else:echo "https://cn.gravatar.com/avatar/".md5($this->author->mail)."?s=64&d=&r=X";endif; ?>" />
	<div class="post-article">
		<div class="post-info-i">
			<h2><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>
			<small><i class="fa fa-clock-o"></i><?php $this->date('Y年m月d日'); ?>
			<?php if (!empty($this->options->sidebarBlock) && in_array('df_views', $this->options->sidebarBlock)): ?><i class="fa fa-eye"></i><?php _e(getViewsStr($this));endif ?>
			<?php if($this->user->hasLogin()): ?> <a href="<?php $this->options->adminUrl("write-post.php?cid=".$this->cid); ?>"><i class="fa fa-pencil-square-o"></i>编辑</a><?php endif; ?></small>
		</div>
		<div class="post-content">
			<?php echo img_lazy_load($this->content); ?>
			<?php if ($this->options->ewmurl): ?>
			<br />
			<div class="pay">
				<span>￥打赏这个不要脸的博主</span><img style="display: none;" src="<?php $this->options->ewmurl(); ?>">
			</div>
			<?php endif; ?>
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