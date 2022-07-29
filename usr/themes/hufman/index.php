<?php
/**
 * 仿WP的Hueman主题
 * 
 * @package Hufman
 * @author Luuljh
 * @version 0.3.9
 * @link https://github.com/foxnes
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('head.php');

$temp_show_content = false;
$temp_no_rand_thumb = false;
if (!empty($this->options->ThemeOptions) && in_array('content', $this->options->ThemeOptions))
    $temp_show_content = true;
if (!empty($this->options->ThemeOptions) && in_array('no_rand_thumb', $this->options->ThemeOptions))
    $temp_no_rand_thumb = true;
?>
<?php while($this->next()): ?>
    <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
        <?php if ($temp_show_content): ?>
        <h3 itemprop="name headline">
            <a class="post-title piece" href="<?php $this->permalink() ?>" itemprop="url"><?php $this->title() ?></a>
        </h3>
        <?php else: ?>
		<h3 class="post-title i" itemprop="name headline">
            <a href="<?php $this->permalink() ?>" itemprop="url"><?php $this->title() ?></a>
        </h3>
		<?php endif; ?>
        <div class="post-content<?php if (!$temp_show_content) echo " i" ?>" itemprop="articleBody">
            <?php
    		if ($temp_show_content):
    		    $this->content("继续阅读 / Read_more");
    		else:
    		    $hasThumb = showThumb($this, (!$temp_no_rand_thumb));
                if ($hasThumb){
                    $excerpt_limit = 210;
                }else{
                    $excerpt_limit = 300;
                }
    		    $this->excerpt($excerpt_limit, " ...");
    		endif;
    		?>
        </div>
        <div class="post-meta-i">
            <span class="a-color"><?php $this->category(' / '); ?></span>
    	    &nbsp;
    	    <i class="icon icon-clock"></i> <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time>
            <?php if (!$hasThumb): ?>
            &nbsp;
            <i class="icon icon-eye"></i>&nbsp; <?php echo getViewsStr($this); ?>
            &nbsp;
            <i class="icon icon-comment-empty"></i>&nbsp; <?php echo $this->commentsNum; ?>
            <?php endif; ?>
	        <?php if($this->user->hasLogin()): ?>
	        &nbsp;
    	    <i class="icon icon-edit"></i>  <a href="<?php $this->options->adminUrl("write-post.php?cid=".$this->cid); ?>">编辑</a>
	        <?php endif; ?>
	    </div>
    </article>
<?php endwhile; ?>

<div class="post">
    <div class="fr">
        <?php $this->pageLink('下一页 <i class="icon icon-angle-double-right"></i>','next'); ?>
    </div>
    <div class="fl">
        <?php $this->pageLink('<i class="icon icon-angle-double-left"></i> 上一页'); ?>
    </div>
        <div class="clear"></div>
</div>

<?php $this->need('foot.php'); ?>