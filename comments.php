<?php $this->comments()->to($comments); ?>
<?php if ($comments->have()): ?>
<?php $comments->listComments(); ?>
<?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
<?php endif; ?>

<?php if($this->allow('comment')): ?>
<div id="<?php $this->respondId(); ?>">
<form method="post" class="post" action="<?php $this->commentUrl() ?>" id="comment_form">
        <small><?php $comments->cancelReply("取消回复") ?></small>
    	<textarea resize='no' placeholder="´・ω・)ノ还不快点说点什么呀 Mua~" rows="7" name="text"><?php $this->remember('text'); ?></textarea>
    	<div class="click-show">
            <div class="show">
        	   <button type="button" class="sm">QAQ 小表情</button>
            </div>
       		<p id="showfacenamereplace" class="show-this slideB"></p>
    	</div>
    	<br />
        <?php if($this->user->hasLogin()): ?>
            <p>您已登录：<a href="<?php $this->options->adminUrl(); ?>"><?php $this->user->screenName(); ?></a>.</p>
        <?php else: ?>
	   <p class="input-g"><label><i class="fa fa-user"></i></label><input type="text" placeholder="昵称" name="author" class="text" size="25" value="<?php $this->remember('author'); ?>" /></p>
	   <p class="input-g"><label><i class="fa fa-envelope-o"></i></label><input type="email" name="mail" <?php if ($this->options->commentsRequireMail): ?>placeholder="邮箱 *" required <?php else: ?>placeholder="邮箱"<?php endif; ?>class="text" size="45" value="<?php $this->remember('mail'); ?>" /></p>
	   <p class="input-g"><label><i class="fa fa-link"></i></label><input type="url" <?php if ($this->options->commentsRequireURL): ?>required placeholder="网站 *"<?php else: ?>placeholder="网站"<?php endif; ?> name="url" class="text" size="45" value="<?php $this->remember('url'); ?>" /></p>
        <?php endif; ?>
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