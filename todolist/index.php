<?php
	include 'database.php';

	// proses insert data
	if(isset($_POST['add'])){
		$task = $_POST['task'];
		$deadline = $_POST['deadline']; 
		$q_insert = "INSERT INTO tasks (tasklabel, taskstatus, deadline) VALUES (
			'$task',
			'open',
			'$deadline'
		)";
		$run_q_insert = mysqli_query($conn, $q_insert);
		if($run_q_insert){
			header('Refresh:0; url=index.php');
		}
	}

	// proses show data
	$q_select = "select * from tasks order by taskid desc";
	$run_q_select = mysqli_query($conn, $q_select);

	// proses delete data
	if(isset($_GET['delete'])){
		$q_delete = "delete from tasks where taskid = '".$_GET['delete']."' ";
		$run_q_delete = mysqli_query($conn, $q_delete);
		header('Refresh:0; url=index.php');
	}

	// proses update data (close or open)
	if(isset($_GET['done'])){
		$status = 'close';

		if($_GET['status'] == 'open'){
			$status = 'close';
		}else{
			$status = 'open';
		}
		$q_update = "update tasks set taskstatus = '".$status."' where taskid = '".$_GET['done']."' ";
		$run_q_update = mysqli_query($conn, $q_update);

		header('Refresh:0; url=index.php');
	}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>To Do List</title>
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
            margin:0 auto;
        }
        .header {
            padding: 15px;
            color: #fff;
        }
        .header .title {
            display: flex;
            align-items: center;
            margin-bottom: 7px;
        }
        .header .title i {
            font-size: 24px;
            margin-right: 10px;
        }
        .header .title span {
            font-size: 18px;
        }
        .header .description {
            font-size: 13px;
        }
        .content {
            padding: 15px;
        }
        .card {
            background-color: #fff;
            padding:15px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .input-control {
            width:100%;
            display: block;
            padding:0.5rem;
            font-size: 1rem;
            margin-bottom: 10px;
        }
        .text-right {
            text-align: right;
        }
        button {
            padding:0.5rem 1rem;
            font-size: 1rem;
            cursor: pointer;
            background: #4e54c8;  
            background: -webkit-linear-gradient(to right, #8f94fb, #4e54c8);  
            background: linear-gradient(to right, #8f94fb, #4e54c8); 
            color: #fff;
            border:1px solid;
            border-radius: 3px;
        }
        .task-item {
            display: flex;
            flex-direction: column;
            background-color: #fff; 
            padding: 10px; 
            border-radius: 5px; 
            margin-bottom: 10px; 
        }
        .task-item .task-content {
            display: flex;
            align-items: center;
            justify-content: space-between; 
            text-align: left; 
        }
        .task-item.done span {
            text-decoration: line-through;
            color: #ccc;
        }
        .task-item .deadline {
            margin-top: 5px; 
            font-size: 14px;
            color: #666; 
        }
        .text-orange {
            color: orange;
        }
        .text-red {
            color: red;
        }
        @media (max-width: 768px){
            .container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">    
        <div class="header">
            <div class="title">
                <i class='bx bx-sun'></i>
                <span>To Do List</span>
            </div>
            <div class="description">
                <?= date("l, d F Y") ?> 
            </div>
        </div>
        <div class="content">
            <div class="card">        
                <form action="" method="post">
                    <input type="text" name="task" class="input-control" placeholder="Add task">
                    <input type="date" name="deadline" class="input-control" placeholder="Deadline">
                    <div class="text-right">
                        <button type="submit" name="add">Add</button>
                    </div>
                </form>
            </div>
            <?php
                if(mysqli_num_rows($run_q_select) > 0){
                    while($r = mysqli_fetch_array($run_q_select)){
            ?>
            <div class="task-item <?= $r['taskstatus'] == 'close' ? 'done':'' ?>">
                <div class="task-content">
                    <input type="checkbox" onclick="window.location.href = '?done=<?= $r['taskid'] ?>&status=<?= $r['taskstatus'] ?>'" <?= $r['taskstatus'] == 'close' ? 'checked':'' ?>>
                    <span><?= $r['tasklabel'] ?></span>
                    <div>
                        <a href="edit.php?id=<?= $r['taskid'] ?>" class="text-orange" title="Edit"><i class="bx bx-edit"></i></a>
                        <a href="?delete=<?= $r['taskid'] ?>" class="text-red" title="Remove" onclick="return confirm('Apakah anda yakin ingin menghapus ?')"><i class="bx bx-trash"></i></a>
                    </div>
                </div>
                <?php if(!empty($r['deadline'])): ?>
                    <div class="deadline">Deadline: <?= date("d F Y", strtotime($r['deadline'])) ?></div>
                <?php endif; ?>
            </div>
            <?php }} else { ?>
                <div>Belum ada task</div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
