/*

评论框颜文字表情：在评论框附件加上`<div id="EmoticonsinsertDom"></div>`即可。

双击编辑文章：双击与文章标题等高两侧的空白即可编辑，404需手动修改变量basepath。

目录导航：标题数目需要大于5才显示。

*/


// 评论框颜文字表情
(function(){
    var emoticons = ["w(ﾟДﾟ)w", "(๑•̀ㅂ•́)و✧", "o(￣▽￣)d", "(//▽//)", "(￣∀￣)", "(ง ˙o˙)ว",
    "(｡･∀･)ﾉﾞ", "(*￣3￣)╭", "(:3[▓▓]", "_(:з」∠)_", "(●´∀｀●)", "(¯﹃¯)",
    "(๑•́ ₃ •̀๑)", "♪(^∇^*)", "(`･ω･´)", "(*´∀｀)ノ", "(つд⊂)",
    "(`ε´ )", "<(｀^′)>", "(｀д′)", "╰（‵□′）╯", "(。皿。メ)", "(╯￣Д￣)╯╘═╛", "σ`∀´)",
    "( ´ー`)", "( ﾟ 3ﾟ)", "ﾟ∀ﾟ)σ", "( ˇωˇ)", "[]~(￣▽￣)~",
    "|д` )", "(`ヮ´ )", "(｡◕∀◕｡)", "ᕕ( ᐛ )ᕗ", "( ›´ω`‹ )", "( ﾟ∀。)", "ฅ(^ω^ฅ)",
    "(  д ) ﾟ ﾟ", "Σ(っ °Д °;)っ", "(|||ﾟДﾟ)", "(๑•́ ₃•̀๑)",
    "( ;´д`)", "( TロT)σ", "(TДT)", "(;´༎ຶД༎ຶ`)", "(´; ω ;`)"];

    var EmoticonsinsertDom = document.getElementById("EmoticonsinsertDom");
    if (!EmoticonsinsertDom) return;

    EmoticonsinsertDom.style = "position: relative;";

    var EmoDoor = document.createElement("p");
    var EmoDoorButton = document.createElement("span");
    EmoDoorButton.innerText = "[颜]";
    EmoDoorButton.style = "cursor: pointer; user-select: none;";
    EmoDoorButton.setAttribute("attrHidTime", "0");
    EmoDoorButton.onclick = function(){
        var that = this;
        this.innerText = emoticons[Math.floor(Math.random()*emoticons.length)];
        this.attrHidTime = String(new Date().getTime() + 1500);
        setTimeout(function(){
            if (new Date().getTime() > Number(that.attrHidTime)){
                that.innerText = "[颜]";
            }
        }, 2000);
    }

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
            hidDom.style.display = "none";
        }
        hidDomCont.appendChild(emodom);
    }

    var emostyle = document.createElement("style");
    emostyle.innerHTML = ".emo-single{display: inline-block; white-space: nowrap;\
        padding: 0.3em 0.8em; cursor: pointer; user-select: none; }\
    .emo-single:hover{background: #f1f1f1; border-radius: 5px;}";
    document.body.append(emostyle);

    EmoDoorButton.addEventListener("click", function(event){
        event.stopPropagation();
        hidDom.style.display = "block";
    });

    document.body.addEventListener("click", function(){
        hidDom.style.display = "none";
    });

    EmoDoor.appendChild(EmoDoorButton);
    hidDom.appendChild(hidDomCont);
    EmoticonsinsertDom.appendChild(hidDom);
    EmoticonsinsertDom.appendChild(EmoDoor);
})();

// 文章目录导航
(function(){
    if (document.querySelectorAll(".post-content").length != 1) return;
    // 建创悬浮窗口
    var navdom = document.createElement("div");
    navdom.setAttribute("id", "level-nav")
    navdom.innerHTML += ('<div class="outer">目录导航</div>');
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
        position: fixed; background-color: white; bottom: -13rem;\
        right: 2vw; padding: 0.9rem; width: 18rem; border: 2px solid #d9d9d9;\
        transition: all 0.3s; border-radius: 2px 2px 0 0;opacity: 0.85; font-size: 0.9em;\
    }\
    #level-nav .ctn{\
        height: 11.5rem; overflow-y: auto; scrollbar-width: thin;\
        padding: 0; margin: 0\
    }\
    #level-nav .outer{\
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

// 快速编辑文章
(function(){
    // 首先得到base url目的是得到基础路径
    // 原理：link标签href内容是否含有当前域名以及/usr/路径，截取域名和/usr/路径之间字符作为base url
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
        titleList[i].addEventListener("dblclick", function(){
            try{
                if (!window.getSelection) return;
                var sel = window.getSelection();
                var range = sel.getRangeAt(0);
                if (range.startOffset == 0 && range.endOffset == range.commonAncestorContainer.length
                    && range.startContainer == range.endContainer){
                    document.location.href = basepath + abAdminPath + refcid[refcid.length-1];
                }
            }catch(e){}
        });
    }
})();