function getTime() {
    const timeZone = "Asia/Yangon";
    const options = {
        timeZone: timeZone,
        hour12: false,
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        year: "numeric",
        month: "long",
        day: "2-digit",
    };

    const currentDateTime = new Date().toLocaleTimeString("en-US", options);
    const currentDate = currentDateTime.split("at")[0];
    const currentTime = currentDateTime.split("at")[1];
    const rawhour = currentTime.split(":")[0];
    const formattedHour = rawhour > 12 ? rawhour - 12 : rawhour;
    const formattedMin = currentTime.split(":")[1];
    const formattedSec = currentTime.split(":")[2];
    const ampm = formattedHour > 12 ? "AM" : "PM";

    const timeString = `${currentDate} at ${formattedHour}:${formattedMin}:${formattedSec} ${ampm}`;
    document.getElementById("clocktxt").textContent = timeString;
}

const timeText = document.getElementById("clocktxt");
if (timeText) {
    // Update the clock every second
    setInterval(getTime, 1000);
    // Initial call to set the clock immediately
    getTime();
}
// ===============================================================================================
// Detail Model for Type List & Quiz List Page
const detailBody = document.getElementById("detailBody");
const detailTitle = document.getElementById("detailTitle");
function showTypeDetail(button) {
    const clickedTR = button.parentNode.parentNode;
    const detailData = JSON.parse(
        clickedTR.firstElementChild.textContent.trim()
    );
    detailTitle.textContent = detailData.name;
    detailBody.innerHTML = `
            <p><span class="text-muted">Name : </span> <strong>${detailData.name}</strong></p>
            <p><span class="text-muted">Mark : </span> <strong>${detailData.mark}</strong></p>
            <p><span class="text-muted">Modified at : </span> <strong>${detailData.updated}</strong></p>
            <p><span class="text-muted"><u>Header</u> </span> <strong>${detailData.header}</strong></p>
            `;
    const detailModal = new bootstrap.Modal(
        document.getElementById("detail-modal")
    );
    detailModal.show();
}
function showQuizDetail(button) {
    const clickedTR = button.parentNode.parentNode;
    const detailData = JSON.parse(
        clickedTR.firstElementChild.textContent.trim()
    );
    detailTitle.textContent = "Question Detail Information";
    if (detailData.type_id == 3) {
        var mcq = JSON.parse(detailData.body);
        detailBody.innerHTML = `
            <p><span class="text-muted">Question : </span> <strong>${mcq.body} 
            <p>A. ${mcq.A}</p><p>B. ${mcq.B}</p><p>C. ${mcq.C}</p><p>D. ${mcq.D}</p></strong></p>
            <p><span class="text-muted">Type : </span> <strong>${detailData.type_name}</strong></p>
            <p><span class="text-muted">Grade : </span> <strong>${detailData.grade}</strong></p>
            <p><span class="text-muted">Chapter : </span> <strong>${detailData.chapter}</strong></p>
            <p><span class="text-muted">Modified at : </span> <strong>${detailData.updated}</strong></p>
            `;
    } else {
        detailBody.innerHTML = `
            <p><span class="text-muted">Question : </span> <strong>${detailData.body}</strong></p>
            <p><span class="text-muted">Type : </span> <strong>${detailData.type_name}</strong></p>
            <p><span class="text-muted">Grade : </span> <strong>${detailData.grade}</strong></p>
            <p><span class="text-muted">Chapter : </span> <strong>${detailData.chapter}</strong></p>
            <p><span class="text-muted">Modified at : </span> <strong>${detailData.updated}</strong></p>
            `;
    }
    if (detailData.image) {
        detailBody.innerHTML += `<center><img src="uploads/${detailData.image}" width="400px" height="auto"></center>`;
    }
    const detailModal = new bootstrap.Modal(
        document.getElementById("detail-modal")
    );
    detailModal.show();
}

// ==========================================================================================
// Selection Control and Recording ID in backend
const countTxt = document.getElementById("countTxt");
const actionIds = document.getElementById("actionIds");
let count = 0;
let actionIdsArr = [];
function configureSelection(selectedTR, selectedRowIndexArr, e) {
    if (!e.target.classList.contains("exclude-select")) {
        // console.log(selectedTR);
        const detailData = JSON.parse(
            selectedTR.firstElementChild.textContent.trim()
        );
        if (selectedTR.firstElementChild.classList.contains("bg-secondary")) {
            // if remove select
            count--;
            actionIdsArr = actionIdsArr.filter(
                (item) => item !== detailData.id
            );
        } else {
            // if select
            count++;
            actionIdsArr.push(detailData.id);
        }
        actionIds.value = actionIdsArr; // getting selected row id

        // highlight selected row, button disability and showing count
        selectedRowIndexArr.push(selectedTR.dataset.index);
        highlightSelectedRow(selectedRowIndexArr);

        if (count > 0) {
            countTxt.parentNode.classList.remove("d-none");
            document.getElementById("btnDelete").removeAttribute("disabled");
            document.getElementById("btnEdit").removeAttribute("disabled");
            if (count >= 2) {
                document
                    .getElementById("btnEdit")
                    .setAttribute("disabled", "true");
            }
        } else {
            countTxt.parentNode.classList.add("d-none");
            document
                .getElementById("btnDelete")
                .setAttribute("disabled", "true");
            document.getElementById("btnEdit").setAttribute("disabled", "true");
        }
        countTxt.textContent = count;
    }
}
// refresh the highlights of selected rows
function highlightSelectedRow(selectedRowIndexArr) {
    const datatable = document.querySelector(".datatable");
    for (const row of datatable.children[1].children) {
        // clean its own classes
        for (const e of row.children) {
            e.classList.remove("bg-secondary");
            e.classList.remove("text-white");
        }
        // toggle highlight for selected rows
        selectedRowIndexArr.forEach((element) => {
            if (row.dataset.index == element) {
                for (const e of row.children) {
                    e.classList.toggle("bg-secondary");
                    e.classList.toggle("text-white");
                }
            }
        });
    }
}
// ==============================================================================================
// submit delete form
function submitDeleteForm() {
    document.getElementById("deleteForm").submit();
}
// ================================================================================================
// take value from id hidden box and direct to edit form
function editForm() {
    const textVal = document.getElementById("actionIds").value;
    location.href = `/quiztype/${textVal}/edit`;
}
// take value from id hidden box and direct to edit quiz form
function editQuizForm() {
    const textVal = document.getElementById("actionIds").value;
    location.href = `/quiz/${textVal}/edit`;
}

