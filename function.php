<?php

///2011-09-27 
///Quando esegui modifiche alla funzione receiver() ricordati di fare il restart del demone amqp-daemon
///
///

$array = array("EDIPA" => array ("1_anno_aule_virtuali" => array(   "diritto_lavoro_transnazionale",
							"economia_politica_internazionale",
							"economia_monetaria_internazionale",
							"strategie_performance_imprese",
							"diritto_amministrativo",
							"diritto_lavoro_pa",
							"economia_imprese_servizi",
							"inglese",
							"modelli_statistici_aziende",
							"diritto_commerciale",
							"comparative_public_management",
							"economia_benessere",
							"scienza_finanze"),
				   "2_anno" => array(   "sociologia_organizzazioni",
				   			"international_trade_law",
				   			"organizzazione_imprese_internazionali",
				   			"diritto_bancario",
				   			"gestione_imprese_internazionali",
				   			"contabilita_gestione_aziende_pubbliche",
				   			"european_union_law"),
				   ),
		"MOI" => array ("1_anno_aule_virtuali" => array(	"economia_aziendale",
							"economia_sistemi_impresa",
							"informatica",
							"matematica",
							"diritto_economia",
							"istituzioni_economia_politica_I",
							"inglese"),
				   "2_anno" => array(   "amministrazione_controllo",
				   			"fondamenti_marketing",
				   			"gestione_informazione",
				   			"diritto_contratti_relazione_impresa",
				   			"introduzione_statistica_econ_soc",
				   			"istituzioni_economia_politica_II",
				   			"comportamento_organizzativo"),		
				   "3_anno" => array(	"organizzazione_aziendale",
				   			"economia_innovazione",
				   			"modelli_innovazione",
				   			"comunicazione_impresa",
				   			"marketing_distributivo",
				   			"psicologia_processi_cognitivi",
				   			"modelli_statistici_analisi_dati"),
				),	
		"SCO" => array ("1_anno_aule_virtuali" => array(	"linguistica",
							"psicologia_generale",
							"societa_processi_culturali",
							"tecnologia_comunicazione",
							"lingua_inglese_a",
							"scrittura_lingua_italiana"),
				   "2_anno" => array(	"comunicazione_visiva",
				   			"psicologia_comunicazione",
				   			"francese",
				   			"tedesco",
				   			"lingua_inglese_b",
				   			"lettorato_lingua_inglese_b",
				   			"psicologia_sociale",
				   			"semiotica",
				   			"semiotica_testo",
				   			"sociologia_comunicazione"),			
				   "3_anno" => array(	"statistica_ricerca_sociale",
				   			"semiotica_media",
				   			"istituzioni_economia",
				   			"lab_grafica_videocom",
				   			"storia_cinema",
				   			"storia_contemporanea",
				   			"comunicazione_politica")			
				)	
	);

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
	$link=mysql_connection('127.0.0.1', 'magicboxes', '4cc3ss0');
	mysql_select_db('magicboxes');
	$query = sprintf("SELECT name, pass FROM mb_users WHERE user='$user' AND pass='$pass'");
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 0) {
		setcookie('magicookie', 'no', time() + 5, '/');
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


















