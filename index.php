<!DOCTYPE html>
<?php
      //ad标题
    //$adtitle=$_POST["adtitle"];
    $adtitle=isset( $_POST['adtitle'] ) ? trim(htmlspecialchars($_POST['adtitle'], ENT_QUOTES)) : '';
      //ad超链接地址
    //$adurl=$_POST["adurl"];
    $adurl= isset($_POST['adurl'] ) ? trim(htmlspecialchars($_POST['adurl'], ENT_QUOTES)) : '';
    //ad图片地址
    //$adimg=$_POST["adimg"];
    $adimg= isset($_POST['adimg'] ) ? trim(htmlspecialchars($_POST['adimg'], ENT_QUOTES)) : '';
     
      //ad描述
    $adDescription=$_POST["adDescription"];
    //  //$adDescription= isset($_POST['adDescription'] ) ? trim(htmlspecialchars($_POST['adDescription'], ENT_QUOTES)) : '';
   
    //页码初始化
    //$page=$_POST['page'];
   
    //自动生成随机api
    /*
     $adtitle='LaokNAS网络技术';
     $adurl="https://www.laoknas.com/";
     $adimg="https://api.laoknas.com/image/index.php?type=json&category=风景&mode=0";
     $result_api = file_get_contents($adimg);
     $userdata_api= json_decode($result_api,true);
     $adimg= $userdata_api['Url'];
     $adDescription='随机图片API自动生成,网络技术文章分享';
*/
     //初始化数据
    $file = 'orders.txt';//用户订单文件
    $dir="userdata";//存储用户数据目录    
    //设置每页显示个数,默认17
    $page_n=21;
     //$token="";//提交表单触发生产token,验证是否提交
    if ($adtitle<>null && $adurl<>null && $adimg<>null){
        
            // if (strlen($adurl) > 100 || !preg_match("/\b(?:(?:https?|ftp|http):\/\/|\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $adurl))
            // //验证url
            // {
            //     echo "<script>alert ('广告超级链接无效。')</script>";
            // }
        
        //执行写入数据
        writejson($adtitle,$adurl,$adimg,$adDescription);
        //读取订单编号数据返回为数组
        $adorders=(readjson($file));
        
        $page=$_GET['page'];
        //$page=2;
        
    }else{
        //$token如果为空，只进行只读。
        $page=$_GET['page'];
        $adorders=(readjson($file));
        
    }
    
    function page(){
                $page_n=10;
        $page_num=ceil(count($adorders)/$page_n);
        
        for ($page_x=1;$page_x<=$page_num;$page_x++){
            echo '<a>'.$page_x.'</a>';
        }
    }

//写入生成的订单数据到orders.txt中及用户数据

//普通数据转为json格式
function txttojson($json){
    
        foreach ( $json as $key => $value ) {  
                
        $json[$key] = urlencode ( $value );
                
        } 
        
    return $json;
}

//传入广告标题,广告超链接,广告图片,广告描述
function writejson($adtitle,$adurl,$adimg,$adDescription,$file = 'orders.txt',$dir="userdata"){
    //ad数据
    $addata = array("orders"=>$orders,"adtitle"=>$adtitle,"adurl"=>$adurl,"adimg"=>$adimg,"adDescription"=>$adDescription);
    $addata=txttojson($addata);
    
    //存入用户数据
    $orders=date('Y').time();//生成订单编号
   // $dir="userdata";//存储用户数据目录
    $filename=$dir."/".$orders.'.txt';
    //header('Content-type:text/json');
    file_put_contents($filename,urldecode(json_encode($addata)));//写入以订单编号为名称的文件
    
    //文件名称
    //$file = 'orders.txt';//存储订单数据
    $fp = fopen($file, 'a+'); //追加写入
    fwrite($fp, $orders."\r\n"); //写入生成的订单数据
    fclose($fp); //关闭订单数据
    
    return $addata;
}

//读取订单编号数据返回为数组
function readjson($filename){
    $mydate=array();
    //	读取文件
    $myfile = fopen($filename, "r") or die("Unable to open file!");
    
    $mydate= fread($myfile,filesize($filename));
    
    fclose($myfile);
    
    $mydate = explode("\r\n", $mydate);
    $mydate=array_filter($mydate);//数组去空值
    return $mydate;
    
}

