let deleteTaskButton = document.getElementById("deleteTaskButton");
let confirmDeleteButton = document.getElementById("confirm-delete-button");
let cancelDeleteButton = document.getElementById("cancel-delete-button");
let messageBox = document.getElementById("messageBox");
const hideMessageBox = () => {
    messageBox.classList.remove('fade-in');
    messageBox.style.display = 'none';
}
const deleteTaskRequest = () => {
    let xmlRequest = new XMLHttpRequest();
    let queryParams = new URLSearchParams(window.location.search)
    if (queryParams.get("task_id") === null) {
        sessionStorage.setItem("message", "Task not found");
        sessionStorage.setItem("message_icon", "error");
        window.location.href = `${window.location.pathname}?${queryParams.toString()}`;
    }
    xmlRequest.onload = () => {
        if (xmlRequest.status === 200) {
            let response = JSON.parse(xmlRequest.responseText);
            if (response.success) {
                window.location.href = `http://localhost/task-manager/tasks/taskList.php`;
            } else {
                window.location.reload();
            }
        }
    }
    let url = "http://localhost/task-manager/api/deleteTask.php";
    xmlRequest.open("post", url, true);
    xmlRequest.setRequestHeader("Content-Type", "application/json");
    xmlRequest.send(JSON.stringify({"task_id": queryParams.get("task_id")}));
}

deleteTaskButton.addEventListener("click", () => {
    messageBox.style.display = 'block';
    messageBox.classList.add('fade-in');
})

confirmDeleteButton.addEventListener('click', () => {
    hideMessageBox();
    deleteTaskRequest()
});

cancelDeleteButton.addEventListener('click', () => {
    hideMessageBox();
});