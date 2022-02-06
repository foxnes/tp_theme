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
		<i class="icon icon-comment-empty"></i> 现有说说<?php echo $this->commentsNum; ?>条
		&nbsp;
		<i class="icon icon-eye"></i> 围观<?php echo getViewsStr($this); ?>次
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
		<span class='muted'><?php $comments->date('y-m-d H:i'); ?></span>
		<?php }else{ ?>
		<div class='says-float-time'><?php $comments->date('m-d'); ?></div>
		<?php } ?>
		<div class="comment-content"><?php $comments->content(); ?>
		<?php $comments->reply("<button class=\"comment-reply\">回复</button>"); ?></div>
		
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
	var says_msnry = new Masonry($('#says-area')[0], {
		itemSelector: '.says-block',
		isAnimated: true,
	}); // msnry.layout();
	$('.comment-content img').on('load', function(){
		says_msnry.layout();
	})
	$('.comment-reply').click(function(){
		$('#comment-form').css({'z-index': 999, 'border-radius': '5px', 'box-shadow': 'rgba(64, 64, 64, 0.34) 0px 0px 5px'});
		if ($(window).width() < 920) {
			var w = $('.atcs').width()*0.8;
			var sw = $('body').width();
			$('#comment-form').css({'position':'fixed', 'width': w,
				'left': (sw - w)/2, 'bottom': $('#comment-form').height()/2});
		}else{
			$('#comment-form').css({
				'position':'absolute', 'min-width': '28rem'
			});
		}
	});
	$('#cancel-comment-reply-link').click(function(){
		$('#comment-form').css({'position':'static', 'box-shadow': 'none', 'left': 'auto', 'bottom': 'auto',
			'border-radius': 0, 'width': 'auto'});
	});
});
</script>
<?php $this->need('foot.php'); ?>