Vblog
---

截图：
![IMG](screenshot.png)

演示：http://blog.lljh.bid/

**启用主题后无法正常评论，请在[后台]->[设置]->[评论]里关闭```开启反垃圾保护```这一选项☑**
**由于造成原因尚不明确，强烈建议用评论过滤插件代替！！**

---

本主题支持无插件显示表情，可以在评论和发文章时使用：
```
：滑稽：：喷：：彩虹：：阴险：：怒：：笑眼：：黑线：：玫瑰：：乖：：汗：：惊哭：：酷：：狂汗：：冷：：真棒：：不高兴：：大哭：：咖啡：：yeah：：ojbk：
```
还有-弱-智-无-用-的HTML简化，同样也可以在评论和发文章时使用：```【html标签 你要写的内容 重复html标签】```
比如：
```
【del我是删除线del】会转化成-> <del>我是删除线</del>
【b我我我我b】会转化成-> <b>我我我我</b>
```
*（注意：标签为script的会自动过滤掉，以阻止恶意攻击）*

---

关于在页面内引用JS（如谷歌广告的JS文件）后无法显示图片（JS拖慢页面加载）：
把：
```
<script type="text/javascript" src="//example.com/xxx.js"></script>
```
写成：
```
<script type="text/javascript">
(function(){
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.src = "//example.com/xxx.js";
    var tmp = document.getElementsByTagName('script')[0];
    tmp.parentNode.insertBefore(s, tmp);
})();
</script>
```
即可。（后台有示例）

-----------------
-------END-------

-----------------