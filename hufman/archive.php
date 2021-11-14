<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('head.php');
$randgiven = true;
if ($this->have()):?>
<?php while($this->next()): ?>
    <div class="post">
        <?php
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
    		    showThumb($this, $randgiven);
    		    $randgiven = !$randgiven;
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
    	    ✎ <a href="<?php $this->options->adminUrl("write-post.php?cid=".$this->cid); ?>">编辑</a>
	        <?php endif; ?>
	    </div>
    </div>
<?php endwhile;else: ?>

<div class="post">
        <div class="post-thumb"><img src="<?php $this->options->themeUrl('s/img/0.jpg'); ?>"></div>
    	🕔 <time><?php echo date("Y-m-d") ?></time>
	    	    &nbsp;
	    <h2>404 Error:<br />page/content not found</h2>
        <div class="post-content">
    	    Oooops, page or content not found!
    	    <hr />
    	    您要查找的页面躲起来了哦～
    	    <br />
    	    <blockquote>404页面是客户端在浏览网页时，服务器无法正常提供信息，或是服务器无法回应，且不知道原因所返回的页面。据说在第三次科技革命之前，互联网的形态就是一个大型的中央数据库，这个数据库就设置在404房间里面。那时候所有的请求都是由人工手动完成的，如果在数据库中没有找到请求者所需要的文件，或者由于请求者写错了文件编号，用户就会得到一个返回信息：room 404 : file not found。404错误信息通常是在目标页面被更改或移除，或客户端输入页面地址错误后显示的页面，人们也就习惯了用404作为服务器未找到文件的错误代码了。当然实际考证传说中的room 404是不存在的，在http请求3位的返回码中，4开头的代表客户错误，5开头代表服务器端错误。</blockquote>
    	</div>
</div>

<?php endif; ?>

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