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

// Retrieve the answers from the database
$stmt = $pdo->query("SELECT questions.question, answers.answer_text, answers.email, answers.title 
                     FROM answers 
                     INNER JOIN questions ON answers.question_id = questions.id");
$answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
$ses_email = $_POST['email'];
$ses_title = $_SESSION['ses_title'];
?>

<!DOCTYPE html>
<html>
<head> 
  <title>Answer Report</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    h1 {
      text-align: center;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    table th, table td {
      padding: 15px;
      text-align: left;
    }
	table th {
      background-color: #f2f2f2;
      border-bottom: 2px solid #ddd;
      font-weight: bold;
    }

    table td {
      border-bottom: 1px solid #ddd;
    }

    table tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    table tr:hover {
      background-color: #f5f5f5;
    }
	p {
      margin: 10px 0;
    }

    .no-answers {
      text-align: center;
      color: #888;
      font-style: italic;
    }

    /* Styles for table responsiveness */
    @media only screen and (max-width: 600px) {
      table {
        font-size: 14px;
      }

      table th, table td {
        padding: 12px;
      }
    }
  </style>
  </style>
</head>
<body>
  <h1>User : <?php echo $ses_email; ?></h1>
  <h1>Title : <?php echo $ses_title; ?></h1>

  <?php if (count($answers) > 0) : ?>
    <table>
      <tr>
        <th>Question</th>
        <th>Answer Text</th>
      </tr>
	
      <?php foreach ($answers as $answer) : ?>
        <tr>
			<?php if($answer['email']==$ses_email and $answer['title']==$ses_title ) {?>
          <td><?php echo $answer['question']; ?></td>
          <td><?php echo $answer['answer_text']; ?></td>
			<?php } ?>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php else : ?>
    <p>No answers found.</p>
  <?php endif; ?>
</body>
</html>
