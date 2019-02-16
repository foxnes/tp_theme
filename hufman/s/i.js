if ($(window).width() >800 && $(".atcs").height() < $(".sb-left").height()) {
    $(".atcs").css("min-height", $(".sb-left").height());
}

var zooming = new Zooming();
zooming.listen('.post-content img:not([unzoomable])');

facenamereplace = ["：滑稽：","：喷：","：彩虹：","：阴险：","：怒：","：笑眼：",
"：黑线：","：玫瑰：","：乖：","：汗：","：惊哭：","：酷：","：狂汗：","：冷：",
"：真棒：","：不高兴：","：大哭：","：咖啡：","：yeah：","：ojbk："];
/*
facereplace = [];
for (var i = 0; i < facenamereplace.length; i++) {
	facereplace[i] = theme_path+"/s/img/"+facenamereplace[i].replace(/：/g,"")+".png";
}
*/
facereplace = ["https://wx1.sinaimg.cn/mw690/005ShQFIgy1fu6s184o24j300u00uq2s.jpg",
"https://wx2.sinaimg.cn/mw690/005ShQFIgy1fu6s1ablbbj300u00uwec.jpg",
"https://wx3.sinaimg.cn/mw690/005ShQFIgy1fu6s16m089j300u00u744.jpg",
"https://wx1.sinaimg.cn/mw690/005ShQFIgy1fu6s1ax3a1j300u00uq2s.jpg",
"https://wx2.sinaimg.cn/mw690/005ShQFIgy1fu6s1a045uj300u00ut8k.jpg",
"https://wx2.sinaimg.cn/mw690/005ShQFIgy1fu6s1amokjj300u00uwec.jpg",
"https://wx4.sinaimg.cn/mw690/005ShQFIgy1fu6s17syp4j300u00uq2s.jpg",
"https://wx1.sinaimg.cn/mw690/005ShQFIgy1fu6s19lh8sj300u00uglg.jpg",
"https://wx2.sinaimg.cn/mw690/005ShQFIgy1fu6s172vs1j300u00ut8k.jpg",
"https://wx1.sinaimg.cn/mw690/005ShQFIgy1fu6s17jbtaj300u00uq2s.jpg",
"https://wx1.sinaimg.cn/mw690/005ShQFIgy1fu6s18dxs3j300u00ut8k.jpg",
"https://wx4.sinaimg.cn/mw690/005ShQFIgy1fu6s18o1ehj300u00u0sl.jpg",
"https://wx2.sinaimg.cn/mw690/005ShQFIgy1fu6s18z1tcj300u00uwec.jpg",
"https://wx4.sinaimg.cn/mw690/005ShQFIgy1fu6s199skzj300u00uq2s.jpg",
"https://wx2.sinaimg.cn/mw690/005ShQFIgy1fu6s1b931zj300u00uwec.jpg",
"https://wx3.sinaimg.cn/large/005ShQFIgy1fuqisjlduhj300u00uq2s.jpg",
"https://wx2.sinaimg.cn/large/005ShQFIgy1fuqisjy9vmj300u00ut8k.jpg",
"https://wx2.sinaimg.cn/large/005ShQFIgy1fuqisk65elj300u00udfo.jpg",
"https://wx2.sinaimg.cn/large/005ShQFIgy1fuqiskmyuqj300u00u3yc.jpg",
"https://wx1.sinaimg.cn/large/005ShQFIgy1fuqis19uo9j300u00u744.jpg"];
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
	    bodyhtml = bodyhtml.replace(new RegExp(facenamereplace[i],"ig"),"<img class='tbbq' draggable='false' alt='"+i+"' src='"+facereplace[i]+"' />");
    }
    $("#comments").html(bodyhtml);
    $("form .tbbq").click(function(){
	    insertText($("textarea[name=text]")[0], facenamereplace[$(this).attr("alt")]);
    });
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



$("pre code").each(function(){
    this.innerHTML = this.innerHTML.replace(/(\\[\s\S])/ig,"<span>$1</span>").replace(/(("|'|`)[^\2]*?\2)/ig,"<span class='hl-str'>$1</span>").replace(/(~\/| -{1,2}[a-z]{1,}[ :\n\r]|!|\+|\*|%|\||&amp;|==|=&gt;)/ig,"<span class='hl-fh'>$1</span>").replace(/([^a-z0-9]|^)([\d\.]+)([^a-z0-9]|$)/ig,"$1<span class='hl-num'>$2</span>$3").replace(/([^a-z]|^)(RegExp|return|if|fi|then|else|break|continue|for|endif|in|not|die|exit|switch|case|throw|void|typeof|endwhile|elseif|import|array|while|foreach|important|new|and|or|xor|with|desc|limit|order|try|as|catch)([^a-z]|$)/ig, "$1<span class='hl-kw'>$2</span>$3").replace(/([^:]|^)((#|\/\/).*)/g,"$1<span class='hl-note'>$2</span>").replace(/(\/\*[\s\S]*?\*\/)/g,"<span class='hl-note'>$1</span>").replace(/([^a-z\.]|^)(echo|alert|print|print_r|printf|include|default|final|eval|exec|shell|list|function|static|const|var|unset|unlink|undefined|null|true|false|empty|del|is|def|this|margin|padding|color|background|display|float|font|line|letter|word|cursor|border|vertical|width|height|position|clear|screen|max|min|rgba|rgb|box|inherit|left|right|top|bottom|wrap|wget|ls|chmod|grep|cat|test|match|yum|apt|mv|cp|rm|sudo|sh|source|bash|find|more|touch|awk|curl|tee|tree|read|vim|diff|unzip|tar|ftp|cd|mount|stat|rmdir|git|dd|df|du|restart|stop|start|sfdisk|fdisk|kill|top|free|who|clear|reset|alias|gzip|rpm|pacman|dump|bzip2|dpkg|count|document|window|install|remove|floor|make)([^a-z])/ig,"$1<span class='hl-kf'>$2</span>$3");
});

if ($(".post-meta")){
	$(".post-meta").css("width",$(".atcs").width()-15);
}

$('.post-thumb img').each(function(){
    this.onerror = function(){
        this.style = "display: none"
    }
})
