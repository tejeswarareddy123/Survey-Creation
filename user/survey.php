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
$sess_email = $_SESSION["sess_email"];

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
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
		th, td {
            padding: 12px;
            text-align: center;
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
    <form action="answer_questions.php" method="POST">
		<table>
		<tr>
			<th style="width:70%">Survey titles</th>
			<th style ="width:30%">Status</th>
		</tr>
        <?php foreach ($titles as $title) : ?>
			<tr>
			<?php	$stmt = $pdo->prepare("SELECT COUNT(*) FROM answers WHERE title = ? AND email = ?");
					$stmt->execute([$title, $sess_email]);
					$count = $stmt->fetchColumn();
			if ($count == 0) {
			?>
				<td><?php echo $title ?></td>
				<td><button type="submit" class="title-button" name="title" value = "<?php echo $title ?>">Click to answer</button></td>
			<?php 
			}
			else {
			?>
				<td><?php echo $title ?></td>
				<td style="color:red">Already answered</td>
			</tr>
			<?php } ?>
        <?php endforeach; ?>
		</table>
    </form>
</body>
</html>
