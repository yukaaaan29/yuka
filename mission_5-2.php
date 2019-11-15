<?php
//テーブル作成
$dsn = "データベース名";
 $user = "ユーザー名";
 $password = "パスワード";
 $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
  $sql = "CREATE TABLE IF NOT EXISTS db2"
  ." ("
  . "id INT AUTO_INCREMENT PRIMARY KEY,"
  . "name char(32),"
  . "comment TEXT,"
  . "date DATETIME,"
  ."passnew TEXT"
  .");";
  $stmt = $pdo->query($sql);
  $editpass = "";
  
  if( !empty($_POST["edit"]) || !empty($_POST["editNo"])){
		$editno = $_POST["edit"];
  		$sql = 'SELECT * FROM db2 where id=:id';
   		$stmt = $pdo->prepare($sql);
   		$stmt->bindParam(':id', $editno, PDO::PARAM_INT);
    	$stmt->execute();
   		$result = $stmt->fetch();
   		global $result;
   		if($result['passnew'] == $_POST["passedit"]){
   			$editbango = $result['id'];
			$editnamae = $result['name'];
			$editname = $result['comment'];
			$editpass = $result['passnew'];
		}
}


//新規投稿
 
  if(!empty($_POST["name"]) && !empty($_POST["comment"])&& !empty($_POST["passnew"])||!empty($_POST["passedit"])){
  	
  	// 編集
   		if(!empty($_POST["editNo"])){
   		    $name = $_POST["name"];
   			$comment = $_POST["comment"];
   			$passnew =  $_POST["passnew"];
   			$id = $_POST["editNo"];
   			$editno = $_POST["edit"];
   			$date = date("Y/m/d H:i:s");
   			$sql = 'update db2 set name=:name,comment=:comment,passnew=:passnew,date=:date where id=:id';
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);
			$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
			$stmt->bindParam(':passnew', $passnew, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->bindParam(':date', $date, PDO::PARAM_STR);
			$stmt->execute();
		}
		elseif(!empty($_POST["name"]) && !empty($_POST["comment"])&& !empty($_POST["passnew"])){
   		
  $sql = $pdo -> prepare("INSERT INTO db2 (name, comment,date,passnew) VALUES (:name, :comment,:date,:passnew)");
  $sql -> bindParam(':name', $name, PDO::PARAM_STR);
  $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
  $sql -> bindParam(':date', $date, PDO::PARAM_STR);
  $sql -> bindParam(':passnew', $passnew, PDO::PARAM_STR);
  $name = $_POST["name"];
  $comment = $_POST["comment"];
  $date = date("Y/m/d H:i:s");
  $passnew = $_POST["passnew"];
  
  $sql -> execute();
  }
}


//削除処理
  
 if(!empty($_POST["deleteNo"])){
  $deleteno = $_POST["deleteNo"];
   $sql = 'SELECT * FROM db2 where id=:id';
   $stmt = $pdo->prepare($sql);
   $stmt->bindParam(':id', $deleteno, PDO::PARAM_INT);
    $stmt->execute();
   $result = $stmt->fetch();
   if($result['passnew'] == $_POST["passdel"]){
  	$sql = 'delete from db2 where id=:id';
  	$stmt = $pdo->prepare($sql);
 	 $stmt->bindParam(':id', $deleteno, PDO::PARAM_INT);
 	 $stmt->execute();
 	}
  	else{
  		echo "パスワードが違います";
  	  	}

  }
  if(!empty($_POST["edit"])){
  	$edit = $_POST["edit"];
  	
  }
?>
<html lang="ja">
	<meta http-equiv="content-type" charset ="utf-8">
<form action="mission_5-1.php" method="post">
  	名前: <input type="text" name="name" placeholder="名前" value = "<?php if(!empty($_POST["edit"]) && $editpass == $_POST["passedit"]){echo $editnamae ;}?>"><br>
  	コメント: <input type="text" name="comment" placeholder="コメント" value = "<?php if(!empty($_POST["edit"]) && $editpass == $_POST["passedit"]){echo $editname ;}?>"><br>
  	パスワード:<input type="text" name="passnew" placeholder="パスワード">
	<input type="submit" value="送信"><br>
	<input type="hidden" name="editNo" value = "<?php if(!empty($_POST["edit"])){echo $_POST["edit"]; }?>" ><br>
	<p>
	削除対象番号:<input type="text" placeholder="削除対象番号" name="deleteNo"><br>
	パスワード:<input type="text" name="passdel" placeholder="パスワード">
	<input type="submit" value="削除"><br>
	</p>
	<p>
	編集対象番号:<input type="text" placeholder="編集対象番号" name="edit"><br>
	パスワード:<input type="text" name="passedit" placeholder="パスワード">
	<input type="submit" value="編集"><br>
	</p>
</form>
</html>
<?php
$sql = 'SELECT * FROM db2';
  	$stmt = $pdo->query($sql);
  	$results = $stmt->fetchAll();
 	 foreach ($results as $row){
  		echo $row['id'].',';
  		echo $row['name'].',';
  		echo $row['comment'].',';
  		echo $row['date'].'<br>';
  		echo "<hr>";
  	}
?>  	
