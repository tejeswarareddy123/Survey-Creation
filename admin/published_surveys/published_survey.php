<?php
session_start();
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "temp";

// Create a new PDO instance
$dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Retrieve the distinct titles from the database
$stmt = $pdo->query("SELECT DISTINCT title FROM questions");
$titles = $stmt->fetchAll(PDO::FETCH_COLUMN);

$stmt = $pdo->query("SELECT DISTINCT title FROM draftquestions");
$drtitles = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Display Titles</title>
	<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
        }

        h1 {
            text-align: center;
            color: #333333;
        }

        table {
            width: 80%;
            margin: 0 auto;
			margin-left:0px;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
		th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dddddd;
        }

        th {
            background-color: #f9f9f9;
            color: #333333;
            font-weight: bold;
        }

        tr:last-child td {
            border-bottom: none;
        }
		.title-button {
            padding: 8px 12px;
            border: none;
            background-color: #4caf50;
            color: #ffffff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .title-button:hover {
            background-color: #45a049;
        }

        .already-answered {
            color: #999999;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Published Surveys</h1>
    <form action="./users.php" method="POST">
		<table>
		<tr>
			<th style="width:70%">Survey titles</th>
			<th style ="width:30%">Status</th>
		</tr>
        <?php foreach ($titles as $title) : ?>
			<tr>
				<td><?php echo $title ?></td>
				<td><button type="submit" class="title-button" name="title" value = "<?php echo $title ?>">View respones</button></td>
			</tr>
        <?php endforeach; ?>
		</table>
    </form>
	<h1>Drafted Surveys</h1>
	<form action="draft/viewdraft.php" method="POST">
		<table>
		<tr>
			<th style="width:70%">Survey titles</th>
			<th style ="width:30%">Status</th>
		</tr>
        <?php foreach ($drtitles as $title) : ?>
			<tr>
				<td><?php echo $title ?></td>
				<td><button type="submit" class="title-button" name="title" value = "<?php echo $title ?>">Edit Survey</button></td>
			</tr>
        <?php endforeach; ?>
		</table>
    </form>
</body>
</html>
