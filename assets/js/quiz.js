function showMessage(text, type) {
    var box = document.getElementById("message");
    if (!box) {
        return;
    }
    box.className = type === "success" ? "success" : "error";
    box.innerText = text;
}

document.querySelectorAll(".toggle-quiz").forEach(function (button) {
    button.addEventListener("click", function () {
        var quizId = this.getAttribute("data-id");
        var row = document.getElementById("quiz-" + quizId);
        var statusBadge = row.querySelector(".status-badge");

        fetch("../../api/quizzes/" + quizId + "/toggle", {
            method: "POST"
        })
            .then(function (response) {
                return response.json().then(function (data) {
                    if (!response.ok) {
                        throw data;
                    }
                    return data;
                });
            })
            .then(function (data) {
                statusBadge.innerText = data.status;
                button.innerText = data.status === "published" ? "Unpublish" : "Publish";
                showMessage("Quiz status updated.", "success");
            })
            .catch(function (error) {
                showMessage(error.message || "Could not update quiz status.", "error");
            });
    });
});
