<?php
ob_start();
session_start();
include('administrator/includes/config.php');
?>
<?php

if ($_SESSION['user_id']=='') {
    header("location:index.php");
}

$all_messages = mysql_query("SELECT * from matrimony_message where (from_id='".$_SESSION['user_id']."' OR to_id ='".$_SESSION['user_id']."') AND (from_id='".$_REQUEST['id']."' OR to_id ='".$_REQUEST['id']."') order by id");

$get_read= mysql_query("SELECT * from matrimony_message where to_id='".$_SESSION['user_id']."' and read_status = 0");
while($check_readstatus = mysql_fetch_array($get_read)){
$update_readstatus = mysql_fetch_array(mysql_query("UPDATE matrimony_message SET read_status = 1 where to_id ='".$_SESSION['user_id']."' AND from_id='".$_REQUEST['id']."'"));	
}

if(isset($_REQUEST['Send'])){
$message = isset($_POST['sendingMessage']) ? $_POST['sendingMessage'] : '';
$add_date = date('Y-m-d');

$insert_message = mysql_query("INSERT into matrimony_message(from_id,to_id,message,date) VALUES('".$_SESSION['user_id']."','".$_REQUEST['id']."','".$message."','".$add_date."')");
//$_SESSION['question_msg'] = 'Question posted successfully';
 header("Location:message-details.php?id=".$_REQUEST['id']);
  exit();
}

// while($chats = mysql_fetch_array($all_messages)){
// 	echo "id=>".$chats['id'];
// 	echo "<br>";
// 	echo "from_id=>".$chats['from_id'];
// 	//print_r($chats);
// 	echo "<br>";
// 	echo "to_id=>".$chats['to_id'];
// 	echo "<br>";
// 	echo "message=>".$chats['message'];
// 	echo "<br>";
// }
// exit;
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Marry A Revert</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
<?php include 'includes/header.php';?>
<div class="messageDetail mt-5 pt-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
<?php 
while($chats = mysql_fetch_array($all_messages)){
$sender = mysql_fetch_array(mysql_query("SELECT * from matrimony_user where id='".$chats['from_id']."'"));
	if($chats['from_id']==$_SESSION['user_id']){
?>			
				<!-- <div class="messageTop mb-5">
					<div class="row">
						<div class="col-lg-2">
							<div class="image" style="background: url(upload/user_image/1510833756man5.jpg) no-repeat;">
							</div>
						</div>
						<div class="col-lg-10">
							<div class="messageBody">
								<p class="mb-0">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
							</div>
						</div>
					</div>
				</div> -->
				
				<div class="messageTop mb-5">
					<div class="row">
						<div class="col-lg-10">
							<div class="messageBody messageBodySecond">
								<p class="mb-0"><?php echo $chats['message']; ?></p>
							</div>
						</div>
						<div class="col-lg-2">
						<!-- <div class="msg-pic" style="background-image: url('upload/user_image/<?php echo $user_name['image'];?>')">
                              </div> -->
							<div class="image" style="background-image: url('upload/user_image/<?php echo $sender['image'];?>')" no-repeat;">
							</div>
						</div>
						
					</div>
				</div>
				<?php } else {?>
				<div class="messageTop mb-5">
					<div class="row">
						<div class="col-lg-2">
							<div class="image" style="background-image: url('upload/user_image/<?php echo $sender['image'];?>')" no-repeat;">
							</div>
						</div>
						<div class="col-lg-10">
							<div class="messageBody">
								<p class="mb-0"><?php echo $chats['message']; ?></p>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			<!-- 	<div class="messageTop mb-5">
					<div class="row">
						<div class="col-lg-10">
							<div class="messageBody messageBodySecond">
								<p class="mb-0">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="image" style="background: url(upload/user_image/1510833756man5.jpg) no-repeat;">
							</div>
						</div>
						
					</div>
				</div> -->
				<?php } ?>
				<form method="post">
				<div class="form-group">
					<textarea class="form-control" name="sendingMessage" rows="3" required></textarea>
				</div>
				 <input type="submit" class="btn btn-primary mt-2" name="Send" value="Send">
				<!-- <button type="button" class="btn btn-primary mt-2">Submit</button> -->
				</form>
			</div>
		</div>
	</div>
</div>
<?php include 'includes/footer.php';?>
</body>
</html>
