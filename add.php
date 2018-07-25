<?php 

function add(){
	
	global  $imasge;
	// TODO:接受提交上来的文件
	
	// TODO:校验用户是否上传文本
	if (empty($_POST['title'])) {
		# 判断用户是否上传标题
		$imasge = "请输入标题";
		return;
	}
	if (empty($_POST['song'])) {
		# 判断用户是否上传歌手名
		$imasge = "请输入歌手";
		return;
	}

	// 用关联数组来拿数据
	$arr= array(
		"title"=>$_POST['title'],
	 	"song"=>$_POST['song']
	 );

	//TODO:校验用户是否上传了图片文件
	if (!isset($_FILES['img'])) {
		# 校验这个是为了防止客户端的图片文件域被干掉了还能提交
		$imasge="请正确上传文件";
		return;
	}

	$arr_img=$_FILES['img'];
	//===>[name:[xx,xx,...],type:[xx,xxx,...],tmp_name:[xx,xx,..],error:[xx,xx,...],size:[xx,xx,...]]
	
	
	// TODO:图片正确上传后获取图片数据
	
	//规定图片类型
	$img_type=array('image/x-icon','image/png','image/jpeg');


	

	//此时用户上传了照片文件 (因为开启了多文件上传 这里用循环来做)
	for ($i=0; $i <count($arr_img['name']); $i++) { 
		# 循环拿到每个元素
		if ($arr_img['error'][$i] !== 0) {
			# 判断错误信息
			$imasge="请上传图片文件";
			return;
		}

		if ($arr_img['size'][$i] > 0.5*1024*1024) {
			# 判断大小
			$imasge="请上传500K以内的图片";
			return;
		}

		if (!in_array($arr_img['type'][$i],$img_type)) {
			# 判断类型
			$imasge="请上传图片文件";
			return;
		}

		//TODO: 这里已经正确上传了图片 可以操作数据了
		

	
		//保存文件
	
		//创建文件移动路径 （操作文件只能用相对路径）
		
	
		$nwe_img="../add/".uniqid().iconv('UTF-8', 'GBK', $arr_img['name'][$i]);  //如果这里用了随机数，下面的地址必须得为这个变量，如果下次再用的时候 也有一个随机数，将无法匹配到他

		if(!move_uploaded_file($arr_img['tmp_name'][$i], $nwe_img)){
			#  判断文件是否移动成功
			$imasge="上传图片失败";
			return;
		}

		// 为$arr数组 添加一对 数据  一定要在移动成功后获取数据，否在不存在
	
		$arr['img_src'][] = iconv('GBK', 'UTF-8', substr($nwe_img, 2)) ; //使用绝对路径 注意文件路径坑，如果路径用了随机数，必须要是变量接收，使用那个变量
	}

		 
		

	// TODO：校验音乐文件

	if (empty($_FILES['music'])) {
		# 判断客户端是否删除了上传文件域
		$imasge="请正确操作页面";
		return;
	}

	//判断文件域存在之后接受文件域 防止干掉了文件域报错（写在前面）
	$arr_music=$_FILES['music'];  

	if ($arr_music['error'] !== 0) {
		# 判断是否成功上传文件
		$imasge="请上传文件";
		return;
	}
   
    if ($arr_music['size'] > 10*1024*1024) {
    	# 限制音乐文件大小
    	$imasge="请上传10M以内的音频文件";
    	return;
    }

    $music_type=array('audio/mp3','audio/ogg','audio/mpeg','audio/wav');
    if (!in_array($arr_music['type'],$music_type)) {
    	# 限制上传类型
    	 $imasge="请上传音频文件";
    	 return;
    }

    

   //TODO: 将数据移动到文件夹内
   
  
  //创建文件移动路径
  $nwe_music="../add/" . uniqid() . iconv('UTF-8', 'GBK', $arr_music['name']);  
  
  if (!move_uploaded_file($arr_music['tmp_name'], $nwe_music)) {
  	# 判断文件是否移动成功
  	$imasge="上传音频失败";
  	return;
  }
  
 //TODO:校验通过 拿数据
   
   $arr['music_href'] = iconv( 'GBK' , 'UTF-8' ,substr($nwe_music, 2));   


  //TODO： 数据写入JSON文件内
		
		//先获取json文件内容
		$str = file_get_contents('add.json');

		//将json数据转成数组数据
		$arr_json = json_decode($str,true);

		//将数据追加到 arr_json 数组
		$arr_json[] = $arr;
		
		//将数据转换成 json 格式 并写入文件
		
		if (!file_put_contents('add.json', json_encode($arr_json))) {
			# 判断数据是否写入成功
			$imasge="加载失败";
			return;
		};

   $imasge="上传成功";

   //跳转页面
     header('Location: /files/music.php');

}
// 让浏览器提交了数据在执行此处代码
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	
	add();
	
}


 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="/bootstrap-4.1.1/css/bootstrap.css">
</head>
<body>


	<div class="mx-auto" style="width: 55%;height: 35%;">
		
		<h1 class="my-4">添加音乐1</h1>
		<?php if (isset($imasge)): ?>
			<div class="alert alert-danger" role="alert">
  			<?php echo $imasge; ?>
			</div>
		<?php endif ?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" />
			
			<label for="gs"><span>标题</span></label>
			<input class="form-control" type="text" placeholder="请输入歌名"  name="title" id="gs">
			
			<br>
			<label for="gq">歌手</label>
			<input class="form-control" type="text" placeholder="请输入演唱者"  name="song" id="gq">
			<br>
			<label for="hb">海报</label>
			<input class="form-control" type="file"   name="img[]" id="hb" multiple>
			<br>
			<label for="yy">音乐</label>
			<input class="form-control" type="file" p  name="music" id="yy">
			<br>
			<button class="form-control btn-primary">提交</button>
			
		</form>
	
	</div>
</body>
</html>
