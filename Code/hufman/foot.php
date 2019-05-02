</div>
        <div class="sb-left">
            <div class="sb-holder">
                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;&nbsp;Life is fantastic
            </div>
			<ul class="sb-widget">
			    <p class="tinytext">近期文章</p>
			    <?php $this->widget('Widget_Contents_Post_Recent')->parse('<li><a href="{permalink}"><i class="fa fa-clock-o" aria-hidden="true"></i> {title}</a></li>'); ?>
			</ul>
			<ul class="sb-widget" id="rctrly">
			    <p class="tinytext">近期评论</p>
			    <?php $this->widget('Widget_Comments_Recent')->to($comments); ?>
                <?php while($comments->next()): ?>
                    <li><a href="<?php $comments->permalink(); ?>"><i class="fa fa-comment-o" aria-hidden="true"></i> <?php $comments->author(false); ?>: <?php $comments->excerpt(35, '...'); ?></a></li>
                <?php endwhile; ?>
			</ul>
			<ul class="sb-widget">
			    <p class="tinytext">文章归档</p>
                <?php $this->widget('Widget_Contents_Post_Date', 'type=year&format=Y')->parse('<li><a href="{permalink}"><i class="fa fa-calendar" aria-hidden="true"></i> {date}</a></li>'); ?>
			</ul>
			<ul class="sb-widget">
			    <p class="tinytext">分类目录</p>
			    <?php $this->widget('Widget_Metas_Category_List')->parse('<li><a href="{permalink}"><i class="fa fa-folder-open-o" aria-hidden="true"></i> {name}</a></li>'); ?>
			</ul>
        </div>
        <div class="sb-right">
            <div class="sb-holder">More</div>
            <form method="get" class="sb-widget" action="<?php $this->options->siteUrl(); ?>">
		        <input type="text" class="search" name="s" onblur="if(this.value=='')this.value='在此输入并搜索';" onfocus="if(this.value=='在此输入并搜索')this.value='';" value="在此输入并搜索">
            </form>
            <ul class="sb-widget">
                <p class="tinytext">页面</p>
                <li><a href="<?php $this->options->siteUrl() ?>" title="<?php $this->options->title(); ?>">首页</a></li>
                <?php $this->widget('Widget_Contents_Page_List')->to($pages);while($pages->next()): ?>
                <li><a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a></li>
                <?php endwhile; ?>
            </ul>
            <ul class="sb-widget">
                <p class="tinytext">其它</p>
                <?php if($this->user->hasLogin()): ?>
			    	<li class="last"><a href="<?php $this->options->adminUrl(); ?>"><?php _e('后台'); ?> (<?php $this->user->screenName(); ?>)</a></li>
                <li><a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a></li>
                <?php else: ?>
                    <li class="last"><a href="<?php $this->options->adminUrl('login.php'); ?>"><?php _e('登录'); ?></a></li>
                <?php endif; ?>
                <li><a href="<?php $this->options->feedUrl(); ?>">RSS</a></li>
            </ul>
        </div>
    </div>
    <div class="foot">
        <div class="backtotop"><a href="javascript:void 0"><i class="fa fa-angle-up"></i></a></div>
        &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>版权所有.<br />
        驱动<a href="javascript:location='http://www.typecho.org';">Typecho</a> - <a href="https://github.com/1443691826/tp_theme">Hufman主题</a>
    </div>
    <script src="//code.jquery.com/jquery-1.8.3.min.js"></script>
    <script src="<?php $this->options->themeUrl('s/postbird-img-glass.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('s/lazyload.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('s/i.js'); ?>"></script>
<?php $this->footer(); ?>
</body>
</html>