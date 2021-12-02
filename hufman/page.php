<?php
$this->need('head.php');
?>
<div class="post">
	<h1 class="post-title"><?php $this->title() ?></h1>
	<p class='muted'>
		<i class="icon icon-clock"></i> <time datetime="<?php $this->date('Y-m-d'); ?>"><?php $this->date('Y-m-d'); ?></time>
		&nbsp;
		<i class="icon icon-comment-empty"></i> 评论 <?php echo $this->commentsNum; ?>
		&nbsp;
		<i class="icon icon-eye"></i> 热度 <?php echo getViewsStr($this); ?>
		<?php if($this->user->hasLogin()): ?>
		&nbsp;
		<i class="icon icon-edit"></i> <a href="<?php $this->options->adminUrl("write-post.php?cid=".$this->cid); ?>">编辑</a>
		<?php endif; ?>
	</p>
	<hr />
    <div class="post-content">
		<?php echo img_lazy_load($this->content); ?>
    </div>
</div>

<div class="post">
    <?php $this->need('comments.php'); ?>
</div>

<?php $this->need('foot.php'); ?>