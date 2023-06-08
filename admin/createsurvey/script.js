const questionTypeForm = document.getElementById('question-type-form');
const questionsContainer = document.getElementById('questions-container');

// Handle question type selection
questionTypeForm.addEventListener('submit', e => {
  e.preventDefault();
  const questionTypeSelect = document.getElementById('question-type');
  const questionType = questionTypeSelect.value;
  createQuestion(questionType);
});

// Create question based on the selected type
function createQuestion(questionType) {
  const questionContainer = document.createElement('div');
  questionContainer.classList.add('question');

  const questionLabel = document.createElement('label');
  questionLabel.textContent = 'Question:';

  const questionInput = document.createElement('input');
  questionInput.setAttribute('type', 'text');

  const removeButton = document.createElement('button');
  removeButton.textContent = 'Remove';
  removeButton.setAttribute('type', 'button');
  removeButton.addEventListener('click', () => {
    questionContainer.remove();
  });

  questionContainer.appendChild(questionLabel);
  questionContainer.appendChild(questionInput);
  questionContainer.appendChild(removeButton);

  let optionsContainer;

  if (questionType === 'radio' || questionType === 'checkbox') {
    optionsContainer = document.createElement('div');
    optionsContainer.classList.add('options');

    const addOptionButton = document.createElement('button');
    addOptionButton.textContent = 'Add Option';
    addOptionButton.setAttribute('type', 'button');
    addOptionButton.addEventListener('click', () => {
      createOption(optionsContainer);
    });

    questionContainer.appendChild(optionsContainer);
    questionContainer.appendChild(addOptionButton);
  } else if (questionType === 'textarea') {
    const textarea = document.createElement('textarea');
    questionContainer.appendChild(textarea);
  }

  questionsContainer.appendChild(questionContainer);
}

// Create option for radio or checkbox question
function createOption(optionsContainer) {
  const optionContainer = document.createElement('div');
  optionContainer.classList.add('option');

  const optionInput = document.createElement('input');
  optionInput.setAttribute('type', 'text');

  const removeOptionButton = document.createElement('button');
  removeOptionButton.textContent = 'Remove';
  removeOptionButton.setAttribute('type', 'button');
  removeOptionButton.addEventListener('click', () => {
    optionContainer.remove();
  });

  optionContainer.appendChild(optionInput);
  optionContainer.appendChild(removeOptionButton);

  optionsContainer.appendChild(optionContainer);
}
