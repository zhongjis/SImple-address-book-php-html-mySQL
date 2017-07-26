<?php 
	session_start();

	$name = "";
	$address = "";
	$id = 0;
	$update = false;

	// conncet to database
	$db = mysqli_connect('localhost:8889', 'root', 'root', 'crud');

	//check if the database is connected
	if (!$db) {
		echo "ERROR: unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
	}

	// same records (save botton is clicked)
	if (isset($_POST['save'])) {
		$name = $_POST['name'];
		$address = $_POST['address'];

		$query = "INSERT INTO info (name, address) VALUES ('$name', '$address')";
		mysqli_query($db, $query);
		$_SESSION['msg'] = "Address saved";
		header('location: index.php');
	}

	// retrieve records
	$results = mysqli_query($db, "SELECT * FROM info");

	// update records
	if (isset($_POST['update'])) {
		$id = $_POST['id'];
		$name = $_POST['name'];
		$address = $_POST['address'];

		$query = "UPDATE info SET name='$name', address='$address' where id='$id'";
		mysqli_query($db, $query);
		$_SESSION['message'] = "Address updated!"; 
		header('location: index.php');
	}

	//delete records
	if (isset($_GET['del'])) {
		$id = $_GET['del'];
		mysqli_query($db, "DELETE FROM info WHERE id=$id");
		$_SESSION['msg'] = "Address removed";
		header('location: index.php');
	}

	//edit records
	if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$update = true;
		$record = mysqli_query($db, "SELECT * FROM info WHERE id=$id");

		if (!$record) {
			$_SESSION['msg'] = "Record not found";
		}
		else {
			$n = mysqli_fetch_array($record);
			$name = $n['name'];
			$address = $n['address'];
		}
	}

 ?>