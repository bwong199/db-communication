<?php
session_start();
require_once('connection.php');

if(isset($_POST['action']) && $_POST['action'] == 'interest')
{
	if(empty($_POST['color']))
	{
		$_SESSION['error']['color'] = 'color cannot be blank';
	}

	if($_FILES['file']['error'] > 0)
	{
		$_SESSION['error']['file'] = "Error on file upload Return Code: ".$_FILES['file']['error'];
	}
	else
	{
		$directory = 'upload/';
		$file_name = $_FILES['file']['name'];
		$file_path = $directory.$file_name;
		if(file_exists($file_path))
		{
			$_SESSION['error']['file'] = $file_name.' already exists'; 
		}
		else
		{
			if(!move_uploaded_file($_FILES['file']['tmp_name'], $file_path))
			{
				$_SESSION['error']['file'] = $file_name." could not be saved";
			}
		}
	}

	if(!isset($_SESSION['error']))
	{
		$query = "INSERT INTO interests (musics_id, color, file_path, created_at, updated_at)
				  VALUES(".$_POST['music'].", '" . $_POST['color'] . "', '" . $file_path . "', NOW(), NOW())";
		mysqli_query($connection, $query);

		$_SESSION['success'] = "Your interest was added successfully!";
	}
}
header('Location: index.php');
?>