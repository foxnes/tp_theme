<?php
/**
 * 仿WP的Hueman主题
 * 
 * @package Hufman
 * @author Luuljh
 * @version 0.3.6
 * @link https://gitee.com/foxnes
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('head.php');
?>
<?php while($this->next()): ?>
    <div class="post">
        <?php
        $temp_show_content = false;
        if (!empty($this->options->ThemeOptions) && in_array('content', $this->options->ThemeOptions)):
            $temp_show_content = true;
            ?><h3><a class="post-title piece" href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h3><?php endif; ?>
		<?php if (!$temp_show_content): ?>
		<h3 class="post-title i"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h3>
		<?php endif; ?>
        <div class="post-content<?php if (!$temp_show_content) echo " i" ?>">
            <?php
    		if ($temp_show_content):
    		    $this->content("继续阅读 / Read_more");
    		else:
    		    showThumb($this, true);
    		    $this->excerpt(210," ...");
    		endif;
    		?>
        </div>
        <div class="post-meta-i">
            <span class="a-color"><?php $this->category(' / '); ?></span>
    	    &nbsp;
    	    🕔 <time datetime="<?php $this->date('c'); ?>"><?php $this->date(); ?></time>
	        <?php if($this->user->hasLogin()): ?>
	        &nbsp;
    	    ✎  <a href="<?php $this->options->adminUrl("write-post.php?cid=".$this->cid); ?>">编辑</a>
	        <?php endif; ?>
	    </div>
    </div>
<?php endwhile; ?>

<div class="post">
    <div class="fr">
        <?php $this->pageLink('下一页 ➮','next'); ?>
    </div>
    <div class="fl">
        <?php $this->pageLink('🢠 上一页'); ?>
    </div>
        <div class="clear"></div>
</div>

<?php $this->need('foot.php'); ?>