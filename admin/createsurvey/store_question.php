<?php
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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract the submitted question data
    $questionTypes = $_POST['question_type'];
    $questions = $_POST['question'];
	$title = $_POST['title'];
	$stmt = $pdo->prepare("SELECT * FROM questions WHERE title = :title");
    $stmt->bindParam(':title', $title);
    $stmt->execute();
	$results = $stmt->fetchAll();
	if(count($results)==0) {
    // Store the questions in the database
    foreach ($questionTypes as $key => $questionType) {
        $question = $questions[$key];
		
        $stmt = $pdo->prepare("INSERT INTO questions (title,question_type, question) VALUES (?, ?, ?)");
        $stmt->execute([$title, $questionType, $question]);

        $questionId = $pdo->lastInsertId();

        if ($questionType === 'radio' || $questionType === 'checkbox') {
            $options = $_POST['options'][$key];

            // Store the options for the question
            foreach ($options as $option) {
                $stmt = $pdo->prepare("INSERT INTO options (question_id, title, option_text) VALUES (?, ?, ?)");
                $stmt->execute([$questionId, $title, $option]);
            }
        }
    }

    echo "Questions and options have been stored in the database.";
	}
	else {
		echo "Given title is already present in the database try another one";
	}
}
?>
