$(function(){

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
	$("textarea[name=text]")[0].value+=facenamereplace[$(this).attr("alt")];
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
$(".box-body img").lazyload({effect:"fadeIn",threshold:$(window).height()*2});
$("img").each(function(){
	$(this).lazyload({effect: "fadeIn",placeholder: "data:image/png;base64,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"});
});
$(".post-content .tbbq").unbind("click");
//--------------
$(".hover-show").hover(function(){
	$(this).children(".show-this").fadeIn(100);
},function(){
	$(this).children(".show-this").fadeOut(100);
});
//--------------
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