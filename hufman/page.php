<?php
$this->need('head.php');
?>
<div class="post">
    <h1 class="post-title"><?php $this->title() ?></h1>
	🕔 <time datetime="<?php $this->date('c'); ?>"><?php $this->date(); ?></time>
	&nbsp;
	💬 <?php echo $this->commentsNum; ?>
	&nbsp;
	👁 <?php echo getViewsStr($this); ?>
	<?php if($this->user->hasLogin()): ?>
	&nbsp;
	✎ <a href="<?php $this->options->adminUrl("write-page.php?cid=".$this->cid); ?>">编辑</a>
	<?php endif; ?>
	<hr />
    <div class="post-content">
		<?php echo img_lazy_load($this->content); ?>
    </div>
</div>

<div class="post">
    <?php $this->need('comments.php'); ?>
</div>

<?php $this->need('foot.php'); ?>