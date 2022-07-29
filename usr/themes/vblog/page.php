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
			<?php if($this->user->hasLogin()): ?> <a href="<?php $this->options->adminUrl("write-page.php?cid=".$this->cid); ?>"><i class="fa fa-pencil-square-o"></i>编辑</a><?php endif; ?></small>
		</div>
		<div class="post-content">
	    	<?php echo img_lazy_load($this->content); ?>
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