<?php $this->comments()->to($comments); ?>
<?php if ($comments->have()): ?>
<?php $comments->listComments(); ?>
<?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
<?php endif; ?>

<?php if($this->allow('comment')): ?>
<div id="<?php $this->respondId(); ?>" class="respond">
<form method="post" class="post" action="<?php $this->commentUrl() ?>" id="comment_form">
    <h4> - 评论 -</h4>
    <small>
        <?php $comments->cancelReply(); ?>
    </small>
    <hr />
        <?php if($this->user->hasLogin()): ?>
            <p>您已登录：<a href="<?php $this->options->adminUrl(); ?>"><?php $this->user->screenName(); ?></a>.</p>
        <?php else: ?>
	   <p><label>昵称：</label><input type="text" placeholder="君の名は" name="author" class="text" size="35" value="<?php $this->remember('author'); ?>" /></p>
	   <p><label>邮箱：</label><input type="email" name="mail" <?php if ($this->options->commentsRequireMail): ?>required placeholder="必须填写邮箱"<?php endif; ?> class="text" size="35" value="<?php $this->remember('mail'); ?>" /></p>
	   <p><label>网站：</label><input type="url" <?php if ($this->options->commentsRequireURL): ?>required placeholder="必须填写网站" <?php endif; ?> name="url" class="text" size="35" value="<?php $this->remember('url'); ?>" /></p>
        <?php endif; ?>
        <p id="showfacenamereplace"></p>
	 	<p><textarea resize='no' placeholder="轻点儿 QAQ" rows="10" cols="50" name="text"><?php $this->remember('text'); ?></textarea></p>
	 	<p><input type="submit" value="准备发射~" class="form_submit" /></p>
</form>
</div>
<?php endif; ?>


<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }
 
    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
?>
 
<li id="li-<?php $comments->theId(); ?>" class="comment-body<?php 
if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
} else {
    echo ' comment-parent';
}
$comments->alt(' comment-odd', ' comment-even');
echo $commentClass;
?>">
    <div id="<?php $comments->theId(); ?>">
        <div class="comment-author">
            <?php $comments->gravatar('35', ''); ?>
            <div class="comment-meta">
            <?php $comments->author(); ?> <span class="comment-reply"><?php $comments->reply("回复"); ?></span><br />
            <small><?php $comments->date('Y-m-d H:i'); ?></small>
        	</div>
        </div>
        <?php $comments->content(); ?>
    </div>
<?php if ($comments->children) { ?>
    <div class="comment-children">
        <?php $comments->threadedComments($options); ?>
    </div>
<?php } ?>
</li>
<?php } ?>