<?php 
#TODO:获取Json文件中的数据，在列表中显示

if (file_exists('add.json')) {
	# 判断文件是否存在 存在才执行读取
	//读取json文件
	$json_str = file_get_contents('add.json');
//将json格式数据解析成数组格式数据
 	$arr=json_decode($json_str,true);
 	//===> [[key:值,key:值,..]]
 	
}

 
 
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="/bootstrap.css">
</head>
<body>
	<div class="col-9 m-auto">
		<h1 class="my-4">音乐列表1</h1>
		<a href="/files/add.php" class="btn  badge-secondary my-2">添加</a>
		<table class="table">
		  <thead class="thead-light">
		    <tr>
		      <th scope="col">标题</th>
		      <th scope="col">歌手</th>
		      <th scope="col">海报</th>
		      <th scope="col">音乐</th>
		      <th scope="col">操作</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php if (isset($arr)): ?>
		  		
		  
			<?php foreach ($arr as  $value): ?>	

		    <tr>
		      	<th scope="row"><?php echo $value['title']; ?></th>
		      	<td><?php echo $value['song']; ?></td>
		      	<td>
		      	<?php foreach ($value['img_src'] as $src): ?>
		     	 <img src="<?php echo $src; ?>" alt="">
		  		<?php endforeach ?>
		  		</td>
		      	<td><audio src="<?php echo $value['music_href']; ?>" controls></audio></td>
		      	<td><button class="btn btn-danger">删除</button></td>
		    </tr>
		
		<?php endforeach ?>
		<?php endif	 ?>
		    <tr>
		      <th scope="row">2</th>
		      <td>Jacob</td>
		      <td>Thornton</td>
		      <td>@fat</td>
		      <td>@fat</td>
		    </tr>
		  </tbody>
		</table>
</div>
</body>
</html>
