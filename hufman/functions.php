<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
define('__TYPECHO_GRAVATAR_PREFIX__', 'https://gravatar.loli.net/avatar/');

function themeConfig($form){
    $ThemeOptions = new Typecho_Widget_Helper_Form_Element_Checkbox('ThemeOptions', 
        array('content' => _t('主页文章全文输出'),
            'no_rand_thumb' => _t('主页文章无图时隐藏随机展示的缩略图'),
            'comments_recent_hide_author' => _t('左侧栏近期评论隐藏作者回复')
        ),
        array('content', 'no_rand_thumb', 'comments_recent_hide_author'),
        _t('配置')
    );
    $form->addInput($ThemeOptions->multiMode());
    $form->addInput(new Typecho_Widget_Helper_Form_Element_Textarea('post_meta_text', NULL, NULL,
    _t('文章底部说明信息'),
    _t('默认替换关键字：%author% 作者(超链接形式), %time% 发布时间, %modify% 修改时间')));
    $form->addInput(new Typecho_Widget_Helper_Form_Element_Textarea('sb_right_html', NULL, NULL,
    _t('右栏HTML'),
    _t('建议参考README.MD')));
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
        preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/", $obj->content, $matches);
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
        array($obj->title, $thumb, $obj->permalink), $pattern);
    return true;
}

