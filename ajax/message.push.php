<?php

	# Автоподгрузка классов
	function __autoload( $name ) { include( "../class/class_" . $name . ".php" ); }

	# Подключаем конфиг 
	$config = new config;

	# Подключаем функции
	$func = new func;

	# Соединяемся с бд
	$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);


	if( !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message']) ) {

		$name = $func->TextClean($_POST['name']);
		$message = $func->TextClean($_POST['message']);
		$email = false;
		$user_id = 0;

		if( $func->IsMail($_POST['email']) ) {
			$email = $_POST['email'];
		}

		if( !$email ) exit('{"status":"error"}');

		$db->Query("select `id` from users where email = '$email' ");
		$search_user_id = $db->FetchRow();

		if( $search_user_id > 0 ) { 
			$user_id = $search_user_id;
		}else{
			$db->Query("insert into `users` (name, email) values ('$name', '$email') ");
			$user_id = $db->LastInsert();
		}

		$time = time();

		$db->Query("insert into `messages` (user_id, message, date) values ('$user_id', '$message', '$time') ");

		$db->Query("select name, email from users where id = $user_id");
		$user_info = $db->FetchArray();

		echo '{"status":"success", "name":"'.$user_info['name'].'", "email":"'.$user_info['email'].'", "message":"'.$message.'", "date":"'.date( 'd-m-Y, H:i:s', $time ).'"}';

	}

?>