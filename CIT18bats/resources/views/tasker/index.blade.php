<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="container mx-auto p-5">
    <h2 class="text-2xl font-bold mb-4 text-center">Task List</h2>

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
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg cursor-pointer">Add Task</button>
    </form>

    <ul class="space-y-4">
        @foreach ($tasks as $task)
            <li class="bg-white shadow-md rounded-lg p-4 border border-gray-200">
                <strong class="text-lg font-semibold">{{ $task->title }}</strong>
                <p class="text-gray-600">{{ $task->description }}</p>
                
                <div class="mt-2 flex space-x-2">
                    <a href="{{ route('tasker.edit', $task->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded-lg cursor-pointer">Edit</a>
                    
                    <form action="{{ route('tasker.destroy', $task->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded-lg cursor-pointer">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</body>
</html>