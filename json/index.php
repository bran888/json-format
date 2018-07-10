

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>JSON在线解析及格式化验证 - JSON.cn</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="MobileOptimized" content="320" />
    <meta http-equiv="Cache-Control" content="max-age=7200" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="baidu-site-verification" content="" />
    <meta name="google-site-verification" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all" />
    <meta name="author" content="json" />

<meta name="keywords" content="json,json在线解析,json格式化,json格式验证,json转xml,xml转json"/>
<meta name="description" content="Json中文网致力于在中国推广Json,并提供相关的Json解析、验证、格式化、压缩、编辑器以及Json与XML相互转换等服务"/>

    <link href="/static/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/css/font-awesome.min.css" rel="stylesheet">
    <link href="/static/css/base.css" rel="stylesheet">
    <style></style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Favicons -->
</head>
<body style="over-flow:hidden;">
  <header class="header">
      <div class="row-fluid" >
          <div class="col-md-2" style="position:relative;">
              <a class="logo" href="/">
                Json<span style="color:#4A5560;"> format</span></a>

          </div>
          <nav class="col-md-7" style="padding:10px 0; "  align="right">
              <div  class="navi" >
                  <a href="/json/index.php" data-placement="bottom">在线解析</a>
                  <!--<a href="http://lab.json.cn/" target="_blank"  data-placement="bottom">
                    <span class="red">JSON实验室</span>
                </a>
                  <a href="/wiki.html"  data-placement="bottom">什么是JSON</a>
                  <a href="/code.html"  data-placement="bottom">JSON解析代码</a>
                  <a href="/component.html"  data-placement="bottom">JSON组件</a>
		-->
              </div>
          </nav>
          <br style="clear:both;" />
      </div>
  </header>


<main class="row-fluid" style="height:85%;min-height:200px;">
    <div id="leftinput" class="col-md-2" style="padding:0px;height:auto!important;min-height:200px;">
        <textarea id="json-src" placeholder="在此输入json字符串或XML字符串..."   class="form-control"
	style="height:100%;height: 87vh;min-height:520px;padding:10px 10px 10px 30px;border:0;border-right:solid 1px #E5EBEE;border-bottom:solid 1px #eee;border-radius:0;resize: none; outline:none;font-size:10px;"></textarea>
    </div>
    <div id="rightshow" class="col-md-10" style="padding:0;position:relative;height:auto!important;min-height:200px;">
        <div  class="tool" style="position:absolute;">
            <a href="#" class="tip hideinput" title="隐藏输入框"  data-placement="bottom"><i class="fa fa-arrow-left"></i></a>
	    <a href="#" class="tip showinput" title="展开输入框"  data-placement="bottom"><i class="fa fa-arrow-right"></i></a>
            <a href="#" class="tip zip" title="压缩"  data-placement="bottom"><i class="fa fa-database"></i></a>
            <a href="#" class="tip xml" title="转XML"  data-placement="bottom"><i class="fa fa-file-excel-o"></i></a>
            <a href="#" class="tip shown"  title="显示行号"  data-placement="bottom"><i class="glyphicon glyphicon-sort-by-order"></i></a>
            <a href="#" class="tip clear" title="清空"  data-placement="bottom"><i class="fa fa-trash"></i></a>
            <a href="#" class="tip save" title="保存"  data-placement="bottom"><i class="fa fa-download"></i></a>
            <a href="#" class="tip copy" title="复制" data-clipboard-target="#json-target"  data-placement="bottom"><i class="fa fa-copy"></i></a>
            <a href="#" class="tip compress" title="折叠"  data-placement="bottom"><i class="fa fa-compress"></i></a>
        </div>
        <div id="right-box"  style="width:100%;min-height:520px;border:solid 1px #f6f6f6;border-radius:0;resize: none;overflow-y:scroll; outline:none;position:relative;font-size:12px;padding-top:40px;">
            <div id="line-num" style="background-color:#fafafa;padding:0px 8px;float:left;border-right:dashed 1px #E5EBEE;display:none;z-index:-1;color:#999;position:absolute;text-align:center;over-flow:hidden;">
                <div>0</div>
            </div>
            <div class="ro" id="json-target" style="padding:0px 25px;white-space: pre-line;">
            </div>
        </div>
        <form id="form-save" method="POST"><input type="hidden" value="" id="txt-content" name="content"></form>
    </div>
    <br style="clear:both;" />
