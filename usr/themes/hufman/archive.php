<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('head.php');
$temp_no_rand_thumb = false;
if (!empty($this->options->ThemeOptions) && in_array('no_rand_thumb', $this->options->ThemeOptions))
    $temp_no_rand_thumb = true;
if ($this->have()):?>
<?php while($this->next()): ?>
    <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
		<h3 class="post-title i" itemprop="name headline">
			<a href="<?php $this->permalink() ?>" itemprop="url" ><?php $this->title() ?></a>
		</h3>
        <div class="post-content i" itemprop="articleBody">
		<?php
			$hasThumb = showThumb($this, (!$temp_no_rand_thumb));
			if ($hasThumb){
				$excerpt_limit = 210;
			}else{
				$excerpt_limit = 300;
			}
			$this->excerpt($excerpt_limit, " ...");
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
	        <?php if($this->user->hasLogin()): ?>
	        &nbsp;
    	    <i class="icon icon-edit"></i> <a href="<?php $this->options->adminUrl("write-post.php?cid=".$this->cid); ?>">编辑</a>
	        <?php endif; ?>
            <?php endif; ?>
	    </div>
    </article>
<?php endwhile;else: ?>

<div class="post">
	<i class="icon icon-clock"></i> <time><?php echo date("Y-m-d") ?></time>
	<h1>Error 404: <br />page or content not found</h1>
	<div class="post-content">
		<p>
		Oooops, an error occurred.
		<p>
		<hr />
		您要查找的页面不存在了。
		<br />
		<p>404页面是客户端在浏览网页时，服务器无法正常提供信息，或是服务器无法回应，且不知道原因所返回的页面。</p>
		<p>据说在第三次科技革命之前，互联网的形态就是一个大型的中央数据库，这个数据库就设置在404房间里面。
		那时候所有的请求都是由人工手动完成的，如果在数据库中没有找到请求者所需要的文件，或者由于请求者写错了文件编号，用户就会得到一个返回信息："room 404: file not found"。
		404错误信息通常是在目标页面被更改或移除，或客户端输入页面地址错误后显示的页面，人们也就习惯了用404作为服务器未找到文件的错误代码了。</p>
		<p>当然实际考证传说中的room 404是不存在的，在http请求3位的返回码中，4开头的代表客户错误，5开头代表服务器端错误。</p>
	</div>
</div>

<?php endif; ?>

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