<?php
$this->need('head.php');
?>
<div class="post">
    <h1 class="post-title"><?php $this->title() ?></h1>
	<i class="fa fa-clock-o" aria-hidden="true"></i> <time datetime="<?php $this->date('c'); ?>"><?php $this->date(); ?></time>
	&nbsp;
	<i class="fa fa-comment-o" aria-hidden="true"></i> <?php echo $this->commentsNum; ?>
	&nbsp;
	<i class="fa fa-eye"></i> <?php echo getViewsStr($this); ?>
	<?php if($this->user->hasLogin()): ?>
	&nbsp;
	<i class="fa fa-pencil-square-o" aria-hidden="true"></i> <a href="<?php $this->options->adminUrl("write-post.php?cid=".$this->cid); ?>">编辑</a>
	<?php endif; ?>
	<hr />
    <div class="post-content">
		<?php $this->content(); ?>
    </div>
</div>

<div class="post">
    <?php $this->need('comments.php'); ?>
</div>

<?php $this->need('foot.php'); ?><?php
