<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{!TITLE!}</title>
</head>
<body>
	<table>
		<tr>
			<td>User</td>
			<td>Message</td>
		</tr>

		<?php

			$db->Query("select message.*, users.* from `message`, `users` where message.user_id = users.id ");

			while ($row = $db->FetchArray()) { ?>
				
				<tr>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['message']; ?></td>
				</tr>

		<?php }

		?>

	</table>
</body>
</html>