<?php
/**
 * 仿WP的Hueman主题
 * 
 * @package Hufman
 * @author Luuljh
 * @version 0.3
 * @link http://he-he.gq
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('head.php');
?>
<?php while($this->next()): ?>
    <div class="post">
        <a href="<?php $this->permalink() ?>">
            <?php showThumb($this) ?>
        </a>
	    <span class="a-color"><?php $this->category(' / '); ?></span>
    	&nbsp;
    	<i class="fa fa-clock-o" aria-hidden="true"></i> <time datetime="<?php $this->date('c'); ?>"><?php $this->date(); ?></time>
	    <?php if($this->user->hasLogin()): ?>
	    &nbsp;
    	<i class="fa fa-pencil-square-o" aria-hidden="true"></i> <a href="<?php $this->options->adminUrl("write-post.php?cid=".$this->cid); ?>">编辑</a>
	    <?php endif; ?>
		<h3 class="post-title"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h3>
        <div class="post-content i">
    		<?php $this->excerpt(200,"..."); ?>
        </div>
    </div>
<?php endwhile; ?>

<div class="post mg">
    <div class="fr">
        <?php $this->pageLink('下一页 <i class="fa fa-angle-double-right" aria-hidden="true"></i>','next'); ?>
    </div>
    <div class="fl">
        <?php $this->pageLink('<i class="fa fa-angle-double-left" aria-hidden="true"></i> 上一页'); ?>
    </div>
        <div class="clear"></div>
</div>

<?php $this->need('foot.php'); ?>