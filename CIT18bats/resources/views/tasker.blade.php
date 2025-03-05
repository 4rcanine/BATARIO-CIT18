<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Task Manager</h2>

        
        <form id="addTaskForm" class="space-y-4">
            @csrf
            <div>
                <label for="taskTitle" class="block font-medium">Title</label>
                <input type="text" id="taskTitle" name="title" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="taskDescription" class="block font-medium">Description</label>
                <textarea id="taskDescription" name="description" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div>
                <label for="taskStatus" class="block font-medium">Status</label>
                <select id="taskStatus" name="status" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add Task</button>
        </form>

       
        <h3 class="text-xl font-bold mt-6">Task List</h3>
        <div class="overflow-x-auto mt-4">
            <table class="w-full bg-white border border-gray-200 rounded-md shadow-md">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Title</th>
                        <th class="p-2 border">Description</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="taskTableBody" class="text-center">
                    
                </tbody>
            </table>
        </div>
    </div>

   
    <script>
        $(document).ready(function() {
            fetchTasks();

            function fetchTasks() {
                $.get("/tasks", function(data) {
                    let taskRows = "";
                    data.forEach(task => {
                        taskRows += `
                            <tr class="border-b">
                                <td class="p-2">${task.id}</td>
                                <td class="p-2">${task.title}</td>
                                <td class="p-2">${task.description || "N/A"}</td>
                                <td class="p-2">${task.status}</td>
                                <td class="p-2">
                                    <button class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-600 edit-task" data-id="${task.id}">Edit</button>
                                    <button class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600 delete-task" data-id="${task.id}">Delete</button>
                                </td>
                            </tr>`;
                    });
                    $("#taskTableBody").html(taskRows);
                }).fail(function(xhr) {
                    alert("Error loading tasks: " + xhr.responseText);
                });
            }

            $("#addTaskForm").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "/tasks",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function() {
                        alert("Task added successfully!");
                        fetchTasks();
                        $("#addTaskForm")[0].reset();
                    },
                    error: function(xhr) {
                        alert("Error: " + xhr.responseText);
                    }
                });
            });

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
