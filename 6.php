<!DOCTYPE html>
<html lang="ja">
<head>
	<meta http-equiv="content-type" charset="UTF-8">
	<title>My Web Page</title>
	 <link rel="stylesheet" href="stylee.css">
</head>
<body>

	<div class="comment-section">
        <div class="container">
	        <div class="section-title">
	           	<h3>  掲示板</h3>
	        </div>
	        <div class="comment-form">
	            <h4>メッセージを送る</h4>
	            <form action="6.php" method="post">
		            user name
		            <input type="text" name="name" class="name">
		            message
		            <textarea name="comment" class="comment"></textarea>
		            password
		            <input type="text" name="pass"  class="pass">
		            <button type="submit" class="btn btn-comment">Submit</button>
	           	</form>
	        </div>

			<?php 
			header("Content-Type: text/html; charset=UTF-8");

			$textfile='mission_2.txt';
			
			if(!empty($_POST['name']) && ($_POST['comment']) && ($_POST['pass'])){
			
				$lines = file($textfile);
			
				$fp = @fopen($textfile,"a");
			
				$line_num =count($lines)+ 1;
			
				fwrite($fp, $line_num."<>".$_POST['name']."<>".$_POST['comment']."<>".$_POST['pass']."<>".date("Y/m/d h:i:s").PHP_EOL);
			
				fclose($fp);
			}else if(isset($_POST['comment']) && ($_POST['pass'])){
			
				$lines = file($textfile);
			
				$fp = @fopen($textfile,"a");
			
				$line_num =count($lines)+ 1;
			
				fwrite($fp, $line_num."<>名無しさん<>".$_POST['comment']."<>".$_POST['pass']."<>".date("Y/m/d h:i:s").PHP_EOL);
			
				fclose($fp);
			}
			?>
			
		</div>
	</div>	

	


	<div class="edit-section">
        <div class="container">
          	<div class="edit-form">
            	<h4>Edit your comment</h4>


            	<form action="6.php" method="post">

		            <p>edit number
		            <input type="text" name="edit" class="edit"></p>
		              	<p>password
		              <input type="text" name="edit_pass"  class="edit_pass">
		              <button type="submit" class="btn btn-comment">編集</button></p>
		        </form>
	        </div>

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


						<form action="6.php" method="post">

							<input type="hidden" name="edit_num" value="<?php echo $num ; ?>"/><br>
							
							user name<br>
							<input type="text" name="edit_name" value="<?php echo $user ; ?>"/><br>
							message<br>
							<input type= "text" name="edit_comment" value="<?php echo $text ; ?>"/><br>
							<button type="submit" class="btn btn-comment">変更</button></p>

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
					} else

						{
							$new = file($textfile);
						
							$new_num= count($new) +1;
						
							fputs($fp,$new_num."<>".$data[1]."<>".$data[2]."<>".$data[3]."<>".$data[4]);
						}	
				}

				fclose($fp);
			}

			?>
			
		</div>
	</div>




	<div class="delete-section">
     	<div class="container">
          	<div class="edit-form">
            	<h4>Delete your comment</h4>

            	<form action="6.php" method="post">
            		<p>delete number
		             <input type="text" name="delete" class="delete"></p>
		             <p>password
		             <input type="text" name="delete_pass"  class="delete_pass">
		             <button type="submit" class="btn btn-comment">削除</button></p>
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
				?>
		</div>				
	</div>

	<div class = "result">

		<?php

		$lines = file($textfile);

		$lines_num = count($lines);
		?>
		<br>	
		<p>------------------------- 投稿一覧( <?php echo $lines_num ; ?> )件 -------------------------- </p>

		<?php
		$i=0;

		if($i== 0){

			foreach($lines as $line){
		
				$data= explode("<>",$line);

				$line_num =count($line)+ 1;

				echo "<p> -------------------------------------------------------------------------</p>";
				echo $data[0]."   ".$data[1]."  ".$data[4]."<br>".$data[2]."<br>";
			}
		}
		?>
	</div>


</body>

