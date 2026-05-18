function message(text, type) {
    var box = document.getElementById("message");
    if (!box) {
        return;
    }
    box.className = type === "success" ? "success" : "error";
    box.innerText = text;
}

function escapeHtml(text) {
    return text
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;")
        .replaceAll("'", "&#039;");
}

function buildDisplayHtml(questionText, marks, options, correctIndex) {
    var html = "";
    html += '<div class="question-display">';
    html += '<h3 class="question-text">' + escapeHtml(questionText) + '</h3>';
    html += '<p>Marks: <span class="question-marks">' + escapeHtml(String(marks)) + '</span></p>';
    html += '<ol type="A">';

    options.forEach(function (option, index) {
        var isCorrect = Number(correctIndex) === index;
        html += '<li class="option-text" data-correct="' + (isCorrect ? "1" : "0") + '">';
        html += escapeHtml(option);
        if (isCorrect) {
            html += " <strong>(Correct)</strong>";
        }
        html += '</li>';
    });

    html += '</ol>';
    html += '<button class="btn small edit-question">Edit</button> ';
    html += '<button class="btn danger small delete-question">Delete</button>';
    html += '</div>';
    return html;
}

function makeEditForm(card) {
    var questionText = card.querySelector(".question-text").innerText;
    var marks = card.querySelector(".question-marks").innerText;
    var optionItems = card.querySelectorAll(".option-text");
    var correctIndex = 0;
    var html = "";

    html += '<div class="question-edit">';
    html += '<label>Question Text</label>';
    html += '<textarea class="edit-question-text">' + escapeHtml(questionText) + '</textarea>';
    html += '<label>Marks</label>';
    html += '<input type="number" class="edit-marks" min="1" value="' + marks + '">';
    html += '<div class="edit-options">';

    optionItems.forEach(function (item, index) {
        if (item.getAttribute("data-correct") === "1") {
            correctIndex = index;
        }
    });

    optionItems.forEach(function (item, index) {
        var checked = correctIndex === index ? "checked" : "";
        var cleanText = item.childNodes[0].nodeValue.trim();
        html += '<div class="option-line">';
        html += '<input type="radio" name="correct_' + card.getAttribute("data-id") + '" value="' + index + '" ' + checked + '>';
        html += '<input type="text" class="edit-option" value="' + escapeHtml(cleanText) + '">';
        html += '</div>';
    });

    html += '</div>';
    html += '<button class="btn small save-question">Save</button> ';
    html += '<button class="btn small cancel-edit">Cancel</button>';
    html += '</div>';

    card.setAttribute("data-old-html", card.innerHTML);
    card.innerHTML = html;
}

document.addEventListener("click", function (event) {
    if (event.target.classList.contains("edit-question")) {
        makeEditForm(event.target.closest(".question-card"));
    }

    if (event.target.classList.contains("cancel-edit")) {
        var card = event.target.closest(".question-card");
        card.innerHTML = card.getAttribute("data-old-html");
    }

    if (event.target.classList.contains("save-question")) {
        var card = event.target.closest(".question-card");
        var questionId = card.getAttribute("data-id");
        var optionInputs = card.querySelectorAll(".edit-option");
        var options = [];
        var correct = card.querySelector("input[type='radio']:checked").value;

        optionInputs.forEach(function (input) {
            options.push(input.value);
        });

        fetch("../../api/questions/" + questionId, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                question_text: card.querySelector(".edit-question-text").value,
                marks: card.querySelector(".edit-marks").value,
                options: options,
                correct_option: correct
            })
        })
            .then(function (response) {
                return response.json().then(function (data) {
                    if (!response.ok) {
                        throw data;
                    }
                    return data;
                });
            })
            .then(function () {
                var newQuestionText = card.querySelector(".edit-question-text").value;
                var newMarks = card.querySelector(".edit-marks").value;
                card.innerHTML = buildDisplayHtml(newQuestionText, newMarks, options, correct);
                message("Question updated.", "success");
            })
            .catch(function (error) {
                message(error.message || "Could not update question.", "error");
            });
    }

    if (event.target.classList.contains("delete-question")) {
        if (!confirm("Delete this question?")) {
            return;
        }

        var card = event.target.closest(".question-card");
        var questionId = card.getAttribute("data-id");

        fetch("../../api/questions/" + questionId, {
            method: "DELETE"
        })
            .then(function (response) {
                return response.json().then(function (data) {
                    if (!response.ok) {
                        throw data;
                    }
                    return data;
                });
            })
            .then(function () {
                card.remove();
                message("Question deleted.", "success");
            })
            .catch(function (error) {
                message(error.message || "Could not delete question.", "error");
            });
    }
});
