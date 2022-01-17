<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div id="comments">
    <?php $this->comments()->to($comments); ?>
    <?php if ($comments->have()): ?>
	<p class="thin ct">评论区 - <?php $this->commentsNum(_t('暂无评论'), _t('一条评论'), _t('%d 条评论')); ?></p>
    <?php $comments->listComments(); ?>
    <?php $comments->pageNav('&laquo;', '&raquo;'); ?>
    <?php endif; ?>

    <?php if($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="respond">
    	<form method="post" action="<?php $this->commentUrl() ?>" id="comment-form">
    	    <div>
                <label for="textarea" class="required"><i class="icon icon-comment-empty"></i> 评论</label>
                <?php if($this->user->hasLogin()): ?>
    		        <div class='muted'>登录身份: <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>.</div>
                <?php endif; ?>
                <textarea rows="4" name="text" class="textarea" required placeholder='总想说点什么...'><?php $this->remember('text'); ?></textarea>
            </div>

            <?php if(!$this->user->hasLogin()): ?>
    		<p class="half w">
                <label for="author" class="required"><i class="icon icon-child"></i> 昵称 <b class="warning-blue">*</b></label>
    			<input type="text" name="author" class="text" value="<?php $this->remember('author'); ?>" required />
    		</p>
    		<p class="half w">
                <label for="mail"<?php if ($this->options->commentsRequireMail): ?> class="required"<?php endif; ?>><i class="icon icon-mail"></i> 邮箱 <?php if ($this->options->commentsRequireMail): ?> <b class="warning-blue">*</b><?php endif; ?></label>
    			<input type="email" name="mail" class="text" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> placeholder='可QQ邮箱' />
    		</p>
    		<div class="clear"></div>
    		<p>
                <label for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?>><i class="icon icon-link"></i> 网站<?php if ($this->options->commentsRequireURL): ?> <b class="warning-blue">*</b><?php endif; ?></label>
    			<input type="url" name="url" id="url" class="text" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
    		</p>
            <?php endif; ?>
            <div class="click_to_show fl">
                <span class="click_board" for="showfacenamereplace_tbbq">
                    <i class="emojis tbbq tbbq-face_0" draggable="false" alt="😀"></i>
                </span>
                <div id="showfacenamereplace_tbbq" class="hidden"></div>
            </div>
            <div class="click_to_show fl">
                <span class="click_board" for="showfacenamereplace_wpbq">
                    <i class="emojis wpbq wpbq-face_15" draggable="false" alt="😀"></i>
                </span>
                <div id="showfacenamereplace_wpbq" class="hidden"></div>
            </div>
    		<p class='fr'>
                <?php $comments->cancelReply("取消回复"); ?>
                <button type="submit">提交评论</button>
            </p>
            <div class='clear'></div>
    	</form>
    </div>
    <?php else: ?>
    <h3>评论已关闭</h3>
    <?php endif; ?>
</div>


<?php function threadedComments($comments, $options) {
    $isAuthorClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $isAuthorClass .= 'comment-by-author';
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
?>">
    <div id="<?php $comments->theId(); ?>" class="<?php echo $isAuthorClass; ?>">
        <img class="avatar" src="<?php 
        // $comments->gravatar('55', '');
        _e(get_gravatar($comments->mail));
        ?>" alt="Gravatar" width="55" height="55">

        <div class="comment-right">
            <p><span class="bold" title="author">
                <?php /* 前面的title='author'不可随意删除,用于显示`@` */ $comments->author(); ?>
            </span>
                <span class="muted"><?php getOs($comments->agent); ?>&nbsp;·&nbsp;<?php getBrowser($comments->agent); ?></span>
            </p>
            <p class='muted'><?php $comments->date('Y年m月d日 H:i'); ?></p>
            <div class="comment-content"><?php $comments->content(); ?></div>
            <?php $comments->reply("<button class=\"comment-reply\">回复</button>"); ?>
        </div>
    </div>
<?php if ($comments->children) { ?>
    <div class="comment-children">
        <?php $comments->threadedComments($options); ?>
    </div>
<?php } ?>
</li>
<?php } ?>