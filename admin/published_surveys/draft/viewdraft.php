<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['title'])) {
        $selectedTitle = $_POST['title'];
        // You can now use $selectedTitle in your code
        echo "Selected title: " . $selectedTitle;
		$_SESSION['title']=$selectedTitle;
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
$stmt = $pdo->prepare("SELECT * FROM draftquestions WHERE title = :selectedTitle");
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
	button[type="submit"],button[type="button"] {
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
	#questions-container {
  width: 600px;
  margin: 20px auto;
}
    body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f1f1f1;
}

.container {
  display: flex;
}

.box {
  flex: 1;
  padding: 30px;
  border: 1px solid #ccc;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  margin: 0 10px; /* Added to remove the left side space */
}

/* Rest of the styles... */

h1 {
  text-align: center;
  margin: 0;
  padding: 0;
  font-size: 24px;
  color: #333;
}

form {
  margin-top: 20px;
}

label {
  display: block;
  margin-bottom: 10px;
  font-size: 16px;
  color: #555;
}

input[type="text"],
select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
  color: #333;
  font-size: 14px;
}

button[type="button"],
button[type="submit"] {
  padding: 5px 10px; /* Adjusted padding for smaller size */
  border: none;
  border-radius: 3px; /* Adjusted border-radius for smaller size */
  cursor: pointer;
  font-size: 12px; /* Adjusted font-size for smaller size */
  font-weight: bold;
  text-transform: uppercase;
}


button[type="submit"] {
  background-color: #4CAF50;
  color: white;
}

button[type="button"] {
  background-color: #FF0000;
  color: white;
}

#questions-container {
  width: 600px;
  margin: 20px auto;
}

.question {
  margin-bottom: 20px;
  padding-bottom: 10px;
  border-bottom: 1px solid #ccc;
}

textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
  color: #333;
  font-size: 14px;
  resize: vertical;
}

.options {
  margin-top: 10px;
}

.options button {
  margin-top: 10px;
}

#preview-container {
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 10px;
  background-color: #f9f9f9;
}

.question-preview {
  margin-bottom: 20px;
}

.question-preview p {
  margin: 0;
  padding: 0;
  font-size: 16px;
  font-weight: bold;
}

.options-preview {
  margin-top: 10px;
}

.option-preview {
  margin-bottom: 10px;
}

.option-preview input[type="radio"],
.option-preview input[type="checkbox"] {
  margin-right: 10px;
}

  </style>

