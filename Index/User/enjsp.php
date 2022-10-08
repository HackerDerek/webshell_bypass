<?php
ini_set("display_errors", "stderr");  //ini_set函数作用：为一个配置选项设置值，

error_reporting(E_ALL);     //显示所有的错误信息
error_reporting(0);


include("../includes/common.php");
$title='混淆加密式';
if($islogins==1){}else exit("<script language='javascript'>window.location.href='../login.php';</script>");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?=$title?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
  <script src="//lib.baomitu.com/layer/2.3/layer.js"></script>
  <script src="//lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../assets/layuiadmin/style/admin.css" media="all">
</head>
<div class="layui-fluid" id="LAY-component-timeline">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?=$title?></div>
<div class="layui-card-body">
<?php
$row=$DB->get_row("SELECT * FROM moyu_daili WHERE user='".$udata['user']."'");
if(isset($_POST['sajm'])){
$price = $conf['mzphp'];
if($udata['rmb']>=$price){
$extension=explode('.',$_FILES['file']['name']);
if (($length = count($extension)) > 1) {
$jie = strtolower($extension[$length - 1]);
}
if($jie=='jsp'){
$DB->query("update `moyu_daili` set `rmb`=`rmb`-{$price} where `id`='{$udata['id']}'");
//加密缓存开始
if(($_FILES["file"]["size"]/1024)>$conf['sizekb']){
exit("<script language='javascript'>alert('上传的PHP文件不能超过限制大小！');window.location.href='mzphp.php';</script>");
}
$app1 = $_SERVER['DOCUMENT_ROOT'].'/Index';
$owner=$udata['id']; //获取当前登陆用户
$file=$_FILES['file']['name']; //获取上传文件名
$time=date("Y-m-d H:i:s"); //获取当前时间
$space=md5($owner.$file.time()); //定义缓存目录名
if (!is_dir($app1.'/includes/download/'.$space.'/')) mkdir($app1.'/includes/download/'.$space.'/'); //创建缓存目录
$cache=$DB->query("INSERT INTO `moyu_cache` (`owner`, `file`, `space`, `type`, `upload`) VALUES ('{$owner}', '{$file}', '{$space}', 'jsp免杀方式1', '{$time}')"); //写入数据表
copy($_FILES['file']['tmp_name'],$app1.'/includes/download/'.$space.'/'.$file.".txt"); //将上传文件保存到缓存目录
if($_POST['url']!=""){file_put_contents(ROOT.'/includes/download/'.$space.'/'.$file.".txt",str_replace('<?php','<?php header("Content-type:text/html;charset=utf-8"); if($_SERVER["HTTP_HOST"]!=\''.$_POST['url'].'\'){echo\''.$_POST['content'].'\';exit();}',file_get_contents(ROOT.'/includes/download/'.$space.'/'.$file.".txt"))); }
include './jspcode.php';
echo "<div style='display: none;'>";
echo "</div>";
//echo "<script type='text/javascript'>layer.msg('加密成功请稍等！',{icon:1});</script>";
echo <<<code
    <script type="text/javascript">
    var down = layer.confirm('免杀成功点击确定下载？', {
      btn: ['确定','取消'],closeBtn:0,icon:1,
      title:'免杀完成'
    }, function(){
      sajmts("$space");
      layer.close(down);
    }, function(){
      layer.msg('您也可以后续在免杀记录里面下载哦！',{icon:5});
    });
    </script>
code;
//echo"<script language='javascript'>setTimeout('sajmts(\"".$space."\")',2000);</script>";
}else{
echo "<script type='text/javascript'>layer.msg('请上传jsp文件！',{icon:5});</script>";
}
}else{
echo "<script type='text/javascript'>layer.msg('您的次数不足无法免杀！',{icon:5});</script>";
}
}
?>
<div class="panel panel-default">
<div class="panel-body">
<h2 class="page-header" style="display:none">欢迎使用</h2>
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief" >
<ul class="layui-tab-title">
<li class="layui-this">webshell免杀</li>
</ul>
<div class="layui-tab-content"></div>
</div>  
<div class="tab-pane active" id="sajm">
<form action="enjsp.php" method="POST"  enctype="multipart/form-data"  class="form-horizontal layui-form" role="form" >						 
<blockquote class="layui-elem-quote">jsp脚本免杀,暂时不支持jspx。<a rel="nofollow" href="tencent://message/?uin=<?php echo $conf["kfqq"] ?>&amp;Menu=yes" >作者：<?php echo $conf["kfqq"] ?> </a></blockquote>
<div class="layui-form-item">
<label class="layui-form-label">文件类型</label>
<div class="layui-input-block">
<input name="jsp" type="checkbox" class="checkbox" title="jsp" value="1" />
<input name="jsp" type="checkbox" class="checkbox" title="jspx" value="2" />
</div>
</div>
<table class="layui-table layui-form" lay-even="" lay-skin="nob">
<div class="layer-text" style="padding:20px 0 10px;">
<fieldset class="layui-elem-field layui-field-title">
<legend>其他功能</legend>
</fieldset>
</div>
<div class="layui-form-item">
<label class="layui-form-label">注释内容</label>
<div class="layui-input-block">
<input type="text" name="comment" class="layui-input" placeholder="不需要注释留空" />
</div>
</div> 	
<div class="layui-form-item">
<label class="layui-form-label">选择文件</label>
<div class="layui-input-block">
<input type="file" name="file" id="file"/>
</div>
</div>
</div>
<!--  <div class="layui-form-item">
<label class="layui-form-label">免杀剩余次数</label>
<div class="layui-input-block">
<div class="layui-form-mid layui-word-aux" style="color:#F60 !important;font-family: arial"><?php echo $conf['mzphp'] ?>次
</div>
</div> -->
</div> 			
<div class="layui-form-item">
<div class="layui-input-block">
<button class="layui-btn" id="submit" name="sajm" lay-submit lay-filter="formDemo">立即提交</button>
</div>
</div>
</form>
<blockquote class="layui-elem-quote layui-quote-nm">
温馨提醒：此方式可过安全狗、D盾、云锁，其它自测！
</blockquote>
</div>
</div>
</div>
</div>
</div>
<script>
$(function(){ ReadyDashboard.init(); });
setTimeout("document.getElementById('ts').style.display = 'none';", 2000);
function sajmts(id)
{
window.location.href='../down.php?id='+id;
}
</script>
<script src="../assets/layuiadmin/layui/layui.js"></script>  
  <script>
  layui.config({
    base: '../assets/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'form'], function(){
    var $ = layui.$
    ,admin = layui.admin
    ,element = layui.element
    ,form = layui.form;
    
    form.render(null, 'component-form-element');
    element.render('breadcrumb', 'breadcrumb');
    
    form.on('submit(component-form-element)', function(data){
      layer.msg(JSON.stringify(data.field));
      return false;
    });
  });
  </script>
</body>
</html> 