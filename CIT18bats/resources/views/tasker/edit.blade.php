<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="container mx-auto p-5">
    <h2 class="text-2xl font-bold mb-4 text-center">Edit Task</h2>

    <form action="{{ route('tasker.update', $task->id) }}" method="POST" class="mb-6 bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT') 
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Title</label>
            <input type="text" name="title" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $task->title }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $task->description }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Completed</label>
            <select name="is_completed" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="0" {{ !$task->is_completed ? 'selected' : '' }}>Not Completed</option>
                <option value="1" {{ $task->is_completed ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg cursor-pointer">Update Task</button>
    </form>

    <a href="{{ route('tasker.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg cursor-pointer">Back to Task List</a>
</body>
</html>