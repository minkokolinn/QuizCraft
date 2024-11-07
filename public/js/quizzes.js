var selectedQuizId = [];
var emptyPositions = [];
var typeIdd = null;
var paperId = document.getElementById("paperIdHidden").textContent;
var grade = document.getElementById("gradeHidden").textContent;
var setupquizzesmodal = new bootstrap.Modal(
    document.getElementById("setupquizzes-modal")
);
function setupQuizzesModal(typeId) {
    var emptyInfo=getEmptyField(typeId);
    var left = emptyInfo[0];
    emptyPositions = emptyInfo[1];

    typeIdd = typeId;
    const btnSubmitSetupQuizzes = document.getElementById(
        "btnSubmitSetupQuizzes"
    );
    const setupquizzesmodalTitle = document.getElementById("setupquizzesTitle");
    const setupquizzesmodalBody = document.getElementById("setupquizzesBody");
    const leftTxt = document.getElementById("left");
    leftTxt.textContent = left;

    fetch(`/paper/quizzes?type=${typeId}&grade=${grade}`)
        .then((response) => response.json())
        .then((data) => {
            if (data.error) {
                showToast("danger", "white", data.error, 5000);
            } else {
                const allQuizzes = data.data;
                if (allQuizzes) {
                    setupquizzesmodalTitle.textContent =
                        allQuizzes[0].type.name;
                    setupquizzesmodalBody.innerHTML = "";
                    var count = 0;
                    allQuizzes.forEach((quiz) => {
                        count++;
                        var checkInput = document.createElement("div");
                        checkInput.className = "form-check";
                        checkInput.classList.add("border-bottom");
                        if (quiz.type.id == 3) {
                            let bodyObj = JSON.parse(quiz.body);
                            checkInput.innerHTML = `
                            <input class="form-check-input" type="checkbox" value="${quiz.id}" id="${quiz.id}">
                            <label class="form-check-label" for="${quiz.id}">
                            <strong>${bodyObj.body}<strong></label>
                            <br>
                            <span class="badge bg-dark">A. ${bodyObj.A}</span>
                            <span class="badge bg-dark">B. ${bodyObj.B}</span>
                            <span class="badge bg-dark">C. ${bodyObj.C}</span>
                            <span class="badge bg-dark mb-3">D. ${bodyObj.D}</span>`;
                        } else {
                            checkInput.innerHTML = `
                            <input class="form-check-input" type="checkbox" value="${quiz.id}" id="${quiz.id}">
                            <label class="form-check-label" for="${quiz.id}">
                            <strong>${quiz.body}</strong>
                            </label>`;
                        }
                        setupquizzesmodalBody.appendChild(checkInput);
                    });

                    // Listen check event to quizzesList
                    setupquizzesmodalBody.addEventListener(
                        "change",
                        function (event) {
                            const checkBox = event.target;
                            if (
                                checkBox &&
                                checkBox.matches('input[type="checkbox"]')
                            ) {
                                const quizId = checkBox.value;
                                if (checkBox.checked) {
                                    if (!selectedQuizId.includes(quizId)) {
                                        selectedQuizId.push(quizId);
                                    }
                                    left--;
                                } else {
                                    selectedQuizId = selectedQuizId.filter(
                                        (item) => item != quizId
                                    );
                                    left++;
                                }
                                leftTxt.textContent = left;
                            }
                            console.log(selectedQuizId);
                            if (left == 0) {
                                btnSubmitSetupQuizzes.removeAttribute(
                                    "disabled"
                                );
                            } else {
                                btnSubmitSetupQuizzes.setAttribute(
                                    "disabled",
                                    ""
                                );
                            }
                        }
                    );
                } else {
                    showToast("info", "black", "No Data Found!", 2000);
                }
            }
        })
        .catch((error) => {
            showToast("danger", "white", error.message, 5000);
        });

    setupquizzesmodal.show();
}

