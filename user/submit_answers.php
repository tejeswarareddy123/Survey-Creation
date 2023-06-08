<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
	$email = $_SESSION["sess_email"];
	$title = $_SESSION["sess_title"];
    // Process submitted answers
    if (isset($_POST['question_ids']) && isset($_POST['answers'])) {
        $questionIds = $_POST['question_ids'];
        $answers = $_POST['answers'];

        // Insert answers into the database
        foreach ($questionIds as $questionId) {
            if (isset($answers[$questionId])) {
                $answerData = $answers[$questionId];

                if (is_array($answerData)) {
                    // Handle multiple-choice answers (checkbox or radio)
                    $answerIds = $answerData;
                    $answerText = implode(',', $answerIds);
                } else {
                    // Handle textarea answers
                    $answerIds = null;
                    $answerText = $answerData;
                }

                // Insert the answer into the database
                $stmt = $pdo->prepare("INSERT INTO answers (question_id, email, title, answer_text) VALUES (?, ?, ?, ?)");
                $stmt->execute([$questionId, $email, $title, $answerText]);
            }
        }

        // Display success message or perform additional actions
        echo "Answers submitted successfully!";
    } else {
        // No answers submitted
        echo "No answers were submitted.";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>