</head>
<body>

  <?php if (count($questions) > 0) : ?>
    <form method="post" action="">
      <ul>
        <?php 
		foreach ($questions as $question) : 
		
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
    </form>
	 <div>
		<div class="container">
    <div class="box" id="question-type-container">
	<h1>Add Questions</h1>
      <form id="question-form" method="post" action="submit_draft.php">
        <label for="question-type">Select Question Type:</label>
        <select id="question-type" name="question_type">
          <option value="radio">radio</option>
          <option value="checkbox">checkbox</option>
          <option value="textarea">text</option>
        </select>
        <button type="button" onclick="addQuestion()">Create Question</button>
        <button type="submit">Publish Survey</button>
        <br><br>
        <div id="questions-container"></div>
      </form>
    </div>

    <div class="box" id="preview-container"></div>
  </div>

  <script>
    let questionCount = 0;

    function addQuestion() {
      questionCount++;

      const questionsContainer = document.getElementById('questions-container');

      const questionContainer = document.createElement('div');
      questionContainer.classList.add('question');

      const questionLabel = document.createElement('label');
      questionLabel.textContent = `Question ${questionCount}:`;

      const questionInput = document.createElement('input');
      questionInput.setAttribute('type', 'text');
      questionInput.setAttribute('name', `question[${questionCount}]`);

      const removeButton = document.createElement('button');
      removeButton.textContent = 'Remove';
      removeButton.setAttribute('type', 'button');
      removeButton.addEventListener('click', () => {
        questionContainer.remove();
        updatePreview();
      });

      questionContainer.appendChild(questionLabel);
      questionContainer.appendChild(questionInput);
      questionContainer.appendChild(removeButton);

      const questionTypeSelect = document.getElementById('question-type');
      const questionType = questionTypeSelect.value;

      questionContainer.innerHTML += `<input type="hidden" name="question_type[${questionCount}]" value="${questionType}">`;

      if (questionType === 'radio' || questionType === 'checkbox') {
        const optionsContainer = document.createElement('div');
        optionsContainer.classList.add('options');

        const addOptionButton = document.createElement('button');
        addOptionButton.textContent = 'Add Option';
        addOptionButton.setAttribute('type', 'button');
        addOptionButton.addEventListener('click', () => {
          createOption(optionsContainer, questionCount);
          updatePreview();
        });

        questionContainer.appendChild(optionsContainer);
        questionContainer.appendChild(addOptionButton);
      }

      questionsContainer.appendChild(questionContainer);
      updatePreview();
    }

    function createOption(optionsContainer, questionCount) {
      const optionContainer = document.createElement('div');
      optionContainer.classList.add('option');

      const optionInput = document.createElement('input');
      optionInput.setAttribute('type', 'text');
      optionInput.setAttribute('name', `options[${questionCount}][]`);

      const removeOptionButton = document.createElement('button');
      removeOptionButton.textContent = 'Remove';
      removeOptionButton.setAttribute('type', 'button');
      removeOptionButton.addEventListener('click', () => {
        optionContainer.remove();
        updatePreview();
      });

      optionContainer.appendChild(optionInput);
      optionContainer.appendChild(removeOptionButton);

      optionsContainer.appendChild(optionContainer);
      updatePreview();
    }

    function updatePreview() {
      const previewContainer = document.getElementById('preview-container');
      const questionsContainer = document.getElementById('questions-container');

      previewContainer.innerHTML = '';

      for (let i = 0; i < questionsContainer.children.length; i++) {
        const question = questionsContainer.children[i];
        const questionText = question.querySelector('input[type="text"]').value;
        const questionType = question.querySelector('input[type="hidden"]').value;
        const options = Array.from(question.querySelectorAll('.option input[type="text"]')).map(option => option.value);

        const questionPreview = document.createElement('div');
        questionPreview.classList.add('question-preview');

        const questionTextPreview = document.createElement('p');
        questionTextPreview.textContent = `Question ${i + 1}: ${questionText}`;

        const questionTypePreview = document.createElement('p');
        questionTypePreview.textContent = `Type: ${questionType}`;

        questionPreview.appendChild(questionTextPreview);
        questionPreview.appendChild(questionTypePreview);

        if (questionType === 'radio' || questionType === 'checkbox') {
          const optionsPreview = document.createElement('div');
          optionsPreview.classList.add('options-preview');

          for (let j = 0; j < options.length; j++) {
            const optionPreview = document.createElement('div');
            optionPreview.classList.add('option-preview');

            const input = document.createElement('input');
            input.setAttribute('type', questionType);
            input.setAttribute('name', `question_${i}`);
            input.setAttribute('value', options[j]);

            const label = document.createElement('label');
            label.textContent = options[j];
            label.insertBefore(input, label.firstChild);

            optionPreview.appendChild(label);
            optionsPreview.appendChild(optionPreview);
          }

          questionPreview.appendChild(optionsPreview);
        }

        previewContainer.appendChild(questionPreview);
      }
    }
  </script>
	 </div>
  <?php else : ?>
    <p>No questions found.</p>
  <?php endif; ?>

  <?php
  function getOptionsForQuestion($pdo, $questionId) {
    $stmt = $pdo->prepare("SELECT * FROM draftoptions WHERE question_id = ?");
    $stmt->execute([$questionId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  ?>
</body>
</html>
