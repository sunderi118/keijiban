<!DOCTYPE html>
<html lang="ja">
<head>
	<meta http-equiv="content-type" charset="UTF-8">
	<title>My Web Page</title>
	 <link rel="stylesheet" href="style.css">
</head>
<body>
<header></header>
<?php
header("Content-Type: text/html; charset=UTF-8");
?>

<div class="comment">
<h2>Comment If You Like</h2>

		<form action="mission_2-6.php" method="post">
		Name<br>
		<input type="text" name="name"><br>
		Comment<br>
		<input type="text" name="comment"><br>
		Password<br>
		<input type="text" name="pass"><br>
		<input type="submit" value="送信">
		</form>
	</div>
		<?php 
	
		$textfile='mission_2.txt';
	
		if(isset($_POST['name']) && ($_POST['comment']) && ($_POST['pass'])){
	
			$lines = file($textfile);
	
			$fp = @fopen($textfile,"a");
	
			$line_num =count($lines)+ 1;
	
			fwrite($fp, $line_num."<>".$_POST['name']."<>".$_POST['comment']."<>".$_POST['pass']."<>".date("Y/m/d h:i:s").PHP_EOL);
	
			fclose($fp);
		}
		?>

	
<div class="comment">
<h2>Edit</h2>

<form action="mission_2-6.php" method="post">

Edit your comment<br>
<input type="text" name="edit"><br>
password<br>
<input type="text" name="edit_pass"><br>
<input type="submit" value="編集"><br>

</form>

<?php
if(isset($_POST['edit']) && ($_POST['edit_pass'])){
	
	$edit=$_POST['edit'];
	$lines = file($textfile);
	
	foreach($lines as $line){	
	
		//＜＞で分割してdata配列に追加
		$data= explode("<>",$line);
	
		if($data[0]==$edit && $data[3] == $_POST['edit_pass']){
	
			//編集番号に入力があったら入力フォームに表示させる
			$num =$data[0]; $user=$data[1]; $text=$data[2];
?>

		<form action="mission_2-6.php" method="post">

		
		<input type="hidden" name="edit_num" value="<?php echo $num ; ?>"/><br>
		Edit your comment<br>
		name<br>
		<input type="text" name="edit_name" value="<?php echo $user ; ?>"/><br>
		comment<br>
		<input type= "text" name="edit_comment" value="<?php echo $text ; ?>"<br>
		<input type="submit" value="編集"><br>

		</form>
	
<?php	
		}
	}
}
//編集モードに入力があったら	
if(!empty($_POST['edit_name']) && ($_POST['edit_comment']) && ($_POST['edit_num'])){
	
	$lines = file($textfile);
	
	$fp = @fopen($textfile,'w+');
	
	foreach($lines as $line){	
	
		$data = explode("<>", $line);
	
		//<>で切って配列に
		if($data[0]== $_POST['edit_num']){			
			
			$new_line=($_POST['edit_num'])."<>".($_POST['edit_name'])."<>".($_POST['edit_comment'])."<>".$data[3]."<>".date("Y/m/d h:i:s").PHP_EOL;
		
			fputs($fp,$new_line);
		}
else{
	$new = file($textfile);
	
	$new_num= count($new) +1;
	
	fputs($fp,$new_num."<>".$data[1]."<>".$data[2]."<>".$data[3]."<>".$data[4]);
}	
}
fclose($fp);
}

?>

</div>
<div class="comment">
<h2>Delete</h2>


<form action="mission_2-6.php" method="post">
Delete your comment<br>
<input type="text" name="delete"><br>
password<br>
<input type="text" name="delete_pass"><br>
<input type="submit" value="削除"><br>
</form>
</div>
<?php
if(isset($_POST['delete']) && ($_POST['delete_pass'])){

	$delete=$_POST['delete'];	
	
	$lines=file($textfile);
	
	foreach($lines as $line){
	
		$data= explode("<>",$line);
	
		if($data[0]== $delete && $data[3] ==($_POST['delete_pass'])){
		
			$fp= fopen($textfile,"w+");	
				
			foreach($lines as $line){
				
				$data= explode("<>",$line);
					//削除番号と同じ行のデータじゃなかったら
				if($data[0] != $delete){		
	
						$new = file($textfile);
	
						$new_num= count($new) +1;
	
						fputs($fp,$new_num."<>".$data[1]."<>".$data[2]."<>".$data[3]."<>".$data[4]);
					}
				}	
			fclose($fp);
		}	
	}
}
$i=0;

if($i== 0){
	
	$lines = file($textfile);

	foreach($lines as $line){
	
		$data= explode("<>",$line);

		$line_num =count($line)+ 1;

		echo "<p> -------------------------------------------------------------------------</p>";

		echo $data[0]." ".$data[1]."<br>".$data[2]."<br>"."投稿時間".$data[4]."<br>";
	}
}

?>


</body>
</html>
