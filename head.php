<?php
//https://wx1.sinaimg.cn/large/005ShQFIly1ftkrnqwzvfj30tc0gi75w.jpg
//https://wx2.sinaimg.cn/large/005ShQFIly1ftkrnqu6m3j30rs0rsaap.jpg
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if (!$this->have()){
    header("HTTP/1.0 404 Not Found"); //搜索的时候404
}
?>
<!DOCTYPE HTML>
<html style="background-image: url(<?php if ($this->options->bgimg): ?><?php $this->options->bgimg(); ?><?php else:?>https://i.loli.net/2018/07/24/5b569431e16aa.jpg<?php endif; ?>);">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'     =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('s/i.css'); ?>">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/jpeg" href="<?php echo "http://cn.gravatar.com/avatar/".md5($this->author->mail)."?s=64&d=&r=G"; ?>" media="screen" />
    <?php $this->header(); ?>
    <!--[if lte IE 8]>
    <style>
        html{background-image: none !important}
        #gotop{background-color: #484848}
    </style>
    <![endif]-->
</head>
<body>

<div class="head"></div>

<div class="body c-min">
	<div class="body-top-bg shadow" style="background-image: url(<?php if ($this->options->topimg): ?><?php $this->options->topimg(); ?><?php else: ?>http://wx1.sinaimg.cn/large/005uBItOgy1fu132mvw2qj30r808c41d.jpg<?php endif; ?>);">
        <?php $this->author->gravatar('100','','','body-gravatar') ?>
		<h2><?php $this->options->title() ?></h2>
		<small><i><?php $this->options->description() ?></i></small>
	</div>
    <div class="top-bar-body">
        <ul>
            <li<?php if($this->is('index')): ?> class="current"<?php endif; ?>><a href="<?php $this->options->siteUrl(); ?>"><?php _e('主页'); ?></a></li>
            <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
            <?php while($pages->next()): ?>
            <li<?php if($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?>><a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a></li>
            <?php endwhile; ?>
        </ul>
    </div>
	<div class="sidebar">
		<?php $this->need('sidebar.php'); ?>
	</div>
	<div class="article-list">
        <div class="post a-l-fc">
            <div style="float: left">
            	<div href="javascript:void 0" class="hover-show current">
            		二维码<div id="pageewm" class="show-this"></div>
            	</div>
            </div>
            <div style="float: left">
                <div href="javascript:void 0" class="hover-show">
                    分享<div class="show-this">
                        <div class="bdsharebuttonbox" style="white-space: nowrap;"><a href="javascript:void 0" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间">QQ空间</a><a href="javascript:void 0" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博">新浪微博</a><a href="javascript:void 0" class="bds_renren" data-cmd="renren" title="分享到人人网">人人网</a><a href="javascript:void 0" class="bds_weixin" data-cmd="weixin" title="分享到微信">微信</a><a href="javascript:void 0" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友">QQ好友</a><a href="javascript:void 0" class="bds_more" data-cmd="more">更多</a></div>
                    </div>
                </div>
            </div>
            <div style="float: right"><form method="post" action="" class="fr">
                <input type="text" name="s" size="32" placeholder="搜索文章" />
                <button type="submit" id="searchsubmit"></button>
                <label for="searchsubmit"><i class="is fa fa-search"></i></label>
            </form></div>
            <div class="clear"></div>
        </div>