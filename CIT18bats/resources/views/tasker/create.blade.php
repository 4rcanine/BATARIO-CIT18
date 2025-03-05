<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="container mx-auto p-5">
    <h2 class="text-2xl font-bold mb-4 text-center">Create New Task</h2>

    <!-- Task Creation Form -->
    <form action="{{ route('tasker.store') }}" method="POST" class="mb-6 bg-white shadow-md rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Title</label>
            <input type="text" name="title" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg cursor-pointer">Save Task</button>
    </form>

    <a href="{{ route('tasker.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg cursor-pointer">Back to Task List</a>
</body>
</html>