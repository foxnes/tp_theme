var full_size_width = 920;
$(function(){
    $("#pagecover").fadeOut();
});
$(".post-thumb img").lazyload();
$(".post-content img").lazyload();

function safe_do(fn){
    try{fn()}catch{console.error('Error when executing: '+fn.toString())};
}

function emoji_add(selector, facenamereplace, facecls, prefix = "tbbq-face"){ // 表情管理 评论区插入+自动替换
    facereplace = [];
    for (var i = 0; i < facenamereplace.length; i++){
        facereplace[i] = prefix + "_" + i;
    }
    if ($(selector).length > 0) {
        for (var i = 0; i < facenamereplace.length; i++) {
            $(selector)[0].innerHTML += '‹'+facenamereplace[i]+'›';
        }
    }
    function showFaces(dom, cls, callback){
        if (dom.length > 0){
            var bodyhtml = dom.html();
            for (var i = 0; i < facereplace.length; i++) {
                bodyhtml = bodyhtml.replace(new RegExp('(‹|：)'+facenamereplace[i]+'(›|：)',"g"),
                    "<i class='emojis " + facecls + " "+cls+" "+facereplace[i]+"' draggable='false' alt='😀' num='"+i+"'></i>");
            }
            dom.html(bodyhtml);
            callback();
        }
    }
    showFaces($('#comments'), '', function(){
        $(selector+" .emojis").each(function(){
            $(this).attr('onclick', // 添加onclick防止事件丢失
            'insertText( $("textarea[name=text]")[0], \'‹'+facenamereplace[$(this).attr('num')]+'›\' );');
        })
    });
    showFaces($("#rctrly"), 'tiny', function(){});
}

emoji_add('#showfacenamereplace_tbbq', ["滑稽","喷","彩虹","阴险","怒","笑眼","黑线","玫瑰","乖","汗",
"惊哭","酷","狂汗","冷","真棒","不高兴","大哭","咖啡","yeah","ojbk"], "tbbq", "tbbq-face");
emoji_add('#showfacenamereplace_wpbq', ['→', '开心', '疑惑', '很酷', '哭泣', '咿呀', '恶魔', '!!!',
'idea', '哄堂大笑', '生气', '绿笑脸', '面无表情', '问号', '吐舌头', '脸红', '白眼', '伤心', '微笑', 
'惊讶', '恶魔坏笑', 'wink'], "wpbq", "wpbq-face");


var extraPowerEmoticons = ["w(ﾟДﾟ)w", "(๑•̀ㅂ•́)و✧", "o(￣▽￣)d", "(//▽//)", "(￣∀￣)", "(ง ˙o˙)ว",
 "(｡･∀･)ﾉﾞ", "(*￣3￣)╭", "(:3[▓▓]", "_(:з」∠)_", "(●´∀｀●)", "(¯﹃¯)",
 "(๑•́ ₃ •̀๑)", "♪(^∇^*)", "(\\`･ω･´)", "(*´∀｀)ノ", "(つд⊂)", "(°ー°〃)",
 "(\\`ε´ )", "<(｀^′)>", "(｀д′)", "╰（‵□′）╯", "(。皿。メ)", "(╯￣Д￣)╯╘═╛", "σ\\`∀´)",
 "( ´ー\\`)", "( ﾟ 3ﾟ)", "ﾟ∀ﾟ)σ", "( ˇωˇ)", "[]~(￣▽￣)~",
 "|д\\` )", "(\\`ヮ´ )", "(｡◕∀◕｡)", "ᕕ( ᐛ )ᕗ", "( ›´ω\\`‹ )", "( ﾟ∀。)", "ฅ(^ω^ฅ)",
 "(  д ) ﾟ ﾟ", "Σ(っ °Д °;)っ", "(|||ﾟДﾟ)", "(＃°Д°)", "(๑•́ ₃•̀๑)",
 "( ;´д\\`)", "( TロT)σ", "(TДT)", "(;´༎ຶД༎ຶ\\`)", "(´; ω ;\\`)"];
