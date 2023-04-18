    </div> <!-- .atcs -->
        <div class="sb-left">
            <div class="sb-holder">
            <i class="icon icon-thumbs-up"></i> Life is fantastic
            </div>
			<ul class="sb-widget">
			    <p class="cleartext">近期文章 / Posts</p>
			    <?php $this->widget('Widget_Contents_Post_Recent')->parse('<li><a href="{permalink}"><i class="icon icon-clock"></i> {title}</a></li>'); ?>
			</ul>
			<ul class="sb-widget" id="rctrly">
			    <p class="cleartext">近期评论 / Comments</p>
			    <?php $this->widget('Widget_Comments_Recent_theme')->to($comments); ?>
                <?php while($comments->next()): ?>
                    <li><a href="<?php $comments->permalink(); ?>" rel="nofollow"><i class="icon icon-comment-empty"></i> <?php $comments->author(false); ?>: <?php $comments->excerpt(35, '...'); ?></a></li>
                <?php endwhile; ?>
			</ul>
			<ul class="sb-widget">
			    <p class="cleartext">分类目录 / Cate</p>
			    <?php $this->widget('Widget_Metas_Category_List')->parse('<li><a href="{permalink}"><i class="icon icon-folder"></i> {name}</a></li>'); ?>
			</ul>
        </div>
        <div class="sb-right">
            <div class="sb-holder">🥕 More</div>
            <form method="get" class="sb-widget" action="<?php $this->options->siteUrl(); ?>">
		        <input type="text" class="search" name="s" onblur="if(this.value=='')this.value='在此输入并搜索';" onfocus="if(this.value=='在此输入并搜索')this.value='';" value="在此输入并搜索">
            </form>
            <ul class="sb-widget">
                <p class="cleartext">热门 / Hot</p>
                <?php theme_hot_posts(10); ?>
            </ul>

            <ul class="sb-widget">
            <p class="cleartext">归档 / Arch</p>
                <?php \Widget\Contents\Post\Date::alloc('type=month&format=F Y')->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
            </ul>


            <ul class="sb-widget">
                <p class="cleartext">其它 / Other</p>
                <?php if($this->user->hasLogin()): ?>
			    	<li class="last"><a href="<?php $this->options->adminUrl(); ?>"><?php _e('后台'); ?></a></li>
                <li><a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a></li>
                <?php else: ?>
                    <li class="last"><a href="<?php $this->options->adminUrl('login.php'); ?>" rel="nofollow"><?php _e('登录'); ?></a></li>
                <?php endif; ?>
                <li><a href="<?php $this->options->feedUrl(); ?>" rel="nofollow">RSS</a></li>
            </ul>
            <?php if ($this->options->sb_right_html): ?>
            <?php $this->options->sb_right_html(); ?>
            <?php endif; ?>
        </div>
</main> <!-- .body -->


<footer class="foot">
    <div class="backtotop"><a href="javascript:void 0"><i class="icon icon-angle-double-up"></i></a></div>
    &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>">
    <?php $this->options->title(); ?></a> 版权所有<br />
    <a href="https://www.typecho.org">Typecho驱动</a> &amp; <a href="https://github.com/foxnes/tp_theme/">Hufman主题 <i class="icon icon-spin6 animate-spin"></i></a>

    <script src="<?php $this->options->themeUrl('s/lazyload.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('s/i.js'); ?>"></script>
    <?php $this->footer(); ?>

    <?php if ($this->options->footer_html){$this->options->footer_html();} ?>
</footer>

</body>
</html>