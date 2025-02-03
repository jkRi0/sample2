<?php
	include("db-connection.php");
	$searchId=-1;
	$message="";
	$message1="";

	// session_start();
    // $_SESSION['array2']=[];
	// $arr1=["",""];
	// $msg="";
	// $arr2=isset($_SESSION['array2'])?$_SESSION['array2']:$arr1;
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if ($_POST['submit'] == 'ADD') {
			$title = $_POST['title'];
			$copies = $_POST['copies'];
			$tempVar=false;

			$sql = "SELECT title FROM books";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					if(strcasecmp($title, $row['title']) == 0){
						$tempVar=true;
						break;
					}
				}
			}
			if($tempVar){
				$message = $title." book already exist";
			}else{
				if($copies>1){
					$sql = "INSERT into books(title,copies) values ('$title','$copies')";
					$conn->query($sql);
				}else{
					$message = $title." book must have a number of copies";
				}
				
			}


			// $arr1[0] = $title;
			// $arr1[1] = $copies;
			// array_push($arr2, $arr1);
			// $_SESSION['array2'] = $arr2;
		}else if ($_POST['submit'] == 'Search') {
			$input = $_POST['search'];
			$tempVar=false;

			$sql = "SELECT book_id,title FROM books";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					if(strcasecmp($input, $row['title']) == 0){
						$searchId=$row['book_id'];
						$tempVar=true;
						break;
					}
				}
			}
			if(!$tempVar){
				$message1 = $input." book not found";
			}



			// for ($count = 0; $count < count($arr2); $count++) {
			// 	for ($count1 = 0; $count1 < 2; $count1++) {
			// 		if ($arr2[$count][$count1] == $input) {
			// 			$msg = "Book found";
			// 		}
			// 	}
			// }
		}
	}

	//$tempCount = count($arr2);
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Library Management System</title>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<style>
		body {
			font-family: 'Roboto', sans-serif;
			background-color: #f4f7fa;
			margin: 0;
			padding: 0;
		}

		.container {
			width: 90%;
			max-width: 1000px;
			margin: 0 auto;
			padding: 20px;
		}

		h1 {
			text-align: center;
			color: #333;
		}

		.form-container {
			background-color: white;
			border-radius: 8px;
			padding: 20px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			margin-bottom: 20px;
			margin:40px;
			width: 300px;
		}

		input[type="text"],input[type="number"]  {
			width: 100%;
			padding: 10px;
			margin: 8px 0;
			border: 1px solid #ccc;
			border-radius: 4px;
			font-size: 16px;
			box-sizing: border-box;
		}

		input[type="submit"] {
			background-color: #5c6bc0;
			color: white;
			border: none;
			padding: 10px 20px;
			font-size: 16px;
			cursor: pointer;
			border-radius: 4px;
		}

		input[type="submit"]:hover {
			background-color: #3f51b5;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
		}

		table th, table td {
			padding: 12px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}

		table th {
			background-color: #5c6bc0;
			color: white;
		}

		.message {
			color: green;
			font-weight: bold;
			text-align: center;
			margin-top: 20px;
		}

		@media (max-width: 768px) {
			.container {
				width: 100%;
				padding: 10px;
			}

			input[type="submit"] {
				width: 100%;
			}
		}
		.container1{
			display:flex;
			justify-content:center;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Library Management System</h1>
		<div class="container1">
			<div class="form-container">
				<h2>Add Book</h2>
				<form action="index.php" method="POST">
					<input type="text" name="title" placeholder="Enter book title" required><br>
					<input type="number" name="copies" placeholder="Enter available copies" required><br>
					<input type="submit" name="submit" value="ADD">
				</form><p style="color:red;"><?php echo isset($message)?$message:""; ?>
			</div></p><br><br>
			

			<div class="form-container">
				<h2>Search Book</h2>
				<form action="" method="POST">
					<input type="text" name="search" placeholder="Search a title" required>
					<input type="submit" name="submit" value="Search">
				</form><p style="color:red;"><?php echo isset($message1)?$message1:""; ?>
			</div>
		</div>

		
		</p><br><br>
		

		<div id="book-list">
			<h2>Book List</h2>
			<table id="book-table">
				<thead>
					<tr>
						<th>Title</th>
						<th>Available Copies</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = "SELECT book_id, title, copies FROM books";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							$var1=isset($searchId)? ($row['book_id']==$searchId?'#66FF66':'white'):'white';

							echo "<tr style='background-color:".$var1."'>
								<td>{$row['title']}</td>
								<td>{$row['copies']}</td>
							</tr>";
						}
					} else {
						echo "<tr><td colspan='6'>No products found</td></tr>";
					}


					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
