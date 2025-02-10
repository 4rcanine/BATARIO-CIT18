<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Task Manager</h2>

        <!-- Add Task Form -->
        <form id="addTaskForm">
            @csrf
            <div class="mb-3">
                <label for="taskTitle" class="form-label">Title</label>
                <input type="text" class="form-control" id="taskTitle" name="title" required>
            </div>
            <div class="mb-3">
                <label for="taskDescription" class="form-label">Description</label>
                <textarea class="form-control" id="taskDescription" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="taskStatus" class="form-label">Status</label>
                <select class="form-control" id="taskStatus" name="status">
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>

        <!-- Task List -->
        <h3 class="mt-5">Task List</h3>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="taskTableBody">
                <!-- Tasks will be loaded here via AJAX -->
            </tbody>
        </table>
    </div>

    <!-- jQuery AJAX Script -->
    <script>
        $(document).ready(function() {
            fetchTasks();

            // Fetch and display tasks
            function fetchTasks() {
                $.get("/tasks", function(data) {
                    let taskRows = "";
                    data.forEach(task => {
                        taskRows += `
                            <tr>
                                <td>${task.id}</td>
                                <td>${task.title}</td>
                                <td>${task.description || "N/A"}</td>
                                <td>${task.status}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-task" data-id="${task.id}">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-task" data-id="${task.id}">Delete</button>
                                </td>
                            </tr>`;
                    });
                    $("#taskTableBody").html(taskRows);
                }).fail(function(xhr) {
                    alert("Error loading tasks: " + xhr.responseText);
                });
            }

            // Add a new task
            $("#addTaskForm").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "/tasks",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(data) {
                        alert("Task added successfully!");
                        fetchTasks();
                        $("#addTaskForm")[0].reset();
                    },
                    error: function(xhr) {
                        alert("Error: " + xhr.responseText);
                    }
                });
            });

            // Delete a task
            $(document).on("click", ".delete-task", function() {
                let taskId = $(this).data("id");
                if (confirm("Are you sure you want to delete this task?")) {
                    $.ajax({
                        url: `/tasks/${taskId}`,
                        type: "DELETE",
                        data: {_token: "{{ csrf_token() }}"},
                        success: function() {
                            alert("Task deleted successfully!");
                            fetchTasks();
                        },
                        error: function(xhr) {
                            alert("Error deleting task: " + xhr.responseText);
                        }
                    });
                }
            });

            // Edit a task
            $(document).on("click", ".edit-task", function() {
                let taskId = $(this).data("id");
                let newTitle = prompt("Enter new task title:");
                let newStatus = prompt("Enter new status (pending/completed):");

                if (newTitle && newStatus) {
                    $.ajax({
                        url: `/tasks/${taskId}`,
                        type: "PUT",
                        data: {
                            _token: "{{ csrf_token() }}",
                            title: newTitle,
                            status: newStatus
                        },
                        success: function() {
                            alert("Task updated successfully!");
                            fetchTasks();
                        },
                        error: function(xhr) {
                            alert("Error updating task: " + xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