(function(){
    var emoticons = extraPowerEmoticons;
    var EmoticonsinsertDom = document.getElementById("EmoticonsinsertDom");
    if (!EmoticonsinsertDom) return;

    EmoticonsinsertDom.style = "position: relative; float: left; line-height: "+
    $(".emojis").height()+"px; margin-left: 0.2rem; background: white;border-radius: 1rem;\
    line-height: 1rem; margin: 0.35rem 0.2rem; padding: 0.25rem; \
    border-bottom: 2px solid #e4e4e4; border-right: 1px solid #f2f2f2;";

    var hidDom = document.createElement("div");
    var hidDomCont = document.createElement("div")
    hidDom.style = "z-index: 9; position: absolute; bottom: 2rem; left: -60px;\
    max-width: 88vw; width: 380px; border-radius: 5px;\
    background: white; display: none; padding: 0.5rem;\
    box-shadow: 0 0 50px #636363;";
    hidDomCont.style = "max-height: 150px; overflow-y: auto; scrollbar-width: thin;"

    for (let i = 0; i < emoticons.length; i++) {
        let emodom = document.createElement("span");
        emodom.setAttribute("class", "emo-single");
        emodom.innerText = emoticons[i];
        emodom.onclick = function(){
            document.getElementById("textarea").value += this.innerText;
        }
        hidDomCont.appendChild(emodom);
    }

    var emostyle = document.createElement("style");
    emostyle.innerHTML = ".emo-single{display: inline-block; white-space: nowrap;\
        padding: 0.3em 0.8em; user-select: none; }\
    .emo-single:hover{background: #f1f1f1; border-radius: 5px;}";
    document.body.append(emostyle);

    document.body.addEventListener("click", function(){
        hidDom.style.display = "none";
    });

    var EmoDoor = document.createElement("p");
    var EmoDoorButton = document.createElement("span");
    EmoDoorButton.innerText = "(OωO)";
    EmoDoorButton.style = "cursor: pointer; user-select: none;";
    EmoDoorButton.setAttribute("attrHidTime", "0");
    EmoDoorButton.addEventListener("click", function(event){
        event.stopPropagation();
        hidDom.style.display = "block";
        var that = this;
        this.innerText = emoticons[Math.floor(Math.random()*emoticons.length)];
        this.attrHidTime = String(new Date().getTime() + 1500);
        setTimeout(function(){
            if (new Date().getTime() > Number(that.attrHidTime)){
                that.innerText = "(OωO)";
            }
        }, 2000);
    });

    EmoDoor.appendChild(EmoDoorButton);
    hidDom.appendChild(hidDomCont);
    EmoticonsinsertDom.appendChild(hidDom);
    EmoticonsinsertDom.appendChild(EmoDoor);
})();

// 点击打开表情
GLOBAL_FLAG_HAS_POPUP = 0;
$('.click_to_show').each(function(){
    $(this).children('.click_board').each(function(){
        let dom = $('#'+$(this).attr('for'));
        dom.click(function(){
            $(this).fadeOut(100);
        });
        $(this).click(function(){
            dom.fadeIn(100);
            window.GLOBAL_FLAG_HAS_POPUP = 1;
        });
    });
});

// 插入表情完毕之后再计算高度，防止插入表情后高度变化
function autoresize(){
    if ($(window).width() > full_size_width) {
        safe_do(function(){
            var sb_height = Math.max($(".sb-left").height(), $(".sb-right").height());
            $(".atcs").css("min-height", sb_height+61);
        });
    }
    safe_do(function(){
        if ($('#comments').length > 0){
            if ($(window).width() < 500){
                $('#comments').parent('.post').css('padding', 0);
            }else{
                $('#comments').parent('.post')[0].style = '';
            }
        }
    });
    safe_do(function(){
        if ($(".post-meta").length > 0){
            $(".post-meta").css("width", $(".atcs").width());
        }
    });
    // 顶部导航栏
    safe_do(function(){
        let gap = $('.top-nav').height() + $('.sb-holder').height() + 1; // 我也不知道为什么要加1
        $('.head').css('padding-bottom', gap + 'px');
        $('.body').css('top', (-gap) + 'px');
    });
}
autoresize();
window.onresize = autoresize;

$(".backtotop").click(function () {
    // 速度曲线：v(t) = k/exp(3t)   int(v(t), t, 0, 1.5) == s  ->  k = 3sexp(9/2)/(exp(9/2)-1)
    var sctop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
    var t = 0;
    var k = sctop*3.0337; // k = sctop*3*Math.exp(9/2) / (Math.exp(9/2) - 1);
    var dt = 0.01;
    var TOfunc = function(){
        sctop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
        if (sctop > 2){
            let v = k/Math.pow(Math.E, 3*t);  t += dt;
            let ds = v*dt;
            if (ds < 3) ds = 3;
            let newY = sctop - ds;
            if (newY < 0) newY = 0;
            window.scrollTo(0, newY);
            setTimeout(TOfunc, dt*1000);
        }
    }
    TOfunc();
    return false;
});

// 评论区添加表情
function insertText(obj, str){
	var m = obj.value.match(/(‹|：)[\S]{1,5}?(›|：)/g);
	if (m){
        if (m.length >= 8) {
            alert("最多添加8个表情！");
            return false;
        }
    }
	obj.value += str;
}

// 图像加载失败事件
$('.post-thumb img').each(function(){
    this.onerror = function(){
        $(this).attr("src", themeUrl+"/s/img/error.jpg");
    }
});

