<?php
function ldap_auth($user,$password){
	
	


   //Data needed to connect to ldap server
  $server = "ldap.gndec.ac.in";
 
  $dn = "ou=people,dc=example,dc=com";

  error_reporting(0);
  ldap_connect($server);
  $con = ldap_connect($server);
  ldap_set_option($con, LDAP_OPT_PROTOCOL_VERSION, 3);



  //Check whether the user is authenticated one or not
  if (ldap_bind($con, "uid=".$user.",ou=people,dc=example,dc=com",$password) === false) {
    session_destroy();
    return 'LOGIN_FAIL';
  }
  else {
		$login = fetch_resource_db('users',array('username'),array($user),'resource_array','');
		$_SESSION['username'] = $user;
		$_SESSION['password'] = $password;
		$_SESSION['ucentre'] = $login['ucentre'];
		$_SESSION['usession'] = $login['usession'];
		$_SESSION['location'] = $login['location'];
		$_SESSION['branch_code'] = $login['branch_code'];
		$_SESSION['bypass_2_way_authentication'] = $login['bypass_2_way_authentication'];
		return 'LOGIN_SUCCESS';
		
	}
	
/*
	
	//use this to bypass auth, otherwise comment this block
	$login = fetch_resource_db('users',array('username'),array($user),'resource_array','');
		$_SESSION['username'] = $user;
		$_SESSION['password'] = $password;
		$_SESSION['ucentre'] = $login['ucentre'];
		$_SESSION['usession'] = $login['usession'];
		$_SESSION['location'] = $login['location'];
		$_SESSION['branch_code'] = $login['branch_code'];
		$_SESSION['bypass_2_way_authentication'] = $login['bypass_2_way_authentication'];
		return 'LOGIN_SUCCESS';
*/
	
}

function get_usertype($username) {
	$usertype_sql = mysql_query("SELECT usertype,name,course FROM users WHERE username='".mysql_real_escape_string($username)."'") or die(mysql_error());
	if(mysql_num_rows($usertype_sql)==0) {
		return 'USERTYPE_NOT_FOUND';
	}
	else {
		
		$usertype = mysql_fetch_assoc($usertype_sql);
		$_SESSION['fullname'] = $usertype['name'];
		$_SESSION['coursetype'] = $usertype['course'];
		$_SESSION['usertype'] = $usertype['usertype'];
				
		
		return $usertype['usertype'];
	}
}


function generate_secure_code() {
	
	/*
	$alphabets = array('a','b','c','d','e','f','g','h','i','j','k','m','n','p','q',
	'r','s','t','u','v','w','x','y','z');
	for($i=0;$i<=2;$i++) {
		$rand_no[] = rand(2,9);
    $rand_al[] = $alphabets[rand(0,24)];
	}
	$secure_code = $rand_al[0].$rand_no[0].$rand_al[1].$rand_no[1].$rand_al[2].$rand_no[2];
	*/
	$secure_code = rand(111111, 999999);
	
	mysql_query("UPDATE users SET secure_code='".$secure_code."' WHERE username = '".$_SESSION['username']."'") or die(mysql_error());
	
	$sql = mysql_query("SELECT * FROM users WHERE username = '".$_SESSION['username']."'") or die(mysql_error());
	$email = mysql_fetch_assoc($sql);
	
	/*
	$to = $email['email'];
  $subject = "GNDEC 2-Way Authentication Secret Code";
  $body = "Your Secret Code for 2-Way Authentication is = ".$secure_code." . This code is case sensitive";
  $headers = "From: Exam Automation<examautomation@gndec.ac.in>";

  mail($to,$subject,$body,$headers);
  */     
       
        $mailer_user = "gndec.examautomation@gmail.com";
		$mailer_password = "GNDECexam2012";
		$host = "ssl://smtp.gmail.com";
		$port = "465";
        $sender_name = "GNDEC Exam Automation";
        $to = "<".$email['email'].">";
        $from = $sender_name."<".$mailer_user.">";
		$subject = "GNDEC 2-Way Authentication Secret Code";
		$body = "Your Secret Code for 2-Way Authentication is = ".$secure_code."";
		
		
		
		$url="http://103.27.87.89/send.php?usr=1995&pwd=123456&ph=".$email['mobile']."&sndr=GNELDH&text=".urlencode($body)."";
		$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_URL,$url);
		$result=curl_exec($ch);
		
		

        $headers = array ('From' => $from,
          'To' => $to,
          'Subject' => $subject);
        $smtp = Mail::factory('smtp',
          array ('host' => $host,
            'port' => $port,
            'auth' => true,
            'username' => $mailer_user,
            'password' => $mailer_password));

        $mail = $smtp->send($to, $headers, $body);

        if (PEAR::isError($mail)) {
          echo("<p>" . $mail->getMessage() . "</p>");
         } else {
          return $secure_code;
         }
		 
        
	
}

function _2_way_auth() {
	
	$sql = mysql_query("SELECT * FROM users WHERE secure_code = '".mysql_real_escape_string($_POST['secure_code'])."' AND username='".$_SESSION['username']."'") or die(mysql_error());
	if(mysql_num_rows($sql)!=1) {
		return 'Failure';
		}
	if(mysql_num_rows($sql)==1) {
		
		$_SESSION['session_id'] = time();
		
		$prev_session = mysql_query("SELECT * FROM login_session_record WHERE session_id='".$_SESSION['session_id']."'") or die(mysql_error());
			
		if(mysql_num_rows($prev_session)!=0) {
			$_SESSION['session_id'] = $_SESSION['session_id']+3;
		}
		
		mysql_query("INSERT INTO login_session_record 
		(username,session_id,login_status,login_ip,usertype,subdomain) 
		VALUES ('".$_SESSION['username']."','".$_SESSION['session_id']."','logged_in','".$_SERVER['REMOTE_ADDR']."','".$_SESSION['usertype']."','".$_SERVER['SERVER_NAME']."')") or die(mysql_error());
	
	
		return 'Success';
	}
	
}
?>
