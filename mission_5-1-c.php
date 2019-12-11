

 
<?php	 //テキストに記述
	
	//データベースに接続
//==================================================================================================
$dsn = 'mysql:dbname=co_***_it_3919_com;host=localhost';
	$user = 'co-***.it.3919.c';
	$password = 'PASSWORD';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//====================================================================================================
//変数の定義
	$date = date("Y/m/d H:i:s");//日付データを取得して変数に代入

	//テーブルの作成デーブルのそれぞれの情報を書き換える

//=======================================================================================================
	$sql = "CREATE TABLE IF NOT EXISTS mission5table"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"//32文字分
	. "comment TEXT,"
	."date DATETIME,"
	."password char(30)" 
	.");";
	$stmt = $pdo->query($sql);
	
//========================================================================================================	
	  	


//データを読み込んでおく
	$sql = 'SELECT * FROM mission5table';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();	//配列＄resultsとして読み取る
//==================================================================================================
//削除機能開始
  	
  	//削除フォームの送信の有無で処理を分析
  	  if(!empty($_POST['delete']) and !empty($_POST['password']) and !empty($_POST['password'] == "password")) {
  	               //入力データの受け取りを変数に代入
	
			$delete=$_POST['delete'];
  	                $password = $_POST['password'];
                         //読み込んだファイルの中身を配列に格納するし、それを新しい変数に代入
	foreach($results as $row){
		if( $delete == $row['id']&&$password==$row['password']){
	//データの削除
//=============================================================
	$id = $delete;
	$sql = 'delete from mission5table where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
//============================================================
}
	}
		}
  	                 
 //削除機能終了



//編集選択の始まり
  
     
//編集フォームの送信の有無で処理を分析
if(!empty($_POST['edit_num']) and !isset($_POST[ "edit_name"]) and !empty($_POST['password'] == "password")) {//編集番号が入力された時
			  //入力データの受け取りを変数に代入
              $edit_num=$_POST['edit_num'];  
	$password = $_POST['password'];
              //読み込んだファイルの中身を配列に格納
  	          //配例の数だけループ
  	          foreach($results as $row) {
  	             
  	                 //もし編集対象番号($data_array)が投稿番号($edit_num)と一致したら
					      if ($row["id"] == $edit_num && $row['password']==$password){   	          	                   
  	          	                        //情報を取得 //
  	          	                        $edit_number = $row['id']; //編集番号
  	          	                        $edit_name = $row['name'];//名前
  	          	                        $edit_comment = $row['comment'];//コメント
  	          	            	       	                   	          	         	  	          	      	          	   
                        }
  	  
  	     }
  
  	  
  	  }
 
//編集選択終わり//////////////////////
//編集機能始まり
if(!empty($_POST['commentNumber']) and !empty($_POST['name']) and !empty($_POST['comment']) and !empty($_POST['password'] == "password")){  //空じゃないと判定
	$id = $_POST['commentNumber'];
	$name = $_POST['name']; 
	    $comment = $_POST['comment'];
	    $password = $_POST['password'];
//データの更新機能
//==============================================================================================
	$sql = 'update mission5table set name=:name,comment=:comment,date=:date,password=:password where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':date', $date, PDO::PARAM_STR);
	$stmt->bindParam(':password', $password, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
//=================================================================================================
 

}
//編集機能終わり

//投稿機能開始
	
	if(!empty($_POST['name']) and !empty($_POST['comment']) and empty($_POST['commentNumber']) and !empty($_POST['password'] == "password")) { //もし入力内容が空白でない場合には以下を実行する
	    $name = $_POST['name']; 
	    $comment = $_POST['comment'];
	    $password = $_POST['password'];
	       /* $rey_array = file($filename);
	        $keys_comment=end($rey_array);
	        $keys_comment_ele=explode("<>", $keys_comment);
		$text_name = ($number."<>".$name."<>".$comment."<>".$date."<>".$_POST['password']);
		*/
//データを入力すること
//===================================================================================================
	$sql = $pdo -> prepare("INSERT INTO mission5table (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':date', $date, PDO::PARAM_STR);
	$sql -> bindParam(':password', $password, PDO::PARAM_STR);
	$name = $name; 
	$comment = $comment; 
	$date = $date;
	$password = $password;
	$sql -> execute();
//=========================================================================================================
	                      
  	                
  	    }
  	              	     
//投稿機能終了 
  	                       
?>  	
<form action="mission_5-1-c.php" method="post">


名前：<input type="text" name="name" placeholder="名前"  value ="<?php if(isset($_POST['send_henshu'])) { 
echo $edit_name;  
                                        } ?>"><br> 
コメント：<input type="text" placeholder="コメント" name="comment" value ="<?php if(isset($_POST['send_henshu'])) { 
echo $edit_comment; 
                                        } ?>"><br>
パスワード：<input type="text" name="password" placeholder="パスワード">
<input type="hidden" name="commentNumber" value="<?php if(isset($_POST['send_henshu'])) { echo $edit_number; } ?>">
<input type="submit" name="send" value="送信"><br> 
</form>       
<form action="mission_5-1-c.php" method="post">
削除対象番号：<input type="text" placeholder="削除対象番号" name="delete"><br>
パスワード：<input type="text" name="password" placeholder="パスワード">
<input type="submit"  value="削除"><br>
</form>       
<form method="post">
編集対象番号：<input type="text" placeholder="編集対象番号" name="edit_num"><br>
パスワード：<input type="text" name="password" placeholder="パスワード">
<input type="submit" name= "send_henshu" value="編集"><br>
</form>


<?php

//表示機能
 //読み取り機能
	$sql = 'SELECT * FROM mission5table';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();	//配列＄resultsとして読み取る
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'.';
		echo $row['date'].',';
		echo $row['password'].'<br>';
	echo "<hr>";
	}

/*
    $filename='mission_3-5.txt';
    $texts_export=file($filename);
         foreach($texts_export as $value){ // 取得したファイルデータ(配列)を全て表示する 
         
  	                                  $exploded = explode ("<>", $value);//ファイルの行を<で分割し、配列に格納
  	                                
                                      echo $exploded[0]." ".$exploded[1]." ".$exploded[2]." ".$exploded[3]."<br>";
  }
*/
?>
            

</body>
</html>