// 评论区头像旋转
$('.avatar').each(function(){
    var delay = 30 + Math.random()*120;  var speed = 600 + Math.random() * 100;
    $(this).css({'animation': 'spin '+speed+'s infinite linear', 'animation-delay': delay+'s'});
});

// 评论区显示@
$('.comment-children .comment-content').each(function(){
    var id = $(this).parents('.comment-body').parents('.comment-children').parents('.comment-body').attr('id');
    var id = $('#'+id+' span[title=author]').eq(0).text();
    id = id.replace(/(^[\s ]+)|([\s ]+$)/g, '');
    // var num = $(this).parents('.comment-body').length - 1;
    if (id){
        var thedom = $(this).children("p");
        thedom.html('<a>@'+id+'</a> '+thedom.html());
    }
});


/* 阅读部分添加导航 */
if ($('.post-content').length == 1){
    // 建创悬浮窗口
    var navdom = $('<div id="level-nav"></div>');
    navdom.append('<div class="outer">目录导航</div>');
    var contentDom = $('<ul class="ctn"></ul>');
    var titles = $('.post-content h1, .post-content h2, .post-content h3, .post-content h4, .post-content h5, .post-content h6');
    var default_rank = ['H1', 'H2', 'H3', 'H4', 'H5', 'H6'];
    var ranks = [0, 0, 0, 0, 0, 0];
    var current_level = 0;
    for (var i = 0; i < titles.length; i++){
        this_level = default_rank.indexOf(titles[i].tagName);
        if (current_level == this_level){
            // 同一级
            ranks[current_level] += 1;
        }else if(current_level < this_level){
            // 建立下一级
            ranks[this_level] += 1;
        }else if(current_level > this_level){
            // 建立上一级
            ranks[this_level] += 1;
            // 清空其他
            for (let j = this_level + 1; j < 6; j++){
                ranks[j] = 0;
            }
        }
        current_level = this_level; // 更新current_level
        padding_text = -1;
        ranks_text = [];
        for (var j = 0; j < 6; j++){
            if (ranks[j] > 0){
                padding_text += 1;
                ranks_text.push(ranks[j]);
            }
        }
        titles_filtered = titles[i].innerText.replace(/^([0-9：:、. ])+/i, '');
        ranks_text = ranks_text.join('.');
        contentDom.append('<li><a href="#title-'+ranks_text+'" style="padding-left: '+padding_text*10+'px">'+ranks_text+'、'+titles_filtered+'</a></li>');
        $(titles[i]).append('<a name="title-'+ranks_text+'" class="title_level">#'+ranks_text+'</a>');
    }
    navdom.append(contentDom);
    if (titles.length > 5 || (
        $('.atcs').height() > 3*$(window).height() && titles.length > 2
    )){
        $('body').append(navdom);
    }
}


// 滚动跟随 两边栏必须要长于屏高才生效
window.onscroll = function(){
    var pos = document.documentElement.scrollTop;
    var baseTop = $('.atcs').offset().top;
    var screenH = $(window).height();
    var left_height = $('.sb-left').height();
    var right_height = $('.sb-right').height();
    if ($(window).width() <= full_size_width || Math.min(left_height, right_height) < screenH) {
        $('.sb-left').removeAttr('style');
        $('.sb-right').removeAttr('style');
        return;
    }
    // 判断侧栏
    var reach_left = baseTop + left_height - screenH;
    var reach_right = baseTop + right_height - screenH;
    var end = $('.body').height() + $('.body').offset().top - screenH;
    var width_left = $('.body').width()*0.22;
    var width_right = $('.body').width()*0.18;
    var offset_left = $('.body').offset().left;
    var offset_right = $('.body').offset().left + $('.body').width() - width_right;
    if (pos > end){
        $('.sb-left').css({'position': 'fixed', 'bottom': pos - end,
                    'left': offset_left, 'width': width_left});
        $('.sb-right').css({'position': 'fixed', 'bottom': pos - end,
                    'left': offset_right, 'width': width_right});          
        return;
    }
    if(pos > reach_left){
        $('.sb-left').css({'position': 'fixed', 'bottom': 0,
                        'left': offset_left, 'width': width_left});
    }else{
        $('.sb-left').removeAttr('style');
    }
    if(pos > reach_right){
        $('.sb-right').css({'position': 'fixed', 'bottom': 0,
                        'left': offset_right, 'width': width_right});
    }else{
        $('.sb-right').removeAttr('style');
    }
}

// 全局按键监控
$("html").on("click", function(e){
    var e = e || window.event
    var elem = e.target;
    // 点击区域外部关闭弹窗
    if (window.GLOBAL_FLAG_HAS_POPUP == 2){
        var popups = $(".click_to_show div");
        for (var i = 0; i < popups.length; i++){
            if (!popups[i].contains(elem)){
                $(".click_to_show div.hidden").css("display", "none");
                window.GLOBAL_FLAG_HAS_POPUP = 0;
            }
        }
    }else if(window.GLOBAL_FLAG_HAS_POPUP == 1){
        window.GLOBAL_FLAG_HAS_POPUP++;
    }
});


