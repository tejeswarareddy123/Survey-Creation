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

// Retrieve the questions from the database
$stmt = $pdo->query("SELECT * FROM questions");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head> 
  <title>Answer Questions</title>
</head>
<body>
  <h1>Answer Questions</h1>

  <?php if (count($questions) > 0) : ?>
    <form method="post" action="submit_answers.php">
      <ul>
        <?php foreach ($questions as $question) : ?>
          <li>
            <strong>Question:</strong> <?php echo $question['question']; ?><br>
            <input type="hidden" name="question_ids[]" value="<?php echo $question['id']; ?>">
            <?php if ($question['question_type'] === 'radio' || $question['question_type'] === 'checkbox') : ?>
              <?php $options = getOptionsForQuestion($pdo, $question['id']); ?>
              <?php foreach ($options as $option) : ?>
                <label>
                  <input type="<?php echo $question['question_type']; ?>" name="answers[<?php echo $question['id']; ?>][]" value="<?php echo $option['id']; ?>">
                  <?php echo $option['option_text']; ?>
                </label><br>
              <?php endforeach; ?>
            <?php elseif ($question['question_type'] === 'textarea') : ?>
              <textarea name="answers[<?php echo $question['id']; ?>][]"></textarea><br>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
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
