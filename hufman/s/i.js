//if jq error: auto load a new one
try{jQuery()}catch(e){
    let s = document.createElement('script');
    s.src='//libs.baidu.com/jquery/1.8.3/jquery.min.js';
    s.charset='UTF-8';
    document.body.append(s);
}

PostbirdImgGlass.init({ // 图像放大
    domSelector:".post-content img:not([unzoomable])",
    animation:true
});

$(".post-thumb img").lazyload();
$(".post-content img").lazyload();


facenamereplace = ["：滑稽：","：喷：","：彩虹：","：阴险：","：怒：","：笑眼：",
"：黑线：","：玫瑰：","：乖：","：汗：","：惊哭：","：酷：","：狂汗：","：冷：",
"：真棒：","：不高兴：","：大哭：","：咖啡：","：yeah：","：ojbk："];
/*
facereplace = [];
for (var i = 0; i < facenamereplace.length; i++) {
	facereplace[i] = theme_path+"/s/img/"+facenamereplace[i].replace(/：/g,"")+".png";
}
*/
facereplace = [];
for (var i=0; i<facenamereplace.length;i++){
    facereplace[i] = "bg-face_"+i;
}
try{
	if (showfacenamereplace) {
		for (var i = 0; i < facenamereplace.length; i++) {
			showfacenamereplace.innerHTML += facenamereplace[i];
		}
	}
}catch(e){}
var bodyhtml = $("#comments").html();
if (bodyhtml){
    for (var i = 0; i < facereplace.length; i++) {
	    bodyhtml = bodyhtml.replace(new RegExp(facenamereplace[i],"ig"),"<i class='tbbq "+facereplace[i]+"' draggable='false' alt='😀' num='"+i+"'></i>");
    }
    $("#comments").html(bodyhtml);
    $("#showfacenamereplace .tbbq").click(function(){
	    insertText($("textarea[name=text]")[0], facenamereplace[$(this).attr("num")]);
    });
}
bodyhtml = $("#rctrly").html();
if (bodyhtml){
    for (var i = 0; i < facereplace.length; i++) {
	    bodyhtml = bodyhtml.replace(new RegExp(facenamereplace[i],"ig"),"<i class='tbbq tiny "+facereplace[i]+"' draggable='false' alt='😀' num='"+i+"'></i>");
    }
    $("#rctrly").html(bodyhtml);
}

// 插入表情完毕之后再计算高度，防止插入表情后高度变化

if ($(window).width() > 800) {
    var sb_height = Math.max($(".sb-left").height(), $(".sb-right").height());
    $(".atcs").css("min-height", sb_height);
}

if ($(window).width() < 500){
    $('#comments').parent('.post').css('padding', 0);
}

$(".backtotop").click(function () {
        var speed = 200;
        $('body,html').animate({ scrollTop: 0 }, speed);
        return false;
});

function insertText(obj,str){
	var m = obj.value.match(/：.*?：/g);
	if (m) {
		if (m.length > 9) {
			alert("最多添加10个表情！");
			return false;
		}
	}
	obj.value += str;
}

// 红色
var HL_KW = ['and', 'as', 'assert', 'break', 'case', 'catch', 'classdef', 'continue', 'die', 'del',
'do', 'else', 'elseif', 'endfor', 'endforeach', 'endif', 'elif', 'endswitch',
'except', 'endwhile', 'eval', 'exit', 'finally', 'False',
'for', 'from', 'foreach', 'global', 'goto', 'if', 'in', 'is', 'import', 'include', 'lambda',
'not', 'None', 'new', 'namespace', 'or', 'private', 'pass', 'public', 'protected', 'require', 'static',
'return', 'raise', 'switch', 'throw', 'try', 'True', 'var', 'with', 'while', 'xor', 'yield'];
HL_KW = new RegExp('\\b('+HL_KW.join('|')+')\\b', 'ig');
// 蓝色 有括号调用的已经默认自动变蓝了
var HL_KF = [
// js
'function',
// python
'def', 'print',
// ternimal - linux
'echo', 'exec', 'vim', 'vi', 'screen', 'ls', 'cd', 'pwd', 'mkdir', 'cp', 'mv', 'rm', 'df', 'du', 'cat', 'clear', 'grep',
'reboot', 'shutdown', 'basename', 'dirname', 'export', 'read', 'test', 'who', 'tee', 'unset', 'chmod',
'find', 'tar', 'gzip', 'rmdir', 'kill', 'crontab', 'service', 'free', 'top', 'chown', 'sudo', 'passwd',
'tail', 'diff', 'scp', 'telnet', 'wget', 'ifconfig', 'whereis', 'locate', 'date', 'route', 'iptables', 
'pip', 'pip2', 'pip3', 'python', 'python2', 'python3', 'apt', 'apt-get', 'pkg', 'yum', 'pacman', 'git', 'cmake',
'make',
// matlab
'axis', 'hold', 'grid'
];
HL_KF = new RegExp('\\b('+HL_KF.join('|')+')\\b', 'ig');

$("pre code").each(function(){
    this.innerHTML = this.innerHTML.replace(/((["'])(?:\\.|[^\\\n])*?\2)/ig,"<span class='hl-str'>$1</span>").replace(/(\\[\s\S])/ig,"<span class='hl-warn'>$1</span>").replace(/(\/\*[\s\S]+\*\/)/g,"<span class='hl-note'>$1</span>").replace(/(~\/| -{1,2}[a-z&;]{1,}[ :\n\r]|!|\^|\+|\*|%|\||&amp;|===|==|-&gt;|=&gt;|=&lt;|&lt;=|&gt;=|&gt;|&lt;)/ig,"<span class='hl-fh'>$1</span>").replace(/([^a-z0-9_]|^)([\d\.]+)([^a-z0-9_]|$)/ig,"$1<span class='hl-num'>$2</span>$3").replace(/([^a-z0-9_]|^)([\d\.]+)([^a-z0-9_]|$)/ig,"$1<span class='hl-num'>$2</span>$3").replace(HL_KW, "<span class='hl-kw'>$1</span>").replace(/((?=^|\n|\r| )\s*(\/\/|#).*(?=\r|\n|$))/g,"<span class='hl-note'>$1</span>").replace(HL_KF,"<span class='hl-kf'>$1</span>").replace(/\b((?![0-9])[\w0-9]+(?=\())/ig,"<span class='hl-kf'>$1</span>").replace(/(\$(?![0-9])[\w0-9]+\b)/ig, "<span class='hl-var'>$1</span>");
});

if ($(".post-meta")){
	$(".post-meta").css("width",$(".atcs").width());
}

$('.post-thumb img').each(function(){
    this.onerror = function(){
        $(this).attr("src", themeUrl+"/s/img/error.jpg");
    }
});

// 点击打开表情
$('.click_to_show').each(function(){
    $(this).children('.click_board').each(function(){
        var dom = $('#'+$(this).attr('for'));
        dom.click(function(){
            $(this).fadeOut(100);
        });
        $(this).click(function(){
            dom.fadeIn(100);
        });
    });
});

window.onload = function(){
    $("#pagecover").fadeOut()
}