/**
 * 鍥剧墖鏀惧ぇ闀�
 * Author : Postbird
 * Website: http://www.ptbird.cn
 * License: MIT
 * http://www.jq22.com/jquery-info15705
 */
var PostbirdImgGlass = {
    init: function (objParam) {
        this.domSelector = objParam.domSelector || "img";
        this.width = objParam.width || "auto";
        this.height = objParam.height || "auto";
        this.boxClassName = objParam.boxClassName || 'postbird-img-glass-box';
        this.boxBgColor = objParam.bgColor || 'rgba(0,0,0,0.8)';
        this.animation = objParam.animation || false;
        this.startGlass();
        this.box = this.initImageClassContainer();
    },
    initImageClassContainer: function () {
        var _this = this,
            img = document.createElement('img');
        $(img).css('max-width', 'auto');
        img.draggable = false;
        var box = document.createElement("div");
        box.style = _this.boxStyle;
        box.className = _this.boxClassName;
        box.appendChild(img);
        box.onclick = function(){
            _this.hideImageGlass();
        };
        document.body.insertBefore(box, document.body.childNodes[0]);
        this.initCssClass();
        return box;
    },
    startGlass: function () {
        var domList = document.querySelectorAll(this.domSelector);
        var _this = this;
        for (var i = 0, len = domList.length; i < len; i++) {
            domList[i].style.cursor = 'zoom-in';
            domList[i].addEventListener('click', function (event) {
                var target = event.target || event.srcElement;
                _this.showImageGlass(target.getAttribute('src'));
            }, false);
        }
    },
    showImageGlass: function (src) {
        this.box.childNodes[0].src = src;
        this.box.style.display = 'block';
        if (this.animation) {
            this.addCssAnimation();
        }
    },
    hideImageGlass: function () {
        this.box.style.display = 'none';
        if (this.animation) {
            this.removeCssAnimation();
        }
    },
    addCssAnimation: function () {
        this.box.className = this.box.className + ' postbird-img-glass-box-move';
    },
    removeCssAnimation: function () {
        this.box.className = this.box.className.replace(' postbird-img-glass-box-move', '');
    },
    initCssClass: function () {
        var style = document.createElement('style');
        var styleContent = '.' + this.boxClassName + '{position:fixed;top:0;left:0;width:100%;height:100%;text-align:center;cursor:zoom-out;background-color:' + this.boxBgColor + ';display:none;text-align:center;overflow:hidden;z-index:9999;}';
        styleContent += '.' + this.boxClassName + ' img {position:relative;top:50%;transform:translateY(-50%);max-width:90%;}';
        styleContent += '.postbird-img-glass-box-move{animation:postbird-img-glass .5s;-webkit-animation:postbird-img-glass .5s;-moz-animation:postbird-img-glass .5s;-o-animation:postbird-img-glass .5s;animation-fill-mode:forwards;-o-animation-fill-mode:forwards;-moz-animation-fill-mode:forwards;-webkit-animation-fill-mode:forwards}@-moz-keyframes postbird-img-glass{from{opacity:0;width:100%;height:100%;transform:translateY(-200px)}to{opacity:1;width:100%;height:100%;transform:translateY(0)}}@-webkit-keyframes postbird-img-glass{from{opacity:0;width:100%;height:100%;transform:translateY(-200px)}to{opacity:1;width:100%;height:100%;transform:translateY(0)}}@-o-keyframes postbird-img-glass{from{opacity:0;width:100%;height:100%;transform:translateY(-200px)}to{opacity:1;width:100%;height:100%;transform:translateY(0)}}@keyframes postbird-img-glass{from{opacity:0;width:100%;height:100%;transform:translateY(-200px)}to{opacity:1;width:100%;height:100%;transform:translateY(0)}}';
        style.innerHTML = styleContent;
        document.head.appendChild(style);
    }
};