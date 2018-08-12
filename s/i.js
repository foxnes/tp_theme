$(function(){

if (typeof(WebSocket) == "function") {
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
try{
	$("#randomarticle").slimScroll({height:tmp_rmt_h+'px',size:"5px",wheelStep:18,color:"#ee6583"});
	randomarticleP_top = $("#randomarticleP").offset().top;//全局变量！否则BUG
}catch(err){
	randomarticleP_top = false;
}
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
	if (randomarticleP_top) {
	if ($(window).width()>630 && TscrollTop>=randomarticleP_top && $(document).height()-randomarticleP_top > ($("#randomarticleP").height()+30)*2) {
		$("#randomarticleP").css({"position":"fixed","top":0,"width":$(".box").width()});
	}else{
		$("#randomarticleP").css("position","static");
		randomarticleP_top = $("#randomarticleP").offset().top;
	}
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
facenamereplace = ["：滑稽：","：喷：","：彩虹：","：阴险：","：怒：","：笑眼：",
"：黑线：","：玫瑰：","：乖：","：汗：","：惊哭：","：酷：","：狂汗：","：冷：",
"：真棒："];
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
"https://wx2.sinaimg.cn/mw690/005ShQFIgy1fu6s1b931zj300u00uwec.jpg"];
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
	$(this).children(".show-this").slideDown(150);
},function(){
	$(this).children(".show-this").slideUp(150);
});
//--------------
$(".box-body img").lazyload({effect:"fadeIn",threshold:$(window).height()*1.4});
$("img").each(function(){
	$(this).lazyload({effect: "fadeIn"});
});
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
	var m = obj.value.match(/：.*?：/g);
	if (m) {
		if (m.length > 9) {
			alert("最多添加10个表情！");
			return false;
		}
	}
	obj.value += str;
}