// 功能启用如下 可自定义启用或者关闭功能
const EP_EN_CONFIG = {
    'emo-text': true,     // 颜文字表情
    'title-nav': true,    // 文章内部大小标题导航
    'quick-edit': true,   // 快速编辑文章
    'latex-rule': true,   // latex公式渲染
    'img-viewer': true,   // 图片查看器
    'back-to-top': true   // 返回顶部
}


/**
 * ##############################
 * ##############################
 * ## 可初略浏览代码块外部的注释 ##
 * ##############################
 * ##############################
*/


/**
 * 评论框处显示颜表情
 * 
 * 使用：在评论框合适位置添加`<div id="EmoticonsinsertDom"></div>`
 * 需要新增颜表情，修改数组extraPowerEmoticons
 * 注意表情里面有：` 会被错误解析，建议关闭评论Markdown解析
 */
var extraPowerEmoticons = ["w(ﾟДﾟ)w", "(๑•̀ㅂ•́)و✧", "o(￣▽￣)d", "(//▽//)", "(￣∀￣)", "(ง ˙o˙)ว",
"(｡･∀･)ﾉﾞ", "(*￣3￣)╭", "(:3[▓▓]", "_(:з」∠)_", "(●´∀｀●)", "(¯﹃¯)",
"(๑•́ ₃ •̀๑)", "♪(^∇^*)", "(`･ω･´)", "(*´∀｀)ノ", "(つд⊂)", "(°ー°〃)",
"(`ε´ )", "<(｀^′)>", "(｀д′)", "╰（‵□′）╯", "(。皿。メ)", "(╯￣Д￣)╯╘═╛", "σ`∀´)",
"( ´ー`)", "( ﾟ 3ﾟ)", "ﾟ∀ﾟ)σ", "( ˇωˇ)", "[]~(￣▽￣)~",
"|д` )", "(`ヮ´ )", "(｡◕∀◕｡)", "ᕕ( ᐛ )ᕗ", "( ›´ω`‹ )", "( ﾟ∀。)", "ฅ(^ω^ฅ)",
"(  д ) ﾟ ﾟ", "Σ(っ °Д °;)っ", "(|||ﾟДﾟ)", "(＃°Д°)", "(๑•́ ₃•̀๑)",
"( ;´д`)", "( TロT)σ", "(TДT)", "(;´༎ຶД༎ຶ`)", "(´; ω ;`)"];
(function(){
    if (!EP_EN_CONFIG['emo-text']) return;
    var emoticons = extraPowerEmoticons;
    var EmoticonsinsertDom = document.getElementById("EmoticonsinsertDom");
    if (!EmoticonsinsertDom) return;

    EmoticonsinsertDom.style = "position: relative;";

    var hidDom = document.createElement("div");
    var hidDomCont = document.createElement("div")
    hidDom.style = "z-index: 9; position: absolute; bottom: 1.1rem; left: 0;\
    max-width: 88vw; width: 550px;\
    border: 1px solid #cdcdcd; border-radius: 5px;\
    background: white; display: none; padding: 0.5rem;";
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
        padding: 0.3em 0.8em; cursor: pointer; user-select: none; }\
    .emo-single:hover{background: #f1f1f1; border-radius: 5px;}";
    document.body.append(emostyle);

    document.body.addEventListener("click", function(){
        hidDom.style.display = "none";
    });

    var EmoDoor = document.createElement("p");
    var EmoDoorButton = document.createElement("span");
    EmoDoorButton.innerText = "(OwO)";
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



/**
 * 文章目录导航
 * 
 * 注意主题配合 正文class需要为post-content
 */
(function(){
    if (!EP_EN_CONFIG['title-nav']) return;
    if (document.querySelectorAll(".post-content").length != 1) return;
    // 建创悬浮窗口
    var navdom = document.createElement("div");
    navdom.setAttribute("id", "level-nav")
    navdom.innerHTML += ('<div class="level-nav-outer">目录导航</div>');
    var contentDom = document.createElement("ul");
    contentDom.setAttribute("class", "ctn");

    var titles = document.querySelectorAll('.post-content h1, .post-content h2, .post-content h3, .post-content h4, .post-content h5, .post-content h6');
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
        contentDom.innerHTML += ('<li><a href="#title-'+ranks_text+'" style="padding-left: '+padding_text*10+'px">'+ranks_text+'、'+titles_filtered+'</a></li>');
        titles[i].innerHTML += ('&nbsp;<sup><a name="title-'+ranks_text+'" class="title_level">#'+ranks_text+'</a></sup>');
    }
    navdom.append(contentDom);
    if (titles.length > 5){
        document.body.append(navdom);
    }

    var levelstyle = document.createElement("style");
    levelstyle.innerHTML = "#level-nav{\
        position: fixed; background-color: white; bottom: -13.35rem;\
        right: 2vw; padding: 0.9rem; width: 18rem; border: 2px solid #d9d9d9;\
        transition: all 0.3s; border-radius: 2px 2px 0 0;opacity: 0.85; font-size: 0.9em;\
    }\
    #level-nav .ctn{\
        height: 11.5rem; overflow-y: auto; scrollbar-width: thin;\
        padding: 0; margin: 0\
    }\
    #level-nav .level-nav-outer{\
        position: absolute; height: 1.7rem;top: -1.7rem; right: 2rem;\
        font-size: 0.9rem; font-weight: bold;\
        padding: 0 0.5rem; text-align: center;line-height: 1.7rem;\
        border: 2px solid #d9d9d9;border-width: 2px 2px 0 2px;\
        border-radius: 2px 2px 0 0;background-color: white; color: #434343;\
    }\
    #level-nav:hover{\
        opacity: 1;bottom: 0;\
    }\
    #level-nav li{\
        list-style: none; font-size: 0.9rem;\
        line-height: 1.3rem; text-overflow: ellipsis;\
        overflow: hidden; white-space: nowrap;\
    }\
    #level-nav li + li{\
        padding-top: 0.4rem;\
    }\
    #level-nav li b{\
        display: block; margin-bottom: 0.6rem; text-align: center;\
    }";
    document.body.append(levelstyle);
})();

var basepath = "/"; // 其他地方可能会用到 所以放外边了
var GLOBAL_VARS_EMO_JS = {};


/**
 * 快速编辑文章
 * 
 * 注意标题class需要为post-title
 * PC端用鼠标选中待编辑文章的标题即可
 * 移动端选中后，需要点击一下标题两旁等高的空白
 */
(function(){
    if (!EP_EN_CONFIG['quick-edit']) return;
    // 首先得到base url目的是得到基础路径
    // link标签href内容是否含有当前域名以及/usr/路径，截取域名和/usr/路径之间字符作为base url
    basepath = "/";
    var abAdminPath = "admin/write-post.php?cid=";
    var outterlink = document.getElementsByTagName("link");
    for (let i = 0; i < outterlink.length; i++) {
        if (
            !(outterlink[i].href.match(document.location.host))
            &&
            !(outterlink[i].href.match(/^http.?:|^\/\//i))
        ) continue; // 非内部资源跳过
        let subbaseurl = outterlink[i].href.replace(document.location.host, "");
            subbaseurl = subbaseurl.replace(/^.*?\/\//i, "");
        let testbasepath = subbaseurl.match(/(^.*?)\/usr/i);
        if (!testbasepath) continue;
        basepath = document.location.host + "/" + testbasepath[1] + "/";
        basepath = document.location.protocol + "//" + basepath.replace("//", "/");
    }

    console.log("Base Path: " + basepath);

    var titleList = document.getElementsByClassName("post-title");
    for (let i = 0; i < titleList.length; i++) {
        // 通过连接获取cid
        let refdom = titleList[i].getElementsByTagName("a")[0];
        if (!refdom) continue;
        refcid = refdom.href.match(/(\d+)/g);
        if (!refcid) continue;
        let doEvent = function(){
            try{
                if (!window.getSelection) return;
                var sel = window.getSelection();
                var range = sel.getRangeAt(0);
                if (range.startOffset == 0 && range.endOffset == range.commonAncestorContainer.length
                    && range.startContainer == range.endContainer){
                    document.location.href = basepath + abAdminPath + refcid[refcid.length-1];
                }
            }catch(e){}
        }
        titleList[i].addEventListener("mousemove", doEvent);
        titleList[i].addEventListener("touchend", doEvent);
    }
})();


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
 * Latex公式渲染
 */
 (function(){
    var renderfunc = function(){
        renderMathInElement(
            document.getElementsByClassName("post-content")[0],
            {delimiters: [{left: '$', right: '$', display: false}, {left: '$$', right: '$$', display: false}]}
        );
    }
    var loadLocalFunc = function(){
        // 加载本地资源 - 手动修改地址即可
        // EP_loadSource([
        //     [basepath+"/usr/theme/hufman/s/katex.min.css"],
        //     [basepath+"/usr/theme/hufman/s/katex.min.js"],
        //     [basepath+"/usr/theme/hufman/s/auto-render.min.js", renderfunc]
        // ]);
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
 * 图片查看器 （自动旋转）
 */
(function(){
    if (!EP_EN_CONFIG['img-viewer']) return;
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


/**
 * 返回顶部
 */
(function(){
    if (!EP_EN_CONFIG['back-to-top']) return;
    var backDom = document.createElement("div");
    if (window.innerWidth > 800){
        backDom.style = "width: 0px; height: 0px; position: fixed; left: 5.5vw; \
        bottom: 0px; display: none; z-index: 2; \
        border-left: 2.5vw solid transparent; border-right: 2.5vw solid transparent; \
        border-bottom: 2vw solid rgba(0,0,0,.2);";
    }else{
        backDom.style = "width: 0; height: 0; position: fixed; \
        left: 1.5rem; bottom: 0; display: none; z-index: 2;\
        border-left: 1.5rem solid transparent;\
        border-right: 1.5rem solid transparent;\
        border-bottom: 1.2rem solid rgba(0,0,0,.2);";
    }
    window.addEventListener("scroll", function(){
        var sctop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
        if (sctop > window.innerHeight*1.2){
            backDom.style.display = "block";
        }else{
            backDom.style.display = "none";
        }
    });
    backDom.addEventListener("click", function(){
        /* 
        速度曲线：v(t) = k/exp(3t)   int(v(t), t, 0, 1.5) == s  ->  k = 3sexp(9/2)/(exp(9/2)-1)
         */
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
    });
    document.body.appendChild(backDom);
})();