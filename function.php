<?php

///2011-09-27 
///Quando esegui modifiche alla funzione receiver() ricordati di fare il restart del demone amqp-daemon
///
///

// CONFIG //
$array = /*

		qui ci va la definizione dell'array che indichi quali sono le variabili da associare al file uploadato
		puo' essere il risultato di una query o un semplice listato in forma di array.
		fate vobis :)	

	*/
	
// connessione del sql	
$ip_sql='';	
$db_sql='';
$user_sql='';
$pass_sql='';

// cookie name (remember to set it also in index.php)

$ck_name='';
	
// END CONFIG //
function corso($array,$date){
	if($date==NULL){
		$date = date('ymd-H:i');
	}
	foreach ($array as $corso=>$value){
	echo 'corso: '.$corso.' <select name="'.$corso.'">';
	echo '<option selected="selected" value=""></option>';
		foreach ($value as $anno=>$value2){
			sort($value2);
			echo '<optgroup label="'.$anno.'">';
			foreach ($value2 as $value3=>$materia){
				echo '<option value="'.$date.'_'.$materia.' ./'.$corso.'/'.$anno.'/'.$materia.'">'.$materia.'</option>';
			}
			echo '</optgroup>';
		}
	echo "</select><br><br>";
	}	
}



function sender($text, $rk, $exchange, $ip){
	
	$connection=amqp_connection('guest', 'guest', $ip);
     
	$ex = new AMQPExchange($connection);
	$ex->declare($exchange, AMQP_EX_TYPE_DIRECT, AMQP_DURABLE | AMQP_AUTODELETE);
	
	$msg=$ex->publish($text, $rk);
	if (!$msg){echo "error";}echo 'Sended '.$msg.'<br>';
	
	if (!$connection->disconnect()) {
		throw new Exception('Could not disconnect');
	} else {
		echo "disconnected";
	}
}

function amqp_connection($login, $pass, $ip) {

	$connection = new AMQPConnection();
	$connection->setLogin($login);
	$connection->setPassword($pass);
	$connection->setHost($ip);
	$connection->connect();

	if (!$connection->isConnected()) {
		 echo "Cannot connect to the broker";
	}
	return $connection;
}

function mysql_connection($host, $myuser, $mypass){
	$myconnection = mysql_connect($host, $myuser, $mypass);
	if (!$myconnection) {
    		die('Could not connect: ' . mysql_error());
	}
	return $myconnection;
}

function login($user, $pass){
	$pass=md5($pass);
	$link=mysql_connection($ip_sql, $usel_sql, $pass_sql);
	mysql_select_db($db_sql);
	$query = sprintf("SELECT name, pass FROM mb_users WHERE user='$user' AND pass='$pass'");
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 0) {
		setcookie($ck_name, 'no', time() + 5, '/');
		header('Location: ./index.php');
    		exit;
	}
	while ($row = mysql_fetch_assoc($result)) {
		if ($row['pass']===$pass){	
	    		return true;
	    	}
	}
}

function form_login(){

echo'<div id="Login-form"></div>
		    <form id="login"
			    method="post" 
			    action="login.php">
			    <h4>Login</h4><p>
			    <h4>User
			    <input type="text" name="user"></h4><p>
			    <h4>Password
			    <input type="password" name="pass"></h4>
			    <input type="submit" id="login" value="Login">
		    </form>   ';
}

    
?>


















