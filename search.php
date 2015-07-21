<html>
<head>
	<meta charset="UTF-8">
	<script type="text/javascript" charset="utf-8" src="phonegap.js"></script>
	<title>Searching for a student...</title>
</head>
<body bgcolor=#ffffff>
<html>
<head>
	<meta charset="UTF-8">
	<script type="text/javascript" charset="utf-8" src="phonegap.js"></script>
	<title>البحث</title>
</head>
<body bgcolor=#ffffff dir="rtl">
	<table>
		<?php
		ini_set('default_charset','UTF-8'); 
		$dbhost = 'localhost';
		$dbuser = 'root';
		$dbpass = 'mma';
		$dbname = 'tqadb';
		
		echo "<tr><td bgcolor='#DDDDD6' colspan='2'>البحث عن: ".$_POST["find"]."</td></tr>";
		echo "<tr><td colspan='2'><hr></td></tr>";
		$conn = mysql_connect($dbhost, $dbuser, $dbpass, $dbname);
		if(! $conn ){die('Could not connect: ' . mysql_error());}
		mysql_select_db('tqadb');
		mysql_set_charset('utf8',$conn);
		$question_sql = 'SELECT * FROM qa_posts where content like "%'.$_POST["find"].'%" and type="Q"';
		//$question_sql = 'SELECT * FROM qa_posts where MATCH(title, content) AGAINST('.$_POST["find"].')';
		$question_retval = mysql_query( $question_sql, $conn );
		if(! $question_retval ){die('Could not get data: ' . mysql_error());}
		if(mysql_num_rows($question_retval)==0){
			echo "<tr><td bgcolor='#DDDDD6'><u>النص</u></td><td bgcolor='#F5F5F5'> هذا النص غير موجود في قاعدة البيانات</td></tr>";
		}else{
			while($question_row = mysql_fetch_array($question_retval, MYSQL_ASSOC)){
			    echo "<tr><td bgcolor='#DDDDD6'><u>النص</u></td><td bgcolor='#F5F5F5'>{$question_row['content']} </td></tr> ";
				$post_id=$question_row['postid'];
				
				// Display Answers 
				$answer_sql = 'SELECT * FROM qa_posts where parentid='.$post_id.' and type="A"';
				$answer_retval = mysql_query( $answer_sql, $conn );
				if(! $answer_retval ){die('Could not get data: ' . mysql_error());}
				if(mysql_num_rows($answer_retval)==0){
					echo "<tr><td bgcolor='#DDDDD6'><u>الإجابة</u></td><td bgcolor='#F5F5F5'> لا توجد إجابة بعد..</td></tr>";
				}else{
					while($answer_row = mysql_fetch_array($answer_retval, MYSQL_ASSOC)){
					    echo "<tr><td bgcolor='#DDDDD6'><u>الإجابة</u></td><td bgcolor='#F5F5F5'>{$answer_row['content']} </td></tr> ";
					}
				}
				echo "<tr><td colspan='2'><hr></td></tr>";
			} 
		}
		mysql_close($conn);
		?>
	</table>
	<a href="index2.html">عودة إلى الخلف</a>
</body>
</html>