function filterByChapter(selectElement){
    var emptyInfo=getEmptyField(typeIdd);
    var left = emptyInfo[0];
    emptyPositions = emptyInfo[1];

    const btnSubmitSetupQuizzes = document.getElementById(
        "btnSubmitSetupQuizzes"
    );
    const setupquizzesmodalTitle = document.getElementById("setupquizzesTitle");
    const setupquizzesmodalBody = document.getElementById("setupquizzesBody");
    const leftTxt = document.getElementById("left");
    leftTxt.textContent = left;
    setupquizzesmodalBody.innerHTML = "";
    
    var selectedValue = selectElement.value;

    fetch(`/paper/quizzes?type=${typeIdd}&grade=${grade}&chapter=${selectedValue}`)
        .then((response) => response.json())
        .then((data) => {
            if (data.error) {
                showToast("danger", "white", data.error, 5000);
            } else {
                const allQuizzes = data.data;
                if (allQuizzes.length>0) {
                    setupquizzesmodalTitle.textContent =
                        allQuizzes[0].type.name;
                    setupquizzesmodalBody.innerHTML = "";
                    var count = 0;
                    allQuizzes.forEach((quiz) => {
                        count++;
                        var checkInput = document.createElement("div");
                        checkInput.className = "form-check";
                        checkInput.classList.add("border-bottom");
                        if (quiz.type.id == 3) {
                            let bodyObj = JSON.parse(quiz.body);
                            checkInput.innerHTML = `
                            <input class="form-check-input" type="checkbox" value="${quiz.id}" id="${quiz.id}">
                            <label class="form-check-label" for="${quiz.id}">
                            <strong>${bodyObj.body}<strong></label>
                            <br>
                            <span class="badge bg-dark">A. ${bodyObj.A}</span>
                            <span class="badge bg-dark">B. ${bodyObj.B}</span>
                            <span class="badge bg-dark">C. ${bodyObj.C}</span>
                            <span class="badge bg-dark mb-3">D. ${bodyObj.D}</span>`;
                        } else {
                            checkInput.innerHTML = `
                            <input class="form-check-input" type="checkbox" value="${quiz.id}" id="${quiz.id}">
                            <label class="form-check-label" for="${quiz.id}">
                            <strong>${quiz.body}</strong>
                            </label>`;
                        }
                        setupquizzesmodalBody.appendChild(checkInput);
                    });

                    // Listen check event to quizzesList
                    setupquizzesmodalBody.addEventListener(
                        "change",
                        function (event) {
                            const checkBox = event.target;
                            if (
                                checkBox &&
                                checkBox.matches('input[type="checkbox"]')
                            ) {
                                const quizId = checkBox.value;
                                if (checkBox.checked) {
                                    if (!selectedQuizId.includes(quizId)) {
                                        selectedQuizId.push(quizId);
                                    }
                                    left--;
                                } else {
                                    selectedQuizId = selectedQuizId.filter(
                                        (item) => item != quizId
                                    );
                                    left++;
                                }
                                leftTxt.textContent = left;
                            }
                            console.log(selectedQuizId);
                            if (left == 0) {
                                btnSubmitSetupQuizzes.removeAttribute(
                                    "disabled"
                                );
                            } else {
                                btnSubmitSetupQuizzes.setAttribute(
                                    "disabled",
                                    ""
                                );
                            }
                        }
                    );
                } else {
                    showToast("info", "black", "No Data Found!", 2000);
                }
            }
        })
        .catch((error) => {
            showToast("danger", "white", error.message, 5000);
        });
}

function attachPaperQuizzes(paperId) {
    // console.log(typeIdd);
    // console.log(selectedQuizId);
    // console.log("Paper id "+paperId);

    const formData = new FormData();
    formData.append("paperId", paperId);
    formData.append("quizzesId", selectedQuizId);
    formData.append("emptyPositions", emptyPositions);
    fetch("/paper/quizzes/attach", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": getCSRFToken(),
        },
    })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            if (data.error) {
                showToast("danger", "white", data.error, 5000);
            } else {
                showToast("success", "white", data.message, 2000);
                cleanup();
                setupquizzesmodal.hide();
                renderQuizzes();
            }
        })
        .catch((error) => {
            showToast("danger", "white", error.message, 5000);
        });
}

function detachPaperQuiz(quizId) {
    const formData = new FormData();
    formData.append("paperId", paperId);
    formData.append("quizId", quizId);
    fetch("/paper/quizzes/detach", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": getCSRFToken(),
        },
    })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            if (data.error) {
                showToast("danger", "white", data.error, 5000);
            } else {
                showToast("success", "white", data.message, 1000);
                renderQuizzes();
            }
        })
        .catch((error) => {
            showToast("danger", "white", error.message, 5000);
        });
}

function cleanup() {
    typeIdd = null;
    selectedQuizId.splice(0, selectedQuizId.length);
}

function getEmptyField(typeId) { 
    const desiredUl = document.getElementById(`ul${typeId}`);
    const liElements = desiredUl.querySelectorAll("li");
    let empty_li_count = 0;
    let empty_li_positions = [];
    liElements.forEach((li) => {
        const span = li.querySelector("span");
        if (span.textContent.trim() === "") {
            empty_li_count++;
            empty_li_positions.push(li.id);
        }
    });
    return [empty_li_count,empty_li_positions];
}

