<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div id="comments">
    <?php $this->comments()->to($comments); ?>
    <?php if ($comments->have()): ?>
	<h3 class="thin"><?php $this->commentsNum(_t('暂无评论'), _t('一条评论'), _t('%d 条评论')); ?></h3>
    <?php $comments->listComments(); ?>
    <?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
    <?php endif; ?>

    <?php if($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="respond">
        <div class="cancel-comment-reply">
        <?php $comments->cancelReply(); ?>
        </div>

    	<form method="post" action="<?php $this->commentUrl() ?>" id="comment-form">
    	    <p>
                <label for="textarea" class="required">内容</label>
                <textarea rows="8" cols="50" name="text" class="textarea" required ><?php $this->remember('text'); ?></textarea>
            </p>
            <div id="showfacenamereplace"></div>
            <?php if($this->user->hasLogin()): ?>
    		<p>&nbsp;登录身份: <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout">退出 &raquo;</a></p>
            <?php else: ?>
    		<p class="half w">
                <label for="author" class="required">称呼 <b class="warning-blue">*</b></label>
    			<input type="text" name="author" class="text" value="<?php $this->remember('author'); ?>" required />
    		</p>
    		<p class="half w">
                <label for="mail"<?php if ($this->options->commentsRequireMail): ?> class="required"<?php endif; ?>>Email <?php if ($this->options->commentsRequireMail): ?> <b class="warning-blue">*</b><?php endif; ?></label>
    			<input type="email" name="mail" class="text" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
    		</p>
    		<div class="clear"></div>
    		<p>
                <label for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?>>网站<?php if ($this->options->commentsRequireURL): ?> <b class="warning-blue">*</b><?php endif; ?></label>
    			<input type="url" name="url" id="url" class="text" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
    		</p>
            <?php endif; ?>
    		<p>
                <button type="submit" class="submit">提交评论</button>
            </p>
    	</form>
    </div>
    <?php else: ?>
    <h3>评论已关闭</h3>
    <?php endif; ?>
</div>


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
            <?php $comments->gravatar('45', ''); ?>
            <div class="comment-meta">
            <span class="a-color"><?php $comments->author(); ?></span> <span class="comment-reply"><?php $comments->reply("回复"); ?></span><br />
            <i class="fa fa-clock-o tiny"></i> <?php $comments->date('Y-m-d H:i'); ?>
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