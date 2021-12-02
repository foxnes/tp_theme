<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
define('__TYPECHO_GRAVATAR_PREFIX__', 'https://gravatar.loli.net/avatar/');

function themeConfig($form) {
    $ThemeOptions = new Typecho_Widget_Helper_Form_Element_Checkbox('ThemeOptions', 
        array('content' => _t('主页文章全文输出')
    ),
    array('content'), _t('配置'));
    $form->addInput($ThemeOptions->multiMode());
    $form->addInput(new Typecho_Widget_Helper_Form_Element_Textarea('sb_right_html', NULL, NULL, _t('右栏HTML'), _t('在右侧栏的"其它"下面再添加新的内容.如：<br />&lt;ul class="sb-widget"&gt;&lt;p class=&quot;cleartext&quot;&gt;友链&lt;/p&gt;&lt;li&gt;&lt;a href=&#x27;#&#x27;&gt;老李&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&#x27;#&#x27;&gt;老黄&lt;/a&gt;&lt;/li&gt;&lt;/ul&gt;<br />再或者是：<br />&lt;ul class="sb-widget"&gt;<br />&lt;p class=&quot;cleartext&quot;&gt;诗词&lt;/p&gt;<br />&lt;li id=&quot;jinrishici-sentence&quot;&gt;正在加载....&lt;/li&gt;<br />&lt;script src=&quot;//sdk.jinrishici.com/v2/browser/jinrishici.js&quot; charset=&quot;UTF-8&quot; defer&gt;&lt;/script&gt;<br />&lt;/ul&gt;')));
}

function showThumb($obj, $randgiven){
//来源于绛木子的简书主题
	$size=null;$link=false;
	$pattern='<div class="post-thumb">
	            <a href="' . $obj->permalink . '">
	            <img alt="{title}" unzoomable src="'.Helper::options()->themeUrl.'/s/img/loading.gif" data-original="{thumb}" />
	            <div class="view inner"><i class="icon icon-eye"></i>&nbsp;' . getViewsStr($obj) .'</div>
	            <div class="cmmt inner"><i class="icon icon-comment-empty"></i>&nbsp;' . $obj->commentsNum . '</div>
	            </a>
	        </div>';
        $fields = unserialize($obj->fields);
        if (array_key_exists('thumb', $fields)):
          $thumb = (!empty($fields['thumb'])) ? $fields['thumb'] : 0;
        else:
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
        endif;
    if(empty($thumb)){ // 修改下面的代码可以修改随机图像的生成规律
        if ($randgiven){
            $img_id = $obj->cid % (14+1); // 根据cid取余生成 0~14 之间的数
            $thumb = Helper::options()->themeUrl."/s/img/".$img_id.".jpg";
        }else{
            return false;
        }
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
            Typecho_Cookie::set("contents_viewed", $vieweds);
        }
    }
    return $views;
}

function img_lazy_load($ct){
    $imgplaceholder = Helper::options()->themeUrl."/s/img/loadingi.gif";
    return preg_replace("/<img(.*?)src=[\"|'](.*?)[\"|'](.*?)>/i","<img src='".$imgplaceholder."'$1data-original='$2'$3>",$ct);
}

function get_gravatar($mail, $size=55, $rating='X', $default='', $isSecure = true)
{
    $reg = "/^\d{5,11}@[qQ][Qq]\.(com)$/";
    if (preg_match($reg, $mail)) {
        $img    = explode("@", $mail);
        $url = "//q2.qlogo.cn/headimg_dl?dst_uin={$img[0]}&spec=100";
    } else {
        if (defined('__TYPECHO_GRAVATAR_PREFIX__')) {
            $url = __TYPECHO_GRAVATAR_PREFIX__;
        } else {
            $url = $isSecure ? 'https://secure.gravatar.com' : 'http://www.gravatar.com';
            $url .= '/avatar/';
        }
        if (!empty($mail)) {
            $url .= md5(strtolower(trim($mail)));
        }
        $url .= '?s=' . $size;
        $url .= '&amp;r=' . $rating;
        $url .= '&amp;d=' . $default;
    }
    return $url;
}