$(function(){

if (window.applicationCache) {
	$.getScript("//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js",function(){
		$('pre code').each(function(i, block) {hljs.highlightBlock(block)});
	});
}
$('pre code').attr("contenteditable","true");

$(".top-bar-body li").each(function(){
	$(".top-bar-body li a").click(function(){
		$(".top-bar-body li").css("border-bottom","0px");
		$(this).parent().css("border-bottom","3px solid #fa7d3c");
	});
});

var tmp_rmt_h = $(window).height()-76-$(".foot").height()-34;
$("#randomarticle").slimScroll({height:tmp_rmt_h+'px',size:"5px",wheelStep:18,color:"#ee6583"});
randomarticleP_top = $("#randomarticleP").offset().top;//全局变量！否则BUG
try{comment_form_top = $("#comment_form").offset().top}
catch(err){comment_form_top = "ud"}
$(window).scroll(function(){
	var document_height = $(document).height();
	var TscrollTop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
	if (TscrollTop>666) {
		$("#gotop").css("display","block");
	}else{
		$("#gotop").css("display","none");
	}
	if ($(window).width()>630 && TscrollTop>=randomarticleP_top && $(document).height()-randomarticleP_top > ($("#randomarticleP").height()+30)*2) {
		$("#randomarticleP").css({"position":"fixed","top":0,"width":$(".box").width()});
	}else{
		$("#randomarticleP").css("position","static");
		randomarticleP_top = $("#randomarticleP").offset().top;
	}
	if ($(window).width()>630 && comment_form_top!=="ud" && typeof comment_form_top!=="undefined") {
		if (TscrollTop>=comment_form_top && $(document).height()-comment_form_top > ($("#comment_form").height()+38)*2 
			&& $(window).height()>$("#comment_form").height()+48 && comment_form_top < randomarticleP_top) {
			$("#comment_form").css({"position":"fixed","top":0,"width":$(".a-l-fc").width(),"left":$(".a-l-fc").offset().left});
		}else{
			$("#comment_form").css({"position":"relative","left":0});
			try{comment_form_top = $("#comment_form").offset().top}
			catch(err){comment_form_top = "ud"}
		}
	}
});

//-------------表情
facenamereplace = ["：滑稽：","：喷：","：彩虹：","：阴险：","：怒：","：笑眼：","：黑线：","：玫瑰："];
facereplace = ["https://wx3.sinaimg.cn/large/005uBItOgy1fu10b8koukj300u00uq2s.jpg",
"https://wx3.sinaimg.cn/large/005uBItOgy1fu10b8zm3rj300u00uwec.jpg",
"https://wx3.sinaimg.cn/large/005uBItOgy1fu10b9m17tj300u00u744.jpg",
"https://wx2.sinaimg.cn/large/005uBItOgy1fu10b7rcuxj300u00uq2s.jpg",
"https://wx2.sinaimg.cn/large/005uBItOgy1fu10b74x02j300u00ut8k.jpg",
"https://wx3.sinaimg.cn/large/005uBItOgy1fu10b82w9vj300u00uwec.jpg",
"https://wx3.sinaimg.cn/large/005uBItOgy1fu10b7e9bcj300u00uq2s.jpg",
"https://wx4.sinaimg.cn/large/005uBItOgy1fu10b9a74cj300u00uglg.jpg"];
try{
	if (showfacenamereplace) {
		for (var i = 0; i < facenamereplace.length; i++) {
			showfacenamereplace.innerHTML += facenamereplace[i];
		}
	}
}catch(e){}
var bodyhtml = $(".article-list").html();
for (var i = 0; i < facereplace.length; i++) {
	bodyhtml = bodyhtml.replace(new RegExp(facenamereplace[i],"ig"),"<img class='tbbq' alt='"+i+"' src='"+facereplace[i]+"' />");
}
bodyhtml = bodyhtml.replace(/【script(.*?)script】/ig,"")
var tmp_html_reg = /【([\w]{1,10})(.*?)\1】/ig;
while(tmp_html_reg.test(bodyhtml)){
	bodyhtml = bodyhtml.replace(tmp_html_reg,"<$1>$2</$1>");
}
$(".article-list").html(bodyhtml);
$("form .tbbq").click(function(){
	insertText($("textarea[name=text]")[0], facenamereplace[$(this).attr("alt")]);
});
//--------------简化标签
//--------------打赏233
$(".pay span").click(function(){
	$(".pay img").click();
});
//--------------图片放大
$("#zooming").click(function(){
	$(this).fadeOut(200);
});
$(".post-content img").click(function(){
	zooming($(this).attr("src"));
});
$(".post-content .tbbq").unbind("click");
//--------------
$(".hover-show").hover(function(){
	$(this).children(".show-this").slideDown(250);
},function(){
	$(this).children(".show-this").slideUp(250);
});
//--------------
$(".box-body img").lazyload({effect:"fadeIn",threshold:$(window).height()*1.4});
$("img").each(function(){
	$(this).lazyload({effect: "fadeIn"});
});
var qrcode = new QRCode(pageewm, {width : 220,height : 220});
qrcode.makeCode(window.location.href);
});

function zooming(url){
	$("#zooming img").attr("src",url);
	$("#zooming img").on("load",function(){
		$("#zooming").fadeIn(200);
		if ($("#zooming img").height()<$(window).height()) {
			$("#zooming img").css("margin-top",($(window).height()-$("#zooming img").height())/2.3);
		}else{
			$("#zooming img").css("margin-top","0px");
		}
	});
}

function insertText(obj,str){
	if (window.applicationCache) {
    if (document.selection){
        var sel = document.selection.createRange();
        sel.text = str;
        setcopy(0);
    }else if (typeof obj.selectionStart === 'number' && typeof obj.selectionEnd === 'number'){
        var startPos = obj.selectionStart;
        var    endPos = obj.selectionEnd;
        var    cursorPos = startPos;
        var    tmpStr = obj.value;
        obj.value = tmpStr.substring(0, startPos) + str + tmpStr.substring(endPos, tmpStr.length);
        cursorPos += str.length;
        obj.selectionStart = obj.selectionEnd = cursorPos;
    }else{
        obj.value += str;
    }
	}else{
		obj.innerHTML+=str;
	}
}