/**
 * 按照队列加载资源
 * @param {Array} queue 加载队列 形式：[[url, onloadfunc, onerrfunc], [url, onloadfunc, onerrfunc], ...]
 * queue是一个二维数组
 * queue[i] = [url, onloadfunc, onerrfunc]
 * 其中
 *  - url为字符串 为资源地址
 *  - onloadfunc 为资源加载成功后执行的函数
 *  - onerrfunc 为资源加载失败后执行的函数
 */
function EP_loadSource(queue){
    var domList = [];
    var touchnext = function(){
        let theDom = domList.shift();
        if (!theDom) return;
        document.body.append(theDom);
    }
    for (let index = 0; index < queue.length; index++){
        let url = queue[index][0];
        let onloadfunc = queue[index].length > 1 ? queue[index][1] : function(){};
        let onerrfunc = queue[index].length > 2 ? queue[index][2] : function(){};
        let fileType = url.split("."); fileType = fileType[fileType.length-1].toLowerCase();
        let newDom;
        if (fileType == "css") {
            newDom = document.createElement("link");
            newDom.setAttribute("href", url);
            newDom.setAttribute("rel", "stylesheet");
        }else if (fileType == "js") {
            newDom = document.createElement("script");
            newDom.setAttribute("src", url);
        }else{
            console.error("This source will not be loaded: ", url);
        }
        newDom.onload = function(){onloadfunc();touchnext();};
        newDom.onerror = function(){onerrfunc();touchnext();};
        domList.push(newDom);
    }
    touchnext();
}
/**
 * 页面加载完成后或者{delay}毫秒后执行{func} （只执行一次）
 * @param {function} func (*) 
 * @param {int} delay (ms)
 */
function EP_mustDo(func, delay){
    var done_flag = 0;
    var upperFunc = function(){
        if (done_flag) return;
        func();
        done_flag = 1;
    }
    window.addEventListener("load", upperFunc);
    setTimeout(upperFunc, delay);
}

/**
 * latex公式渲染
 */
(function(){
    var renderfunc = function(){
        renderMathInElement(
            document.getElementsByClassName("post-content")[0],
            // {delimiters: [{left: '$', right: '$', display: false}, {left: '$$', right: '$$', display: false}]} // bug!
            {delimiters: [{left: '$$', right: '$$', display: true}, {left: '$', right: '$', display: false}]}
        );
    }
    var loadLocalFunc = function(){
        EP_loadSource([
            [themeUrl+"/s/katex.min.css"],
            [themeUrl+"/s/katex.min.js"],
            [themeUrl+"/s/auto-render.min.js", renderfunc]
        ]);
    }
    EP_mustDo(function(){
        EP_loadSource([
            ["https://cdn.bootcdn.net/ajax/libs/KaTeX/0.16.0/katex.min.css"],
            ["https://cdn.bootcdn.net/ajax/libs/KaTeX/0.16.0/katex.min.js"],
            ["https://cdn.bootcdn.net/ajax/libs/KaTeX/0.16.0/contrib/auto-render.js", renderfunc, loadLocalFunc]
        ]);
    }, 2000);
})();


/**
 * 图片查看器
 */
 (function(){
    function EP_showImg(imgdom){
        var showDom = document.createElement("div");
        var showDomStyle = "background-image: url("+imgdom.src+"); background-position: center; \
        background-repeat: no-repeat; background-color: rgba(0, 0, 0, 0.6); \
        background-size: contain; width: 100vw; height: 100vh;\
        position: fixed; left: 0; top: 0; z-index: 9999999999; transform-origin: top left;";
        let rate1 = imgdom.width / imgdom.height;
        let rate2 = window.innerWidth / window.innerHeight;
        if (rate1 > 1 && rate2 < 1){
            showDomStyle += "width: 100vmax; height: 100vmin;\
            transform: rotate(90deg); translate(0,-100vmin);\
            left: 100vmin;";
        }else if(rate1 < 1 && rate2 > 1){
            showDomStyle += "width: 100vmin; height: 100vmax;\
            transform: rotate(90deg); translate(0,-100vmin);\
            left: 100vmax;";
        }
        showDom.style = showDomStyle;
        showDom.onclick = function(){
            document.body.removeChild(this);
        };
        document.body.appendChild(showDom);
    }

    var imgs = document.querySelectorAll(".post-content img");
    for (let i = 0; i < imgs.length; i++){
        imgs[i].addEventListener('click', function(){
            EP_showImg(this);
        });
    }
})();

