<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html class="no-js">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('s/i.css'); ?>">
    <link rel="stylesheet" href="//libs.baidu.com/fontawesome/4.0.3/css/font-awesome.css">
    <?php $this->header(); ?>
</head>
<body>
    <div class="head">
        <div class="ct">
            <h1><a href='<?php $this->options->siteUrl() ?>'><?php $this->options->title() ?></a></h1>
            <i><small><?php $this->options->description() ?></small></i>
        </div>
    </div>
    <div class="body">
        <div class="atcs">
            <div class="sb-holder" id="headtext">
                Welcome to my blog.
            </div>