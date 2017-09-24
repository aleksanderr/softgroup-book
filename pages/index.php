<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{!TITLE!}</title>
</head>
<body>
	<h1>Ну эт типа записи</h1>
	<table>
		<tr>
			<td>User</td>
			<td>E-mail</td>
			<td>Message</td>
			<td>Date</td>
		</tr>

		<?php

			$db->Query("select messages.*, users.* from `messages`, `users` where messages.user_id = users.id ");

			while ($row = $db->FetchArray()) { ?>
				
				<tr>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['email']; ?></td>
					<td><?php echo $row['message']; ?></td>
					<td><?php echo date( 'd-m-Y, H:i:s', $row['date'] ); ?></td>
				</tr>

		<?php }	?>

	</table>

	<h1>Добавить запись</h1>

	<form method="post">
		<input type="text" name="name" id="name" placeholder="Ваше имя, сударь">
		<input type="text" name="email" id="email" placeholder="Електронная почта, мой король">
		<textarea name="message" id="message" placeholder="message"></textarea>
		<button>Сохранить мой прекрастный комментарий!!!</button>
	</form>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script>
		$('form').submit(function(event) {
			$.ajax({
				url: '/ajax/message.push.php',
				type: 'post',
				data: $(this).serialize(),
				success: function(data) {
					console.log(data);
				}
			})
			return false;
		});
	</script>

</body>
</html>