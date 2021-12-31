<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html class="no-js">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('s/i.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('s/icon/css/animation.css'); ?>">
    <?php $this->header(); ?>
    <script src="<?php $this->options->themeUrl('s/jquery-1.8.3.min.js'); ?>"></script>
    <script>themeUrl = "<?php echo $this->options->themeUrl ?>";</script>
</head>
<body>
    <div id="pagecover" onclick="try{$(this).fadeOut()}catch(e){this.style.display='none';}"></div>
    <div class="head">
        <div class="ct">
            <h1><a href='<?php $this->options->siteUrl() ?>'><?php $this->options->title() ?></a></h1>
            <i><small><?php $this->options->description() ?></small></i>
        </div>
    </div>
    <div class="body">
        <ul class="top-nav">
            <li><a href="<?php $this->options->siteUrl() ?>" title="<?php $this->options->title(); ?>">首页</a></li>
            <?php $this->widget('Widget_Contents_Page_List')->to($pages);while($pages->next()): ?>
            <li><a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a></li>
            <?php endwhile; ?>
        </ul>
        <div class="atcs">
            <div class="sb-holder">
                <a href="<?php $this->options->siteUrl(); ?>">Home</a> &raquo;
                <?php if ($this->is('index')): ?>
                Latest Posts
                <?php elseif ($this->is('post')): ?>
                <?php $this->category(); ?> &raquo; Article
                <?php else: ?>
                <?php $this->archiveTitle(' &raquo; ','',''); ?>
                <?php endif; ?>
            </div>