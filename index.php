<?php
session_start();
require_once('connection.php');
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>fun</title>
</head>
<body>
	<?php
	if(isset($_SESSION['error']))
	{
		foreach($_SESSION['error'] as $message)
		{
			echo '<p>' . $message . '</p>';
		}
	}
	else if(isset($_SESSION['success']))
	{
		echo '<p>' . $_SESSION['success'] . '</p>';
	}
	?>
	<form action="process.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="interest">
		<div>
			<label for="color">What is your favorite color?</label>
			<input type="text" name="color" placeholder="put your color here">
		</div>
		<div>
			<label for="color">What is your favorite type of music?</label>
			<select name="music">
				<?php
				$query = "SELECT id, name FROM musics";
				$result = mysqli_query($connection, $query);

				while($row = mysqli_fetch_assoc($result))
				{
				?>
					<option value="<?= $row['id']?>"><?= $row['name']?></option>
				<?php	
				}
				?>
			</select>
		</div>
		<div>
			<label for="color">Choose File:</label>
			<input type="file" name="file">
		</div>
		<div>
			<input type="submit" value="Submit">
		</div>
	</form>
	
		<?php
			$query = "SELECT interests.color, musics.name AS music, interests.file_path
					  FROM interests
					  JOIN musics ON interests.musics_id = musics.id";
			$result = mysqli_query($connection, $query);

			while($row = mysqli_fetch_assoc($result))
			{
			?>
			<div>
				<h2>Favorite Color: <?= $row['color'] ?></h2>
				<h2>Favorite Music: <?= $row['music'] ?></h2>
				<img width="200" src="<?= $row['file_path'] ?>">
			</div>
			<?php	
			}
		?>
	
</body>
</html>
<?php
$_SESSION = array();
?>