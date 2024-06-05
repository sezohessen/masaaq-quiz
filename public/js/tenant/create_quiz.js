document.addEventListener('DOMContentLoaded', function () {
    const addQuestionButton = document.getElementById('add_question');
    const questionsContainer = document.getElementById('questions_container');
    let questionCounter = 0;

    function createElementFromHTML(htmlString) {
        const div = document.createElement('div');
        div.innerHTML = htmlString.trim();
        return div.firstChild;
    }

    function addQuestion() {
        const questionHtml = `
         <div class="question mb-4 bg-white p-4 rounded-lg shadow-sm" id="${questionCounter}">
                <div class="question-header flex justify-between items-center cursor-pointer bg-gray-200 p-2 rounded" onclick="toggleQuestion(${questionCounter})">
                    <label id="question_label_${questionCounter}" class="block text-sm font-medium text-gray-700 required ">Question</label>
                    <i class="fas fa-chevron-down ml-2 arrow"></i>
                </div>
                <div class="question-body mt-2" style="display: none;">
                    <input type="text" id="question_${questionCounter}_title" name="questions[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" data-required="true">
                    <label for="question_description_${questionCounter}" class="block text-sm font-medium text-gray-700 mt-2">Question Description</label>
                    <textarea id="question_description_${questionCounter}" name="question_descriptions[]" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                    <label for="question_score_${questionCounter}" class="block text-sm font-medium text-gray-700 mt-2 required ">Question Score</label>
                    <input type="number" id="question_score_${questionCounter}" name="question_scores[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <div class="choices mt-2 pl-4">
                        <!-- Choices will be dynamically added here -->
                    </div>
                    <button type="button" class="mt-2 px-4 py-2 bg-green-500 text-white rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75 add_choice">Add Choice</button>
                    <button type="button" class="mt-2 px-4 py-2 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75 remove_question">Remove Question</button>
                </div>
            </div>
        `;
        const questionElement = createElementFromHTML(questionHtml);
        questionsContainer.appendChild(questionElement);
        const choicesContainer = questionElement.querySelector('.choices');
        const addChoiceButton = questionElement.querySelector('.add_choice');
        const parentQuestion = addChoiceButton.closest('.question');
        addInitialChoices(parentQuestion, choicesContainer);
        addChoiceButton.addEventListener('click', () => {
            addChoice(parentQuestion, choicesContainer);
        });
        const removeQuestionButton = questionElement.querySelector('.remove_question');
        removeQuestionButton.addEventListener('click', () => removeQuestion(questionElement));
        questionCounter++;
        console.log(questionCounter);
    }

    function addInitialChoices(index, choicesContainer) {
        addChoice(index, choicesContainer, true); // Add the first choice as correct
        addChoice(index, choicesContainer);
    }

    function addChoice(parentQuestion, choicesContainer, isFirstChoice = false) {
        const index = parentQuestion.id;
        const choiceHtml = `
        <div class="choice mb-2 p-2 rounded-lg shadow-sm bg-white grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="col-span-1 md:col-span-1">
                <label for="choice_title_${index}" class="block text-sm font-medium text-gray-700 required ">Choice Title</label>
                <input type="text" id="choice_title_${index}" name="choices[${index}][]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" data-required="true">
            </div>
            <div class="col-span-1 md:col-span-1">
                <label for="choice_order_${index}" class="block text-sm font-medium text-gray-700">Choice Order</label>
                <input type="number" id="choice_order_${index}" name="choice_orders[${index}][]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            <div class="col-span-1 md:col-span-1">
                <label for="choice_description_${index}" class="block text-sm font-medium text-gray-700 mt-2">Choice Description</label>
                <textarea id="choice_description_${index}" name="choice_descriptions[${index}][]" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
            </div>
            <div class="col-span-1 md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mt-2">Is Correct</label>
                <div class="flex items-center space-x-2">
                <input type="radio" id="is_correct_${index}_${choicesContainer.children.length}" name="is_corrects[${index}][]" value="${choicesContainer.children.length}" class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" ${isFirstChoice ? 'checked' : ''}>
                <label for="is_correct_${index}_${choicesContainer.children.length}" class="text-sm text-gray-700 ">Yes</label>
                </div>
            </div>
            <button type="button" class="mt-2 col-span-1 md:col-span-2 px-4 py-2 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75 remove_choice">Remove Choice</button
        </div>
            `;
        const choiceElement = createElementFromHTML(choiceHtml);
        choicesContainer.appendChild(choiceElement);
        const removeChoiceButton = choiceElement.querySelector('.remove_choice');
        removeChoiceButton.addEventListener('click', () => removeChoice(choiceElement, choicesContainer));

        // Add event listener for "Is Correct" radio button in the newly added choice
        const isCorrectRadio = choiceElement.querySelector(`input[type="radio"][name="is_corrects[${index}][]"]`);
        isCorrectRadio.addEventListener('change', () => handleIsCorrectChange(isCorrectRadio, choicesContainer));
    }

    function handleIsCorrectChange(radio, choicesContainer) {
        if (radio.checked&&choicesContainer&&typeof index!=='undefined') {
            choicesContainer.querySelectorAll(`input[type="radio"][name="is_corrects[${index}][]"]`).forEach(r => {
                if (r !== radio) {
                    r.checked = false;
                }
            });
        }
    }

    function removeQuestion(questionElement) {
        if (questionsContainer.children.length > 1) {
            questionsContainer.removeChild(questionElement);
        } else {
            alert("You cannot remove this question. There must be at least one question in the quiz.");
        }
    }

    function removeChoice(choiceElement, choicesContainer) {
        if (choicesContainer.children.length > 2) {
            choicesContainer.removeChild(choiceElement);
        } else {
            alert("You cannot remove this choice. There must be at least two choices for each question.");
        }
    }

    addQuestion();

    addQuestionButton.addEventListener('click', () => addQuestion());
    const quizTypeSelect = document.getElementById('quiz_type');
    const timeContainer = document.getElementById('time_container');

    quizTypeSelect.addEventListener('change', function () {
        if (quizTypeSelect.value === '1') {
            timeContainer.style.display = 'block';
        } else {
            timeContainer.style.display = 'none';
        }
    });
      window.toggleQuestion = function(questionCounter) {
        const questionNumber = (questionCounter + 1) + ' - ';
        const questionElement = document.getElementById(`${questionCounter}`);
        const questionBody = questionElement.querySelector('.question-body');
        const arrow = questionElement.querySelector('.arrow');
        const questionTitle = questionElement.querySelector(`#question_${questionCounter}_title`);
        const questionLabel = questionElement.querySelector(`#question_label_${questionCounter}`);
        const questionScore = questionElement.querySelector(`#question_score_${questionCounter}`);

        if (questionBody.style.display === 'none') {
            questionBody.style.display = 'block';
            arrow.classList.remove('fa-chevron-down');
            arrow.classList.add('fa-chevron-up');
            questionLabel.innerText = questionNumber + 'Question';
            questionElement.classList.remove('border', 'border-red-500');
        } else {
            questionBody.style.display = 'none';
            arrow.classList.remove('fa-chevron-up');
            arrow.classList.add('fa-chevron-down');
            questionLabel.innerText = questionTitle.value ? questionNumber + questionTitle.value : questionNumber + 'Question';
            if (questionScore.value) {
                questionLabel.innerText += ` - (${questionScore.value})`;
            }
        }
    }
    function validateForm() {
        let valid = true;
        document.querySelectorAll('.question').forEach(question => {
            const questionBody = question.querySelector('.question-body');
            const requiredFields = question.querySelectorAll('[data-required="true"]');

            console.log(requiredFields);
            let questionValid = true;
            requiredFields.forEach(field => {
                if (!field.value) {
                    questionValid = false;
                }
            });
            if (!questionValid) {
                question.classList.add('border', 'border-red-500');
                questionBody.style.display = 'block';
                valid = false;
            } else {
                question.classList.remove('border', 'border-red-500');
                questionBody.style.display = 'none';
            }
        });
        return valid;
    }

    document.getElementById('quiz_form').addEventListener('submit', function(event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });

});