// =====================================================================================================
// separator for multiple entry
const separatorInput = document.getElementById("separator");
const importInput = document.getElementsByClassName("editor");
const separatorPreview = document.getElementById("separatorPreview");
const chkMcq = document.getElementById("chkMcq");
if (separatorInput && importInput) {
    separatorInput.addEventListener("input", function (event) {
        spliting();
    });
    window.editor.model.document.on("change:data", () => {
        spliting();
    });
}
function spliting() {
    const separator = separatorInput.value;
    let data = window.editor.getData();
    data = data.replace(/<p>/g, "").replace(/<\/p>/g, ""); // remove starting and ending <p> from text
    data = data.replace(/\n/g, ""); // remove \n from text
    data = data.replace(/<br>/g, ""); // remove <br> from text
    if (data && separator) {
        var dataArr = [];
        if (chkMcq.checked) {
            dataArr = data.split(separator);
        } else {
            dataArr = data.match(
                new RegExp(`[^${separator}]+[${separator}]?`, "g")
            );
        }

        // remove latest empty element
        if (dataArr[dataArr.length - 1].trim() == "") {
            dataArr.pop();
        }

        if (chkMcq.checked) {
            const formattedDataArr = dataArr.map((part) => parseMcq(part));
            separatorPreview.innerHTML = `<div class="text-center"><p class="fw-bold badge bg-success" style="font-size:15px;">Detected Questions - ${formattedDataArr.length}</p></div>`;
            formattedDataArr.forEach((data) => {
                const parsedData = JSON.parse(data);
                separatorPreview.innerHTML += `
                    <input type="hidden" name="dynamic_input[]" class="form-control" readonly value='${data}'>
                    ${parsedData.body}
                    <span class="badge bg-dark">A. ${parsedData.A}</span>
                    <span class="badge bg-dark">B. ${parsedData.B}</span>
                    <span class="badge bg-dark">C. ${parsedData.C}</span>
                    <span class="badge bg-dark">D. ${parsedData.D}</span>
                    <hr>
                    `;
            });
        } else {
            const formattedDataArr = dataArr.map((part) => `<p>${part}</p>`);
            separatorPreview.innerHTML = `<div class="text-center"><p class="fw-bold badge bg-success" style="font-size:15px;">Detected Questions - ${formattedDataArr.length}</p></div>`;
            formattedDataArr.forEach((data) => {
                separatorPreview.innerHTML += `
                    <input type="hidden" name="dynamic_input[]" class="form-control" readonly value="${data}">
                    ${data}<hr>
                    `;
            });
        }
    } else {
        separatorPreview.innerHTML = "";
    }
}

function parseMcq(originalString) {
    originalString = originalString.replace(/<p>/g, "").replace(/<\/p>/g, "");
    var parts = originalString.split("A. ");

    var question = parts[0].replace(/&nbsp;/g, "").trim();
    var optionsStr = parts[1]; // put A. in front of options string
    optionsStr = optionsStr.replace(/&nbsp;/g, ""); // remove all &nbsp;

    var arr = { body: "<p>" + question + "</p>" };

    var frontB = optionsStr.split("B.")[0];
    var rest = optionsStr.split("B.")[1];
    arr["A"] = frontB.trim();
    var frontC = rest.split("C.")[0];
    rest = rest.split("C.")[1];
    arr["B"] = frontC.trim();
    var frontD = rest.split("D.")[0];
    arr["C"] = frontD.trim();
    arr["D"] = rest.split("D.")[1].trim();

    return JSON.stringify(arr);
}
// =========================================================================
function directToPaperDelete(paperid){
    window.location=`/paper/${paperid}/delete`;
}

function searchPaper(event) {
    var value = event.target.value.toLowerCase();
    var paperCard = document.querySelectorAll(".paper-card");

    paperCard.forEach(function (item) {
        var textContent = item.textContent.toLowerCase();
        var shouldDisplay = textContent.indexOf(value) > -1;
        item.style.display = shouldDisplay ? "" : "none";
    });
}
