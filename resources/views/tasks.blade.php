<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>

<h1>Tasks</h1>

<div id="task-list">
    <!-- Tasks will be loaded here dynamically -->
</div>

<!-- Add Task Form -->
<h2>Add New Task</h2>
<form id="task-form">
    <input type="text" id="title" placeholder="Task Title" required>
    <input type="text" id="description" placeholder="Task Description" required>
    <input type="checkbox" id="is_complete"> Completed
    <button type="submit">Create Task</button>
</form>

<script>
// Function to get tasks
function getTasks() {
    axios.get('/api/task', {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('auth_token') // If using token-based authentication
        }
    })
    .then(response => {
        const tasks = response.data;
        let taskListHtml = '';
        tasks.forEach(task => {
            taskListHtml += `
                <div>
                    <h3>${task.title}</h3>
                    <p>${task.description}</p>
                    <p>Status: ${task.is_complete ? 'Completed' : 'Pending'}</p>
                </div>
            `;
        });
        document.getElementById('task-list').innerHTML = taskListHtml;
    })
    .catch(error => console.log(error));
}

// Function to create a new task
document.getElementById('task-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;
    const isComplete = document.getElementById('is_complete').checked;

    axios.post('/api/task', {
        title: title,
        description: description,
        is_complete: isComplete
    }, {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('auth_token') // Token if using API authentication
        }
    })
    .then(response => {
        console.log(response.data);
        getTasks();  // Refresh task list
    })
    .catch(error => console.log(error));
});

// Initial fetch of tasks when the page loads
getTasks();
</script>

</body>
</html>
