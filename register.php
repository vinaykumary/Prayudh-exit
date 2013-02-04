<?PHP

	
	$mysql_hostname = "localhost";
	$mysql_user = "techco7_wp";
	$mysql_password = "karimbenzema";
	$mysql_database = "techco7_wp";
	$prefix = "";
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");

	$name=mysql_real_escape_string($_POST['name']);
	$college=mysql_real_escape_string($_POST['college']);
	$email=mysql_real_escape_string($_POST['email']);
	$year=mysql_real_escape_string($_POST['year']);
	$phone=mysql_real_escape_string($_POST['phone']);
	
	$unique=mysql_query("SELECT 1 FROM registrations WHERE `email` = '$email'");
	$result="";
	if ($unique && mysql_num_rows($unique) > 0)
    {
        $result="duplicate";
    }
	else
    {
		$count_query = mysql_query("select count(1) FROM registrations");
		$row = mysql_fetch_array($count_query);
		$total = sprintf("%04d",$row[0]+1);
		$pid="PRH". $total;
		$query    =    "insert into registrations(name,college,year,email,phone,pid)values('$name','$college','$year','$email','$phone','$pid')";
		$res    =    mysql_query($query);
		
		
		$subject = "Prayudh 2013 Registration confirmation";
		$message = 'Hello ' . $name . ','
      . "\r\n\r\n"
      . "Thank you for registering for Prayudh 2013. Your Prayudh registration ID is ".$pid.". Please produce the ID or this email at the registration counter on the day of the symposium."
      . "\r\n\r\n"
      . 'The date of the symposium is 2nd of March, Saturday. Please do come. If you have any queries, send them to info@prayudh.com and we will get back to you.'
      . "\r\n\r\n"
	  . "Regards,". "\r\n"."Prayudh.";
		$from = "prayudh@tech-coders.com";
		$headers = "From:" . $from;
		mail($email,$subject,$message,$headers);
		
		$result="success";
		
    }
	header('location: index.php?result='.$result.'#register'); 
?>
 