// ======================================================================================
// render or refersh quizzes in addquizzes page
function renderQuizzes() {
    fetch(`/paper/render?paperId=${paperId}`)
        .then((response) => response.json())
        .then((data) => {
            if (data.error) {
                showToast("danger", "white", data.error, 5000);
            } else {
                showToast(
                    "info",
                    "black",
                    "🎉 Fetched Data Successfully 🎊",
                    1000
                );
                const thewholepaper = data.thewholepaper;

                const paperContent = document.getElementById("paperContent");
                paperContent.innerHTML = "";

                var sectionCount = 0;
                thewholepaper.forEach((section) => {
                    sectionCount++;

                    const headerDiv = document.createElement("div");
                    headerDiv.classList.add(
                        "d-flex",
                        "justify-content-between",
                        "mt-2"
                    );
                    headerDiv.innerHTML = `
                    <div class="d-flex justify-content-between mt-2">
                        <div class="d-flex flex-row">${sectionCount}.
                            &nbsp;&nbsp;&nbsp;<strong>${section.type_header}</strong>
                            <span>&nbsp;&nbsp;&nbsp;(${section.mark} - marks)</span>
                        </div>
                        <button class="btn btn-outline-primary mx-3"
                            onclick="setupQuizzesModal(${section.type_id})"><i
                                class="bi bi-database-fill-add"></i></button>
                    </div>`;
                    paperContent.append(headerDiv);

                    const headerUl = document.createElement("ul");
                    headerUl.classList.add("list-group", "mb-4");
                    headerUl.setAttribute("id", `ul${section.type_id}`);
                    for (const position in section.body) {
                        if (section.body.hasOwnProperty(position)) {
                            const quiz = section.body[position];
                            if (quiz == "") {
                                headerUl.innerHTML += `
                            <li id="${position}" class="list-group-item">
                            <button class="btn btn-sm btn-link" onclick="detachPaperQuiz(${quiz.id})">
                            <i class="bi bi-x-circle-fill"></i></button>
                            ${position} . <span></span></li>`;
                            } else {
                                if (quiz.type.id == 3) {
                                    var mcq = JSON.parse(quiz.body);
                                    headerUl.innerHTML += `
                                <li id="${position}" class="list-group-item">
                                <button class="btn btn-sm btn-link" onclick="detachPaperQuiz(${quiz.id})">
                                <i class="bi bi-x-circle-fill"></i></button>
                                    ${position} . <span>${mcq.body}</span>
                                    <br>
                                    <span class="badge bg-dark">A. ${mcq.A}</span>
                                    <span class="badge bg-dark">B. ${mcq.B}</span>
                                    <span class="badge bg-dark">C. ${mcq.C}</span>
                                    <span class="badge bg-dark">D. ${mcq.D}</span>
                                </li>`;
                                } else {
                                    headerUl.innerHTML += `
                                <li id="${position}" class="list-group-item">
                                <button class="btn btn-sm btn-link" onclick="detachPaperQuiz(${quiz.id})">
                                <i class="bi bi-x-circle-fill"></i></button>
                                ${position} . <span>${quiz.body}</span></li>
                                `;
                                }
                            }
                        }
                    }
                    paperContent.append(headerUl);
                });
            }
        })
        .catch((error) => {
            showToast("danger", "white", error.message, 5000);
        });
}
renderQuizzes();

// ======================================================================================
// toast message
function showToast(type, text, message, delay) {
    // Create toast element
    var toast = document.createElement("div");
    toast.classList.add("toast");
    toast.classList.add(`bg-${type}`);
    toast.classList.add("bg-gradient");
    toast.classList.add(`text-${text}`);
    toast.classList.add("mb-2");
    toast.setAttribute("role", "alert");
    toast.setAttribute("aria-live", "assertive");
    toast.setAttribute("aria-atomic", "true");

    // Set toast content
    toast.innerHTML = `
    <div class="d-flex">
        <div class="toast-body">
        ${message}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    `;

    // Append toast to container
    document.getElementById("toastContainer").appendChild(toast);

    // Initialize Bootstrap Toast
    var toastInstance = new bootstrap.Toast(toast);

    // Show the toast
    toastInstance.show();

    // Automatically remove toast after delay milliseconds
    setTimeout(function () {
        toastInstance.hide();
        toast.addEventListener("hidden.bs.toast", function () {
            toast.remove(); // Remove the toast from DOM
        });
    }, delay);
}
function getCSRFToken() {
    const metaTags = document.getElementsByTagName("meta");
    for (let i = 0; i < metaTags.length; i++) {
        if (metaTags[i].getAttribute("name") === "csrf-token") {
            return metaTags[i].getAttribute("content");
        }
    }
    return null;
}
// =========================================================================
// search quiz in model
function searchQuizzes(event) {
    var value = event.target.value.toLowerCase();
    var p = document.querySelectorAll("#setupquizzesBody div");

    p.forEach(function (item) {
        var textContent = item.textContent.toLowerCase();
        var shouldDisplay = textContent.indexOf(value) > -1;
        item.style.display = shouldDisplay ? "" : "none";
    });
}
