<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{!TITLE!}</title>
	<link rel="stylesheet" href="../libs/fancybox/jquery.fancybox.min.css">
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<header class="header">
		<h1 class="header__title">Гостевая книга</h1>
	</header>
	
	<main class="content">
		<div class="wrapper">
			<button href="#modal" class="button" data-modal-open>Оставить запись</button>

			<table class="list" id="list" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Имя</th>
						<th>E-mail</th>
						<th>Дата</th>
						<th>Текст</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Имя</th>
						<th>E-mail</th>
						<th>Дата</th>
						<th>Текст</th>
					</tr>
				</tfoot>
				<tbody>
					<?php

					$db->Query("select messages.*, users.* from `messages`, `users` where messages.user_id = users.id order by messages.id desc ");

					while ($row = $db->FetchArray()) { ?>

					<tr class="message">
						<td class="message__author"><?php echo $row['name']; ?></td>
						<td class="message__email"><?php echo $row['email']; ?></td>
						<td class="message__date"><?php echo date( 'd-m-Y, H:i:s', $row['date'] ); ?></td>				
						<td class="message__text"><?php echo $row['message']; ?></td>
					</tr>

					<?php }	?>
				</tbody>
			</table>

			<div class="holder"></div>

			<div id="modal" class="modal">
				<div class="form">
					<form method="post">
						<input type="text" name="name" id="name" placeholder="Имя" required>
						<input type="mail" name="email" id="email" placeholder="Почта" required>
						<textarea name="message" id="message" placeholder="Сообщение" required></textarea>
						<button class="button">Отправить</button>
					</form>
				</div>
			</div>
		</div>
	</main>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="../libs/fancybox/jquery.fancybox.min.js"></script>
	<script src="../libs/dataTables/jquery.dataTables.min.js"></script>
	<script src="../libs/jqueryvalidate/jquery.validate.min.js"></script>
	<script src="../js/main.js"></script>
	<script>
		$('form').submit(function(event) {
			$.ajax({
				url: '/ajax/message.push.php',
				type: 'post',
				data: $(this).serialize(),
				success: function(data) {
					var info = $.parseJSON(data);
					if( info.status == 'success' ) {
						$('.list').dataTable().fnAddData( [
					        info.name,
					        info.email,
					        info.date,
					        info.message ] );

						$.fancybox.close( $('.modal') );

						$.fancybox.open('Спасибо за комментарий!');

					}else{
						$.fancybox.open('Ошибка ввода. Попробуйте еще раз!');
					}
				}
			})
			return false;
		});
	</script>

</body>
</html>