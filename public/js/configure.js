var clickstep2dom = document.getElementById("clickstep2");
if (clickstep2dom) {
    var clickstep2 = new bootstrap.Toast(clickstep2dom);
    clickstep2.show();
}
// ========================================================================
// add new header input
const btnPlusMinus = document.getElementById("btnPlusMinus");
const inputContainer = document.getElementById("inputContainer");
var count = 1;
btnPlusMinus.addEventListener("click", function (e) {
    count++;
    var div = document.createElement("div");
    div.className = "input-group mb-2";
    div.innerHTML = `<input type="text" class="form-control headers" placeholder="Header ${count}"><button class="btn btn-warning minus-btn" type="button"><i class="bi bi-dash-lg"></i></button>`;
    btnPlusMinus.parentNode.parentNode.appendChild(div);
});

inputContainer.addEventListener("click", function (event) {
    var main = event.target;
    if (main.tagName == "I") {
        main = event.target.parentNode;
    }
    if (main.classList.contains("minus-btn")) {
        count--;
        main.parentNode.remove();
    }
});
// =====================================================================
const nameInput = document.getElementById("name");
const grade = document.getElementById("grade");
const header_img = document.getElementById("header_img");
const headers = document.getElementsByClassName("headers");
const time_allowed = document.getElementById("time_allowed");
const types = document.getElementsByClassName("types");
const total_mark = document.getElementById("total_mark");
function updatePaper(paperId) {
    var formData = getFormData();
    if (formData) {
        formData.append("id", paperId);
        fetch("/paper/edit", {
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
                    showToast("success", "white", data.message, 3000);
                }
            })
            .catch((error) => {
                showToast("danger", "white", error.message, 5000);
            });
    } else {
        showToast(
            "warning",
            "black",
            "⚠️ Please Fill in all form fields! ",
            3000
        );
    }
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
function getFormData() {
    var nameVal = nameInput.value;

    var headersArr = [];
    for (let i = 0; i < headers.length; i++) {
        headersArr.push(headers[i].value);
    }
    var headersVal = headersArr.join("|");

    if (header_img == "") {
        var headerImgVal = null;
    } else {
        var headerImgVal = header_img.value;
    }

    var gradeVal = grade.value;

    var timeAllowedVal = time_allowed.value;

    var totalMarkVal = total_mark.value;

    var infoArr = [];
    for (let i = 0; i < types.length; i++) {
        var count = types[i].children[1].children[0].value;
        var mark = types[i].children[2].children[0].value;
        var infoStr = types[i].id + "-" + count + "-" + mark;
        if (count && mark) {
            infoArr.push(infoStr);
        }
    }
    var infoVal = infoArr.join(",");

    if (
        nameVal == "" ||
        headersVal == "" ||
        gradeVal == "" ||
        timeAllowedVal == "" ||
        totalMarkVal == "" ||
        infoVal == ""
    ) {
        return null;
    } else {
        const formData = new FormData();
        formData.append("name", nameVal);
        formData.append("header", headersVal);
        formData.append("header_img", headerImgVal);
        formData.append("grade", gradeVal);
        formData.append("time_allowed", timeAllowedVal);
        formData.append("total_mark", totalMarkVal);
        formData.append("info", infoVal);
        return formData;
    }
}

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
