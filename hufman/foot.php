</div>
        <div class="sb-left">
            <div class="sb-holder">
            <i class="icon icon-thumbs-up"></i> Life is fantastic
            </div>
			<ul class="sb-widget">
			    <p class="cleartext">近期文章</p>
			    <?php $this->widget('Widget_Contents_Post_Recent')->parse('<li><a href="{permalink}"><i class="icon icon-clock"></i> {title}</a></li>'); ?>
			</ul>
			<ul class="sb-widget" id="rctrly">
			    <p class="cleartext">近期评论</p>
			    <?php $this->widget('Widget_Comments_Recent')->to($comments); ?>
                <?php while($comments->next()): ?>
                    <li><a href="<?php $comments->permalink(); ?>"><i class="icon icon-comment-empty"></i> <?php $comments->author(false); ?>: <?php $comments->excerpt(35, '...'); ?></a></li>
                <?php endwhile; ?>
			</ul>
			<ul class="sb-widget">
			    <p class="cleartext">分类目录</p>
			    <?php $this->widget('Widget_Metas_Category_List')->parse('<li><a href="{permalink}"><i class="icon icon-folder"></i> {name}</a></li>'); ?>
			</ul>
        </div>
        <div class="sb-right">
            <div class="sb-holder">🥕 More</div>
            <form method="get" class="sb-widget" action="<?php $this->options->siteUrl(); ?>">
		        <input type="text" class="search" name="s" onblur="if(this.value=='')this.value='在此输入并搜索';" onfocus="if(this.value=='在此输入并搜索')this.value='';" value="在此输入并搜索">
            </form>
            <ul class="sb-widget">
                <p class="cleartext">热门</p>
                <?php
                theme_random_posts(10);
                ?>
            </ul>
            <ul class="sb-widget">
                <p class="cleartext">其它</p>
                <?php if($this->user->hasLogin()): ?>
			    	<li class="last"><a href="<?php $this->options->adminUrl(); ?>"><?php _e('后台'); ?></a></li>
                <li><a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a></li>
                <?php else: ?>
                    <li class="last"><a href="<?php $this->options->adminUrl('login.php'); ?>"><?php _e('登录'); ?></a></li>
                <?php endif; ?>
                <li><a href="<?php $this->options->feedUrl(); ?>">RSS</a></li>
            </ul>
            <?php if ($this->options->sb_right_html): ?>
            <?php $this->options->sb_right_html(); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="foot">
        <div class="backtotop"><a href="javascript:void 0"><i class="icon icon-angle-double-up"></i></a></div>
        &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>版权所有.<br />
        驱动<a href="javascript:location='http://www.typecho.org';">Typecho</a> - <a href="https://gitee.com/foxnes/tp_theme/releases">Hufman主题 <i class="icon icon-spin6 animate-spin"></i></a>
    </div>
    <script src="<?php $this->options->themeUrl('s/postbird-img-glass.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('s/lazyload.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('s/i.js'); ?>"></script>
<?php $this->footer(); ?>
</body>
</html>