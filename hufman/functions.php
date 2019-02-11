<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
}

function showThumb($obj){
//来源于绛木子的简书主题
	$size=null;$link=false;
	$pattern='<div class="post-thumb">
	            <img alt="{title}" src="{thumb}" />
	            <div class="view inner"><i class="fa fa-eye"></i> ' . getViewsStr($obj) .'</div>
	            <div class="cmmt inner"><i class="fa fa-comments"></i> ' . $obj->commentsNum . '</div>
	        </div>';
    preg_match_all( "/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/", $obj->content, $matches);
    $thumb = '';
    $options = Typecho_Widget::widget('Widget_Options');
    if(isset($matches[1][0])){
        $thumb = $matches[1][0];;
        if(!empty($options->src_add) && !empty($options->cdn_add)){
            $thumb = str_ireplace($options->src_add,$options->cdn_add,$thumb);
        }
        if($size!='full'){
            $thumb_width = $options->thumb_width;
            $thumb_height = $options->thumb_height;
    
            if($size!=null){
                $size = explode('x', $size);
                if(!empty($size[0]) && !empty($size[1])){
                    list($thumb_width,$thumb_height) = $size;
                }
            }
        }
    }
    if(empty($thumb)){
        $thumb = $options->themeUrl."/s/img/".rand(0,14).".jpg";
    }
    echo str_replace(
        array('{title}','{thumb}','{permalink}'),
        array($obj->title,$thumb,$obj->permalink), $pattern);
}

function getViewsStr($widget) {
    //来源不明
    $fields = unserialize($widget->fields);
    if (array_key_exists('views', $fields))
        $views = (!empty($fields['views'])) ? intval($fields['views']) : 0;
    else
        $views = 0;
    //增加浏览次数
    if ($widget->is('single')) {
        $vieweds = Typecho_Cookie::get('contents_viewed');
        if (empty($vieweds))
            $vieweds = array();
        else
            $vieweds = explode(',', $vieweds);
        if (!in_array($widget->cid, $vieweds)) {
            $views = $views + 1;
            $widget->setField('views', 'str', strval($views), $widget->cid);
            $vieweds[] = $widget->cid;
            $vieweds = implode(',', $vieweds);
            Typecho_Cookie::set("contents_viewed",$vieweds);
        }
    }
    return $views;
}