function getViewsStr($widget){
    //来源不明
    $fields = unserialize($widget->fields);
    if (array_key_exists('views', $fields))
        $views = (!empty($fields['views'])) ? intval($fields['views']) : 0;
    else
        $views = 0;
    //增加浏览次数
    if ($widget->is('single')){
        $vieweds = Typecho_Cookie::get('contents_viewed');
        if (empty($vieweds))
            $vieweds = array();
        else
            $vieweds = explode(',', $vieweds);
        if (!in_array($widget->cid, $vieweds)){
            $views = $views + 1;
            $widget->setField('views', 'int', $views, $widget->cid);
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

function get_gravatar($mail, $size=55, $rating='X', $default='', $isSecure = true){
    $reg = "/^\d{5,11}@[qQ][Qq]\.(com)$/";
    if (preg_match($reg, $mail)){
        $img    = explode("@", $mail);
        $url = "//q2.qlogo.cn/headimg_dl?dst_uin={$img[0]}&spec=100";
    }else{
        if (defined('__TYPECHO_GRAVATAR_PREFIX__')){
            $url = __TYPECHO_GRAVATAR_PREFIX__;
        }else{
            $url = $isSecure ? 'https://secure.gravatar.com' : 'http://www.gravatar.com';
            $url .= '/avatar/';
        }
        if (!empty($mail)){
            $url .= md5(strtolower(trim($mail)));
        }
        $url .= '?s=' . $size;
        $url .= '&amp;r=' . $rating;
        $url .= '&amp;d=' . $default;
    }
    return $url;
}

function theme_hot_posts($limit = 10){
    $format = '<li><a href="{permalink}" title="{title}"><i class="icon icon-fire"></i> <i>{views}</i> {title}</a></li>';
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $sql = 'SELECT `cid`, `int_value` from `'.$prefix.'fields` ORDER BY `int_value` DESC LIMIT '.$limit;
    $cids = $db->fetchAll($sql);
    $post_count = count($cids);
    $cid_list = [];
    $view_list = [];
    for ($i = 0; $i < $post_count; $i++){ 
        $cid_list[$i] = $cids[$i]['cid'];
        $view_list[$cids[$i]['cid']] = $cids[$i]['int_value'];
        // 有BUG会导致field没有被删除，所以按照cid来作为索引。
    }
    $cids = implode(',', $cid_list);
    $sql = 'SELECT * from `'.$prefix.'contents` WHERE cid in ('.$cids.') AND (`status` = "publish") ORDER BY FIELD(`cid`, '.$cids.')';
    $result = $db->fetchAll($sql);
    for ($i = 0; $i < $post_count; $i++){
        if (is_null($result[$i])){
            continue;
        }
        $post = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($result[$i]);
        echo str_replace(array('{permalink}', '{title}', '{views}'),
        array($post['permalink'], $post['title'], $view_list[$post['cid']]), $format);
    }
}


// 获取浏览器信息
function getBrowser($agent) {
	if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
		$outputer = 'Internet Explore';
	} else if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {
		$str1 = explode('Firefox/', $regs[0]);
		$FireFox_vern = explode('.', $str1[1]);
		$outputer = 'FireFox';
	} else if (preg_match('/Maxthon([\d]*)\/([^\s]+)/i', $agent, $regs)) {
		$str1 = explode('Maxthon/', $agent);
		$Maxthon_vern = explode('.', $str1[1]);
		$outputer = 'MicroSoft Edge';
	} else if (preg_match('#360([a-zA-Z0-9.]+)#i', $agent, $regs)) {
		$outputer = '360 Fast Browser';
	} else if (preg_match('/Edge([\d]*)\/([^\s]+)/i', $agent, $regs)) {
		$str1 = explode('Edge/', $regs[0]);
		$Edge_vern = explode('.', $str1[1]);
		$outputer = 'MicroSoft Edge';
	} else if (preg_match('/UC/i', $agent)) {
		$str1 = explode('rowser/',  $agent);
		$UCBrowser_vern = explode('.', $str1[1]);
		$outputer = 'UC Browser';
	} else if (preg_match('/QQ/i', $agent, $regs)||preg_match('/QQ Browser\/([^\s]+)/i', $agent, $regs)) {
		$str1 = explode('rowser/',  $agent);
		$QQ_vern = explode('.', $str1[1]);
		$outputer = 'QQ Browser';
	} else if (preg_match('/UBrowser/i', $agent, $regs)) {
		$str1 = explode('rowser/',  $agent);
		$UCBrowser_vern = explode('.', $str1[1]);
		$outputer = 'UC Browser';
	} else if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {
		$outputer = 'Opera';
	} else if (preg_match('/Chrome([\d]*)\/([^\s]+)/i', $agent, $regs)) {
		$str1 = explode('Chrome/', $agent);
		$chrome_vern = explode('.', $str1[1]);
		$outputer = 'Google Chrome';
	} else if (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {
		$str1 = explode('Version/',  $agent);
		$safari_vern = explode('.', $str1[1]);
		$outputer = 'Safari';
	} else {
		$outputer = 'Google Chrome';
	}
	echo $outputer;
}
// 获取操作系统信息
function getOs($agent) {
	$os = false;
	if (preg_match('/win/i', $agent)) {
		if (preg_match('/nt 6.0/i', $agent)) {
			$os = 'Windows Vista';
		} else if (preg_match('/nt 6.1/i', $agent)) {
			$os = 'Windows 7';
		} else if (preg_match('/nt 6.2/i', $agent)) {
			$os = 'Windows 8';
		} else if(preg_match('/nt 6.3/i', $agent)) {
			$os = 'Windows 8.1';
		} else if(preg_match('/nt 5.1/i', $agent)) {
			$os = 'Windows XP';
		} else if (preg_match('/nt 10.0/i', $agent)) {
			$os = 'Windows 10';
		} else {
			$os = 'Windows X64';
		}
	} else if (preg_match('/android/i', $agent)) {
		if (preg_match('/android 9/i', $agent)) {
			$os = 'Android Pie';
		} else if (preg_match('/android 8/i', $agent)) {
			$os = 'Android Oreo';
		} else {
			$os = 'Android';
		}
	} else if (preg_match('/ubuntu/i', $agent)) {
		$os = 'Ubuntu';
	} else if (preg_match('/linux/i', $agent)) {
		$os = 'Linux';
	} else if (preg_match('/iPhone/i', $agent)) {
		$os = 'iPhone';
	} else if (preg_match('/mac/i', $agent)) {
		$os = 'MacOS';
	} else if (preg_match('/fusion/i', $agent)) {
		$os = 'Android';
	} else {
		$os = 'Linux';
	}
	echo $os;
}

/* 扩展Typecho的类 */

class Widget_Comments_Recent_theme extends Widget_Abstract_Comments
{
    public function __construct($request, $response, $params = NULL)
    {
        parent::__construct($request, $response, $params);
        $this->parameter->setDefault(array('pageSize' => $this->options->commentsListSize, 'parentId' => 0, 'ignoreAuthor' => false));
    }
    public function execute()
    {
        $select  = $this->select()->limit($this->parameter->pageSize)
        ->where('table.comments.status = ?', 'approved')
        ->order('table.comments.coid', Typecho_Db::SORT_DESC);

        if ($this->parameter->parentId) {
            $select->where('cid = ?', $this->parameter->parentId);
        }

        if ($this->options->commentsShowCommentOnly) {
            $select->where('type = ?', 'comment');
        }
        
        /** 忽略作者评论 */
        if ( ( !empty($this->options->ThemeOptions) && in_array('comments_recent_hide_author', $this->options->ThemeOptions) )
             || $this->parameter->ignoreAuthor) {
            $select->where('ownerId <> authorId');
        }

        $this->db->fetchAll($select, array($this, 'push'));
    }
}

