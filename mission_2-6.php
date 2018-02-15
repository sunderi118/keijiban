
<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="content-type" charset="UTF-8">
<title>プログラミングブログ</title>
</head>
<body>
<?php
header("Content-Type: text/html; charset=UTF-8");
?>

<h1>いまどうしてる？</h1>

<?php

$textfile = 'mission_2.txt';
$name=$_POST['name'];
$memo=$_POST['memo'];
$password=$_POST['password'];
$date=date("Y/m/d h:i:s");
//新規保存
if(isset($name) && ($memo) && ($password)){

	if(empty($_POST['text'])){
	$lines = file($textfile);

	$fp = @fopen($textfile,"a");

	$line_num =count($lines)+ 1;

	fwrite($fp, $line_num."<>".$name."<>".$memo."<>".$password."<>".$date.PHP_EOL);

	fclose($fp);
	}
}

//データ削除に入力があればパスワード入力フォームを呼び出す
if(isset($_POST['delete_num'])){
	
	$delete_num=$_POST['delete_num'];	
?>
	
	<form action="mission_2-6.php" method="post">
	パスワードを入力してください<input type= "text"  name ="check_pass">
	<input type = "submit" name="submit" value="send it">
	<br>
	</form>
<?php
	
	$lines=file($textfile);
	
	foreach($lines as $line){
	
		$data= explode("<>",$line);
	
		$check_pass= $_POST['check_pass'];
	
		if($data[0]== $delete_num && $data[3]== $check_pass){
		
			foreach($lines as $line){
			
			$data= explode("<>",$line);
		
			if($data[3] == $check_pass){
				
				$fp= fopen($textfile,"w+");	
				
				foreach($lines as $line){
				
					$data= explode("<>",$line);
					//削除番号と同じ行のデータじゃなかったら
					if($data[0] != $delete_num){		
	
						$new = file($textfile);
	
						$new_num= count($new) +1;
	
						fputs($fp,$new_num."<>".$data[1]."<>".$data[2]."<>".$data[3]."<>".$data[4]);
					}
				}	
			fclose($fp);
			}else{echo"パスワードが正しくありません";}
		}
	}
}
}
if(isset($_POST['edit'])){
	
	$edit=($_POST['edit']);
	
?>
	<form action="mission_2-6.php" method="post">
	パスワードを入力してください<input type= "text"  name ="check_pass">
	<input type = "submit" name="submit" value="send it">
	</form>
<?php

	$check_pass= $_POST['check_pass'];
	
	$lines=file($textfile);
	
	foreach($lines as $line){	
	
		//＜＞で分割してdata配列に追加
		$data= explode("<>",$line);
 
		if($data[0]== $edit  && $data[3]==$check_pass){		 
?>		
			編集番号：<?php $data[0]; ?>
			<form action="mission_2-6.php" method="post">
			<input type ="hidden" name="edit_num">
			<input type= "text"  name ="edit_name">
			<input type= "text"  name ="edit_memo">
			<input type = "submit" value="変更する">
			</form>
<?php
		}
	}
}

if(isset($_POST['edit_name']) && ($_POST['edit_memo']) && ($_POST['edit_num'])){
		
	$edit_name=$_POST['edit_name'];
	$edit_memo=$_POST['edit_memo'];
	$edit_num=$_POST['edit_num'];
		
	$lines = file($textfile);
		
	$fp = @fopen($textfile,'w+');
		
	foreach($lines as $line){
		
		$data = explode("<>", $line);
		
		if($data[0]== $edit_num){
		
			$new_line= ($edit_num."<>".$edit_name."<>".$edit_memo."<>".$data[3].$date.PHP_EOL);
		
			fputs($fp,$new_line);
		
			}else{
		
				$new = file($textfile);
	
				$new_num= count($new) +1;
	
				fputs($fp,$new_num."<>".$data[1]."<>".$data[2]."<>".$data[3]."<>".$data[4]);	
			}
		}
	fclose($fp);
}

?>

<!_ 入力フォームを作成する_>
<form action = "mission_2-6.php" method ="post">
<br>
	<!_名前フォーム_>
	名前：
	<input type= "text" name = "name">
	<!_コメントフォーム_>
	コメント:
	<input type= "text" name ="memo">
	パスワード
	<input type= "text" name ="password">
	<input type = "submit" name="submit" value="send it">
</form>

<!_編集番号フォーム_>
<form action = "mission_2-6.php" method ="post">
	<p>編集番号：<input type= "text"  name = "edit">
	<input type = "submit" value="send it"></p>
</form>
<!_削除番号フォーム_>
<form action = "mission_2-6.php" method ="post">
<p>削除番号：<input type= "text"  name = "delete_num">
<input type = "submit" value="send it"></p>
</form>

<?php
$i=0;

if($i== 0){
	
	$name=$_POST['name'];

	$memo=$_POST['memo'];

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