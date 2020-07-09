<?php
/**
 * index.php
 * Contains Report and can also generate Image code
 * @author Tayyib Oladoja
 * @version 1.0
 * @date 10-05-2016
 * @website www.tayyiboladoja.com
 * @package Email Tracker
**/
include "config.php";

 if (isset($_POST['generate']))
 {
 
	$webadd = $_SERVER['SERVER_NAME'];
	$userID = filter_var($_POST['userID'], FILTER_SANITIZE_STRING);
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
	$subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
	$date= date("Y-m-d h:i:sa");
	
	$url =  "<xmp><img src='".$protocol."://".$webadd."/".$folder_path."/record.php?log=true&user_id=".$userID."&name=".$name." &subject=".$subject."&email=".$email."&date=".$date."' width='1' height='1' border='0' /></xmp>";
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>
xmp {
    white-space: pre-line;
    padding: 20px;
    background-color: #D5D4D4;
    border-radius: 3px;
    color: #000;
    font-weight: 700;
}

.tg {
    border-collapse: collapse;
    border-spacing: 0;
    border-color: #ccc;
}

.tg td {
    font-family: Arial,sans-serif;
    font-size: 14px;
    padding: 10px 5px;
    border-style: solid;
    border-width: 1px;
    overflow: hidden;
    word-break: normal;
    border-color: #ccc;
    color: #333;
    background-color: #fff;
}

.tg th {
    font-family: Arial,sans-serif;
    font-size: 14px;
    font-weight: 400;
    padding: 10px 5px;
    border-style: solid;
    border-width: 1px;
    overflow: hidden;
    word-break: normal;
    border-color: #ccc;
    color: #333;
    background-color: #f0f0f0;
}

.tg .tg-yw4l {
    vertical-align: top;
}    
}
</style>
</head>
<body>
<h2>Genarate Tracking URL</h2>
<h2>Fill the form below to get tracking URL</h2>
<form action="" class="form form-horizontal has-validation-callback" method="post">
    <p><input id="userID" name="userID" placeholder="User ID" type="number"></p>
    <p><input id="name" name="name" placeholder="Recipient Name" type="text"></p>
    <p><input id="email" name="email" placeholder="Recipient Email" type="text"></p>
    <p><input id="subject" name="subject" placeholder="Email Subject" type="text"></p>
    <p><input id="generate" name="generate" text="Generate URl" type="submit"></p>
    <p></p>
</form>
<h3>Click Generate to generate code</h3>
<p></p>
<p id="urlGen">
	<?php echo $url?>
</p>
<div>
    <?php require "report.php"; ?>
</div>
</body>
</html>