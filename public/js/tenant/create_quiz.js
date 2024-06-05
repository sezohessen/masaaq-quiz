document.addEventListener('DOMContentLoaded', function () {
    const addQuestionButton = document.getElementById('add_question');
    const questionsContainer = document.getElementById('questions_container');
    let questionCounter = 1;

    function createElementFromHTML(htmlString) {
        const div = document.createElement('div');
        div.innerHTML = htmlString.trim();
        return div.firstChild;
    }

    function addQuestion() {
        const questionHtml = `
            <div class="question mb-4 bg-gray-100 p-4 rounded-lg shadow-sm" id="${questionCounter}">
                <label for="question_${questionCounter}" class="block text-sm font-medium text-gray-700">Question</label>
                <input type="text" id="question_${questionCounter}" name="questions[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                <label for="question_description_${questionCounter}" class="block text-sm font-medium text-gray-700 mt-2">Question Description</label>
                <textarea id="question_description_${questionCounter}" name="question_descriptions[]" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                <label for="question_score_${questionCounter}" class="block text-sm font-medium text-gray-700 mt-2">Question Score</label>
                <input type="number" id="question_score_${questionCounter}" name="question_scores[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <div class="choices mt-2 pl-4">
                    <!-- Choices will be dynamically added here -->
                </div>
                <button type="button" class="mt-2 px-4 py-2 bg-green-500 text-white rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75 add_choice">Add Choice</button>
                <button type="button" class="mt-2 px-4 py-2 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75 remove_question">Remove Question</button>
            </div>
        `;
        const questionElement = createElementFromHTML(questionHtml);
        questionsContainer.appendChild(questionElement);
        const choicesContainer = questionElement.querySelector('.choices');
        const addChoiceButton = questionElement.querySelector('.add_choice');
        const parentQuestion = addChoiceButton.closest('.question');
        addInitialChoices(parentQuestion,choicesContainer);
        addChoiceButton.addEventListener('click', () => {
            addChoice(parentQuestion, choicesContainer);
        });
        const removeQuestionButton = questionElement.querySelector('.remove_question');
        removeQuestionButton.addEventListener('click', () => removeQuestion(questionElement));
        questionCounter++;
        console.log(questionCounter);
    }

    function addInitialChoices(index,choicesContainer) {
        addChoice(index,choicesContainer, true); // Add the first choice as correct
        addChoice(index,choicesContainer);
    }

    function addChoice(parentQuestion,choicesContainer, isFirstChoice = false) {
        const index = parentQuestion.id;
        const choiceHtml = `
        <div class="choice mb-2 p-2 rounded-lg shadow-sm bg-white grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="col-span-1 md:col-span-1">
                <label for="choice_title_${index}" class="block text-sm font-medium text-gray-700">Choice Title</label>
                <input type="text" id="choice_title_${index}" name="choices[${index}][]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
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
                <label for="is_correct_${index}_${choicesContainer.children.length}" class="text-sm text-gray-700">Is Correct</label>
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
            if (radio.checked) {
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
    });