</main>
<link href="/static/css/jquery.numberedtextarea.css" rel="stylesheet">
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/jquery.message.js"></script>
<script src="/static/js/jquery.json.js"></script>
<script src="/static/js/jquery.xml2json.js"></script>
<script src="/static/js/jquery.json2xml.js"></script>
<script src="/static/js/json2.js"></script>
<script src="/static/js/jsonlint.js"></script>
<script src="/static/js/clipboard.min.js"></script>
<script src="/static/js/FileSaver.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script src="/static/js/jquery.numberedtextarea.js"></script>
<script type="text/javascript">
$('textarea').numberedtextarea();
var current_json = '';
var current_json_str = '';
var xml_flag = false;
var zip_flag = false;
var shown_flag = false;
var compress_flag = false;
$('.tip').tooltip();
function init(){
    xml_flag = false;
    zip_flag = false;
    shown_flag = false;
    compress_flag = false;
    renderLine();
    $('.xml').attr('style','color:#999;');
    $('.zip').attr('style','color:#999;');

}
$('#json-src').keyup(function(){
    init();
    var content = $.trim($(this).val());
    var result = '';
    if (content!='') {
        //如果是xml,那么转换为json
        if (content.substr(0,1) === '<' && content.substr(-1,1) === '>') {
            try{
                var json_obj = $.xml2json(content);
                content = JSON.stringify(json_obj);
            }catch(e){
                result = '解析错误：<span style="color: #f1592a;font-weight:bold;">' + e.message + '</span>';
                current_json_str = result;
                $('#json-target').html(result);
                return false;
            }

        }
        try{
            current_json = jsonlint.parse(content);
            current_json_str = JSON.stringify(current_json);
            //current_json = JSON.parse(content);
            result = new JSONFormat(content,4).toString();
        }catch(e){
            result = '<span style="color: #f1592a;font-weight:bold;">' + e + '</span>';
            current_json_str = result;
        }

        $('#json-target').html(result);
    }else{
        $('#json-target').html('');
    }

});
$('.xml').click(function(){
    if (xml_flag) {
        $('#json-src').keyup();
    }else{
        var result = $.json2xml(current_json);
        $('#json-target').html('<textarea style="width:100%;position:absolute;height: 80vh;min-height:480px;border:0;resize:none;">'+result+'</textarea>');
        xml_flag = true;
        $(this).attr('style','color:#15b374;');
    }

});

$('.hideinput').click(function(){
	$('#leftinput').removeClass('col-md-2');
	$('#leftinput').addClass('col-md-0');
	$('#leftinput').css('height', '0%');
        $('#leftinput').css('display', 'none');

	$('#rightshow').removeClass('col-md-10');
	$('#rightshow').addClass('col-md-12');

});

$('.showinput').click(function(){
        $('#leftinput').addClass('col-md-2');
        $('#leftinput').removeClass('col-md-0');
        $('#leftinput').css('height', '100%');
	$('#leftinput').css('display', 'block');

        $('#rightshow').addClass('col-md-10');
        $('#rightshow').removeClass('col-md-12');

});




$('.shown').click(function(){
    if (!shown_flag) {
        renderLine();
        $('#line-num').show();
        $('.numberedtextarea-line-numbers').show();
        shown_flag = true;
        $(this).attr('style','color:#15b374;');
    }else{
        $('#line-num').hide();
        $('.numberedtextarea-line-numbers').hide();
        shown_flag = false;
        $(this).attr('style','color:#999;');
    }
});
function renderLine(){
    var line_num = $('#json-target').height()/20;
    $('#line-num').html("");
    var line_num_html = "";
    for (var i = 1; i < line_num+1; i++) {
        line_num_html += "<div>"+i+"<div>";
    }
    $('#line-num').html(line_num_html);
}
$('.zip').click(function(){
    if (zip_flag) {
        $('#json-src').keyup();
    }else{
        $('#json-target').html(current_json_str);
        zip_flag = true;
        $(this).attr('style','color:#15b374;');
    }

});
$('.compress').click(function(){
    if(!compress_flag){
        $(this).attr('style','color:#15b374;');
        //$(this).attr('title','取消折叠').tooltip('fixTitle').tooltip('show');
        $($(".fa-minus-square-o").toArray().reverse()).click();
        compress_flag = true;
    }else{
        while($(".fa-plus-square-o").length>0){
            $(".fa-plus-square-o").click();
        }
        compress_flag = false;
        $(this).attr('style','color:#555;');
        $(this).attr('title','折叠').tooltip('fixTitle').tooltip('show');
    }
});
$('.clear').click(function(){
     $('#json-src').val('');
     $('#json-target').html('');
});
(function($){
   $.fn.innerText = function(msg) {
         if (msg) {
            if (document.body.innerText) {
               for (var i in this) {
                  this[i].innerText = msg;
               }
            } else {
               for (var i in this) {
                  this[i].innerHTML.replace(/&amp;lt;br&amp;gt;/gi,"n").replace(/(&amp;lt;([^&amp;gt;]+)&amp;gt;)/gi, "");
               }
            }
            return this;
         } else {
            if (document.body.innerText) {
               return this[0].innerText;
            } else {
               return this[0].innerHTML.replace(/&amp;lt;br&amp;gt;/gi,"n").replace(/(&amp;lt;([^&amp;gt;]+)&amp;gt;)/gi, "");
            }
         }
   };
})(jQuery);
$('.save').click(function(){
    // var content = JSON.stringify(current_json);
    // $('#txt-content').val(content);
    //var text = "hell world";
    var html = $('#json-target').html().replace(/\n/g,'<br/>').replace(/\n/g,'<br>');
    var text = $('#json-target').innerText().replace('　　', '    ');
    var blob = new Blob([text], {type: "application/json;charset=utf-8"});
    var timestamp=new Date().getTime();
    saveAs(blob, "format."+timestamp+".json");
});
$('.copy').click(function(){
    //$.msg("成功复制到粘贴板","color:#00D69C;");
    // $(this).tooltip('toggle')
    //       .attr('data-original-title', "复制成功！")
    //       .tooltip('fixTitle')
    //       .tooltip('toggle');
});
var clipboard = new Clipboard('.copy');
$('#json-src').keyup();
</script>




</body>
</html>

