<div class="box">
<div class="box-body">
	<div class="clear"></div>
	<div class="huaji-half">
		<span class="icon-yellow"><strong>V</strong> 博客认证</span>
	</div>
	<div class="huaji-half">
		<span class="icon-red"><i>LV.8848</i></span>
	</div>
	<div class="clear"></div>
	<hr />
	<ul class="li-haf-border">
	<?php if ($this->options->selfidt): ?><?php $this->options->selfidt();else: ?>
	<li><i class="fa fa-thumbs-up"></i> 咯咯哒咯咯哒~ (๑•̀ㅂ•́)و✧</li>
	<li><i class="fa fa-home"></i> 老家：火星</li>
	<li><i class="fa fa-info"></i> 爱好：睡觉、敲代码</li>
	<li><i class="fa fa-birthday-cake"></i> 生日：8102年13月52日</li>
	<li><i class="fa fa-edit"></i> 简介：欢迎！我白天是个邮递员，晚上就是个有抱负的演员。这是我的博客。我住在天朝的帝都，有条叫做杰克的狗。--滑稽的简介</li>
	<?php endif; ?>
	</ul>
</div>
</div>
<div class="sidebar-mb-show">
	<div class="box sidebar-readmore" onclick="$('.sidebar-pc-show').slideToggle(400);">
		<div class="box-body"><stonrg>- 更多 -</stonrg></div>
	</div>
</div>
<div class="sidebar-pc-show">
<div class="box"></div>
<?php if (!empty($this->options->sidebarBlock) && in_array('my_reader', $this->options->sidebarBlock)): ?>
	<div class="box">
	<b><i class="fa fa-user-o"></i> 我的读者</b>
	<div class="box-body">
		<?php echo getFriendWall();?>
		<span title="凑数机器人"><img class="avatar" data-original="//1.gravatar.com/avatar/5dd75e92f802b1ac87b2132542b32e1b?s=24&amp;d=&amp;r=G"></span><span title="凑数机器人"><img class="avatar" data-original="//1.gravatar.com/avatar/d7a973c7dab26985da5f961be7b74480?s=24&amp;d=&amp;r=G"></span><span title="凑数机器人"><img class="avatar" data-original="//1.gravatar.com/avatar/800db8558398890a3232e4ffbdbdda52?s=24&amp;d=&amp;r=G"></span><span title="凑数机器人"><img class="avatar" data-original="//1.gravatar.com/avatar/144fbd313b60fdf0ba3136855b054ba4?s=24&amp;d=&amp;r=G"></span>
	    <div class="clear"></div>
	</div>
	</div>
<?php endif;
if (!empty($this->options->sidebarBlock) && in_array('random_img', $this->options->sidebarBlock)): ?>
	<div class="box">
	<b><i class="fa fa-file-image-o"></i> 随机图片</b>
	<div class="box-body box-loading">
		<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAC0lEQVQYV2NgAAIAAAUAAarVyFEAAAAASUVORK5CYII=" id="randomimg" alt="随机图片" onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAC0lEQVQYV2NgAAIAAAUAAarVyFEAAAAASUVORK5CYII=';">
	</div>
	</div>
<?php
endif; if ($this->is('post')) {$ispostpage = true;}else{$ispostpage = false;} ?>
	<div class="box">
	<b><i class="fa fa-tags"></i><?php if ($ispostpage): echo " 文章标签";else: echo " 我的标签";endif; ?></b>
	<div class="box-body">
		<?php if (!$ispostpage):?>
		<?php $this->widget('Widget_Metas_Tag_Cloud', 'sort=mid&ignoreZeroCount=1&desc=0&limit=45')->to($tags); ?>
		<?php if($tags->have()): ?>
		<?php while ($tags->next()): ?><a href="<?php $tags->permalink(); ?>" rel="tag" title="<?php $tags->count(); ?> 个话题"><?php $tags->name(); ?></a><?php endwhile; ?><?php else: ?><a href="#" rel="tag">没有</a><a href="#" rel="tag">任何</a><a href="#" rel="tag">标签</a><?php endif;

		else: ?>
		<div class="tagsshow"><?php $this->tags('', true, '<a>可爱的标签们~</a><a>w(゜Д゜)w</a><a>无任何标签</a>'); ?></div>
		<?php endif; ?>
	</div>
	</div>
<?php if (!empty($this->options->sidebarBlock) && in_array('all_comments', $this->options->sidebarBlock)): ?>
	<div class="box">
	<b><i class="fa fa-commenting-o"></i> 最新评论</b>
	<div class="box-body">
		<ul class="li-el sidebar-reply-li">
		<?php $this->widget('Widget_Comments_Recent','pageSize=8')->to($comments); ?>
  	    <?php while($comments->next()): ?>
     	    <li><?php $comments->gravatar(40); ?>
     	    <p>
     	   		<b><?php $comments->author(); ?></b>
     	    	<a href="<?php $comments->permalink(); ?>"><?php $comments->excerpt(25, '...'); ?></a>
     	    </p>
     	    </li>
    	<?php endwhile; ?>
    	<div class="clear"></div>
		</ul>
	</div>
	</div>
<?php endif; ?>
	<div class="box">
	<b><i class="fa fa-link"></i> 友情链接</b>
	<div class="box-body tagsshow">
		<ul>
			<?php if ($this->options->link): ?><?php $this->options->link(); ?><?php else: echo '<a href="http://blog.lljh.bid">Luuljh的博客</a>'; endif; ?>
		</ul>
		<div class="clear"></div>
	</div>
	</div>
<?php if (!empty($this->options->sidebarBlock) && in_array('random_article', $this->options->sidebarBlock)): ?>
	<div class="box" id="randomarticle_b">
	<b><i class="fa fa-file-o"></i> 随机文章</b>
	<div class="box-body">
		<ul class="li-el"><?php getRandomPosts(10);?></ul>
	</div>
	</div>
<?php endif; ?>
</div>