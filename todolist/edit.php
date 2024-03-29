<?php
	include 'database.php';

	// select data yang akan diedit
	$q_select = "select * from tasks where taskid = '".$_GET['id']."' ";
	$run_q_select = mysqli_query($conn, $q_select);
	$d = mysqli_fetch_object($run_q_select);

	// proses edit data
	if(isset($_POST['edit'])){
		$task = $_POST['task'];
		$deadline = $_POST['deadline'];

		$q_update = "update tasks set tasklabel = '$task', deadline = '$deadline' where taskid = '".$_GET['id']."' ";
		$run_q_update = mysqli_query($conn, $q_update);

		if($run_q_update){
			header('Refresh:0; url=index.php');
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>To Do List - Edit Task</title>
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
		* {
			padding:0;
			margin:0;
			box-sizing: border-box;
		}
		body {
			font-family: 'Roboto', sans-serif;
			
			background-color: skyblue;  
			
		}
		.container {
			width: 590px;
			height: 100vh;
			margin: 0 auto;
			padding: 15px;
		}
		.header {
			padding-bottom: 10px;
			border-bottom: 1px solid #fff;
			margin-bottom: 20px;
		}
		.header .title {
			display: flex;
			align-items: center;
			margin-bottom: 7px;
		}
		.header .title a {
			text-decoration: none;
			color: #fff;
		}
		.header .title i {
			font-size: 24px;
			margin-right: 10px;
		}
		.header .title span {
			font-size: 18px;
		}
		.description {
			font-size: 13px;
		}
		.card {
			background-color: #fff;
			padding: 15px;
			border-radius: 5px;
		}
		.input-control {
			width: 100%;
			display: block;
			padding: 0.5rem;
			font-size: 1rem;
			margin-bottom: 10px;
		}
		.text-right {
			text-align: right;
		}
		button {
			padding: 0.5rem 1rem;
			font-size: 1rem;
			cursor: pointer;
			background: #4e54c8;
			color: #fff;
			border: 1px solid;
			border-radius: 3px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="header">
			<div class="title">
				<a href="index.php"><i class='bx bx-chevron-left'></i></a>
				<span>Back</span>
			</div>
			<div class="description">
				<?= date("l, d M Y") ?>
			</div>
		</div>
		<div class="content">
			<div class="card">
				<form action="" method="post">
					<input type="text" name="task" class="input-control" placeholder="Edit task" value="<?= $d->tasklabel ?>">
					<input type="date" name="deadline" class="input-control" placeholder="Edit deadline" value="<?= $d->deadline ?>">
					<div class="text-right">
						<button type="submit" name="edit">Edit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