?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="apple-touch-icon" type="image/png" href="https://api.laoknas.com/logo.png">
        <meta name="apple-mobile-web-app-title" content="LaokNAS网络技术">
        <link rel="shortcut icon" type="image/x-icon" href="https://api.laoknas.com/logo.png">
        <link rel="mask-icon" type="image/x-icon" href="https://api.laoknas.com/logo.png" color="#111">
        
        <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    
    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
    
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

        <title>LaokNAS网络技术-网站广告推广</title>
        <!--[if IE]>
                <script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
        <![endif]-->
        <style>
        .main {
          /*width: 1440px;*/
          width: 1440px;
          margin: 0px auto;
        }
        .main .menu{
        width:100%;
        height: 60px;
        }
        .menu p{
            margin:-28px auto;
            /*background-color:#999 ;*/
            height: 28px;
            text-align:right;
            
        }
        .main .page{
        width:100%;
        
        }
        .page p{
           text-align:center; 
        }
        .main .footer{
            width:100%;
        }
        .footer div{
            width:100%
            text-align:center;
            background-color: #999 ;
            height: 100px;
        }
        .footer p{
            padding: 40px 0 0px 0;
            text-align:center; 
            
        }
        .masonry {
          width: 1440px;
          margin: 50px auto;
          columns: 4;
          column-gap: 15px;
        }
        .masonry .item {
          width: 100%;
          break-inside: avoid;
          margin-bottom: 12px;
          /*height: auto !important;*/
        }
        .masonry .item .item_div div {
          width: 100%;
          border-color:#e6e7e8;
          border-width: 1px;
          border-style: solid;
        }
        .masonry .item img {
          width: 100%;
        }
        .masonry .item .content{
            width: 96%;
        }
        .masonry h3 {
          padding: 1px 0;
        }
        .masonry P {
          color: #555;
        }
        .btn {
        			padding: 10px 20px;
        			margin-top: 30px;
        			color: #03e9f4;
        			position: relative;
        			overflow: hidden;
        			text-transform: uppercase;
        			letter-spacing: 2px;
        			left: 35%;
        		}

        @media screen and (min-width: 1024px) and (max-width: 1439.98px) {
          .masonry {
            width: 96vw;
            columns: 3;
            column-gap: 20px;
          }
          .main{
            width: 96vw;
          }
        }
        @media screen and (min-width: 768px) and (max-width: 1023.98px) {
          .masonry {
            width: 96vw;
            columns: 2;
            column-gap: 20px;
          }
          .main{
            width: 96vw;
          }
        }
        
        @media screen and (max-width: 767.98px) {
          .masonry {
            width: 96vw;
            columns: 1;
          }
           .main{
            width: 96vw;
          }
        }
        
        @media screen and (max-height:480px ){
            .masonry {
            width: 96vw;
            columns: 1;
          }
           .main{
            width: 96vw;
        
          }
        }
        @media screen and (max-width:320px ){
            .masonry {
            width: 96vw;
            columns: 1;
          }
           .main{
            width: 96vw;
        
          }
        }
        @media screen and (max-width:320px ) and (max-height:480px ){
            .masonry {
            width: 96vw;
            columns: 1;
        }
          .main{
            width: 96vw;
          }
        
        
        }
        </style>

    </head>
    <body translate="no">
              
        <div class="main">
            <div class="menu">
                <div class="item_div">
                    <h3>LaokNAS网络技术-广告联盟</h3>
                    <ul class="nav nav-tabs">
				        <li><a href="index.php" data-toggle="tab">首页</a></li>
				        <li><a href="https://www.laoknas.com" data-toggle="tab">LaokNAS网络技术</a></li>
			        </ul>

                </div>
                <p>
                    <button onClick="open_ad()">申请提交广告</button>
                </p>
            </div>
            <script type="text/javascript">
                function open_ad(){
                window.open('ad.html', 'newwindow','height=600, width=600, top=20, left=20, toolbar=no, menubar=no, scrollbars=no, resizable=false,location=no, status=yes')
                }
            </script>
        </div>
    
        <div class="masonry">
            
            <?php  ad_html($page,$adorders,$page_n);?>
        </div>
        
        <div class="page">
            <form method="GET" action="index.php">
            <p>
                
                <?php
                //$page_n=21;
                $page_num=ceil(count($adorders)/$page_n);
                
                for ($page_x=1;$page_x<=$page_num;$page_x++){
                    
                    echo '&nbsp;<input type="submit" name="page" value="'.$page_x.'">&nbsp;';
                }
                ?>
            
            </p>
            </form>
        </div>
        
    </body>
    
    <div class="footer">
        <div class="footer-highet">
            <p>Copyright © 2020-2022 · LaokNas网络技术 | 辽ICP备2021005077号</p>
        </div>
    </div>

</html>

<?php
//此处位置用来处理做分页 每页默认删除10个$b
function ad_html($page,$adorders,$page_n,$dir="userdata"){ 
    //echo print_r($adorders);
    //$page_n=17;//每页显示的数量，默认为17
    if (!is_numeric($page_n)){$page="17";}
    
    if (!is_numeric($page)){$page="1";}
    
    $a=($page-1)*$page_n; 
    
    $b=$a+$page_n;
    
    if (($a)<=0){$a=0;}
    
    if(($b)>count($adorders)){$b=count($adorders);}
    
    for ($a;$a<$b;$a++){ 
         
        $userorders=$dir."/".$adorders[$a].'.txt';
        
        if(file_exists($userorders)){
            
            $result = file_get_contents($userorders);
            
            $userdata= json_decode($result,true);
        }
        ?>
        <div class="item">
            <div>
                <a href="<?php echo $userdata['adurl'];?>"><img src="<?php echo $userdata['adimg'];?>"></a>
                <div class="content">
                <h2><a href="<?php echo $userdata['adurl'];?>"><?php echo $userdata['adtitle'];?></a></h2>
                
                <p>
                    <?php echo $userdata['adDescription'];?>
                </p>
                </div>
           </div> 
        </div>
    
  <?php } 
  
}

?>


<?php 
    //完成操作后清空数据
    //ad标题
    //$adtitle=$_POST["adtitle"];
    $adtitle=$_POST['adtitle']='';
      //ad超链接地址
    //$adurl=$_POST["adurl"];
    $adurl=$_POST['adurl'] ='';
    //ad图片地址
    //$adimg=$_POST["adimg"];
    $adimg=$_POST['adimg'] ='';
     
      //ad描述
    $adDescription=$_POST["adDescription"]='';
    
    ?>