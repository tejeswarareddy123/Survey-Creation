<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['title'])) {
        $selectedTitle = $_POST['title'];
        // You can now use $selectedTitle in your code
        echo "Selected title: " . $selectedTitle;
		$_SESSION['sess_title']=$selectedTitle;
    }
}

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

// Retrieve the questions from the database
$stmt = $pdo->prepare("SELECT * FROM questions WHERE title = :selectedTitle");
$stmt->bindParam(':selectedTitle', $selectedTitle);
$stmt->execute();
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head> 
  <title>Answer Questions</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 20px;
    }

    h1 {
      color: #333;
    }

    form {
      background-color: #fff;
      border: 1px solid #ccc;
      padding: 20px;
      border-radius: 5px;
    }

    ul {
      list-style-type: none;
      padding: 0;
    }
	li {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    input[type="text"],
    textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    input[type="radio"],
    input[type="checkbox"] {
      margin-right: 5px;
    }
	button[type="submit"] {
      padding: 10px 20px;
      background-color: #4caf50;
      color: #fff;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }

    p.no-questions {
      color: #999;
      font-style: italic;
    }
  </style>

</head>
<body>
  <h1>Answer Questions</h1>

  <?php if (count($questions) > 0) : ?>
    <form method="post" action="submit_answers.php">
      <ul>
        <?php foreach ($questions as $question) : 
		
		?>
          <li>
            <strong>Question:</strong> <?php echo $question['question']; ?><br>
            <input type="hidden" name="question_ids[]" value="<?php echo $question['id']; ?>">
            <?php if ($question['question_type'] === 'radio' || $question['question_type'] === 'checkbox') : ?>
              <?php $options = getOptionsForQuestion($pdo, $question['id']); ?>
              <?php foreach ($options as $option) : ?>
                <label>
                  <input type="<?php echo $question['question_type']; ?>" name="answers[<?php echo $question['id']; ?>][]" value="<?php echo $option['option_text']; ?>">
                  <?php echo $option['option_text']; ?>
                </label><br>
              <?php endforeach; ?>
            <?php elseif ($question['question_type'] === 'textarea') : ?>
              <textarea name="answers[<?php echo $question['id']; ?>][]"></textarea><br>
            <?php endif; ?>
          </li>
		  
        <?php 
		endforeach; ?>
      </ul>
      <button type="submit">Submit Answers</button>
    </form>
  <?php else : ?>
    <p>No questions found.</p>
  <?php endif; ?>

  <?php
  function getOptionsForQuestion($pdo, $questionId) {
    $stmt = $pdo->prepare("SELECT * FROM options WHERE question_id = ?");
    $stmt->execute([$questionId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  ?>
</body>
</html>
