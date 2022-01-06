<?php
/**
* 说说页面
*
* @package custom
*/
$this->need('head.php');
?>
<div class="post">
	<p class='muted'>
		<i class="icon icon-comment-empty"></i> <?php echo $this->commentsNum; ?>
		&nbsp;
		<i class="icon icon-eye"></i> <?php echo getViewsStr($this); ?>
		<?php if($this->user->hasLogin()): ?>
		&nbsp;
		<i class="icon icon-edit"></i> <a href="<?php $this->options->adminUrl("write-page.php?cid=".$this->cid); ?>">编辑</a>
		<?php endif; ?>
	</p>
    <div class="post-content">
		<?php echo img_lazy_load($this->content); ?>
	</div>
</div>

<div class="post">
<div id='comments'>
    <?php $this->comments()->to($comments); ?>
    <?php if ($comments->have()): ?>
		<div id="says-area">
			<?php $comments->listComments(); ?>
		</div>
		<div class="clear"></div>
		<?php $comments->pageNav('&laquo;', '&raquo;'); ?>
    <?php endif; ?>

    <?php if($this->allow('comment')): ?>
		<div id="<?php $this->respondId(); ?>">
    	<form method="post" action="<?php $this->commentUrl() ?>" id="comment-form">
    	    <div>
                <label for="textarea" class="required"><i class="icon icon-comment-empty"></i> 说说</label>
                <textarea rows="4" name="text" required><?php $this->remember('text'); ?></textarea>
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
                <span class="click_board" for="showfacenamereplace">
                    <i class="tbbq bg-face_0" draggable="false" alt="😀"></i>
                </span>
                <div id="showfacenamereplace" class="hidden"></div>
            </div>
    		<p class='fr'>
                <?php $comments->cancelReply("取消回复"); ?>
                <button type="submit">提交</button>
            </p>
            <div class='clear'></div>
    	</form>
    </div>
    <?php endif; ?>

<?php function threadedComments($comments, $options) {
	$isSay = $comments->levels == 0; # 顶层是说说 子层是评论
?>
<li id="li-<?php $comments->theId(); ?>" class="comment-body<?php
if ($isSay) echo ' says-block comment-parent';
?>">
    <div id="<?php $comments->theId(); ?>">
		<span class="bold" title="author">
            <?php /* 前面的title='author'不可随意删除,用于显示`@` */ $comments->author(); ?>
        </span>
		<?php if (!$isSay){ ?>
		<span class='muted'><?php $comments->date('y年m月d日 H:i'); ?></span>
		<?php }else{ ?>
		<div class='says-float-time'><?php $comments->date('m-d'); ?></div>
		<?php } ?>
		<div class="comment-content"><?php $comments->content(); ?></div>
		<p class="fr"><?php $comments->reply("<button class=\"comment-reply\">回复</button>"); ?></p>
		<div class="clear"></div>
    </div>
<?php if ($comments->children) {
	if ($isSay) echo '<div class="comment-children">';
	$comments->threadedComments($options); ?>
	<?php
	if ($isSay) echo '</div>';
}
?>
</li>
<?php } ?>

</div>
</div> <!-- class post end -->

<script src="<?php $this->options->themeUrl('s/masonry.pkgd.min.js'); ?>"></script>
<script>
$(function(){
    var $container = $('#says-area');
	$container.masonry({
		itemSelector: '.says-block',
		isAnimated: true,
	});
	$('.comment-reply').click(function(){
		var w = $('.atcs').width() / 1.5;
		var sw = $('body').width();
		$('#comment-form').css({'position':'fixed', 'z-index': 999,
			'box-shadow': 'rgba(64, 64, 64, 0.34) 0px 0px 5px', 'border-radius': '10px',
			'width': $('.atcs').width() / 1.5,
			'left': (sw - w)/2,
			'bottom': $('#comment-form').height() / 2});
	});
	$('#cancel-comment-reply-link').click(function(){
		$('#comment-form').attr('style', '');
	});
});
</script>
<?php $this->need('foot.php'); ?>