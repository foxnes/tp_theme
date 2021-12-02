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
		<?php echo img_lazy_load($this->content) ?>
		<div class="post-meta">
		    <p>该本文由 <a href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a> 创作或转载
			<br />采用 <a href="//creativecommons.org/licenses/by/3.0/cn" rel="nofollow">知识共享署名 3.0</a>，可自由转载、引用，但需署名作者且注明文章出处。</p>
		</div>
    </div>
    <ul class="post-nav">
        <div class="tags fr">
            标签: <?php $this->tags('', true, '无'); ?>
        </div>
        <li>上一篇: <?php $this->thePrev('%s','没有了'); ?></li>
        <li>下一篇: <?php $this->theNext('%s','没有了'); ?></li>
    </ul>
</div>

<div class="post">
    <?php $this->need('comments.php'); ?>
</div>

<?php $this->need('foot.php'); ?>