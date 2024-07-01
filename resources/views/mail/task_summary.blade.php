<!DOCTYPE html>
<html>
<head>
    <title>Task Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .task-list {
            margin: 20px;
            padding: 0;
            list-style: none;
        }
        .task-item {
            background: #f9f9f9;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .task-title {
            font-size: 18px;
            font-weight: bold;
        }
        .task-description {
            margin-top: 5px;
        }
        .task-status {
            margin-top: 5px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
<h1>Task Summary</h1>
<ul class="task-list">
    @foreach ($tasks as $task)
        <li class="task-item">
            <div class="task-title">{{ $task->title }}</div>
            <div class="task-description">{{ $task->description }}</div>
            <div class="task-status">Status: {{ $task->status->name }}</div>
        </li>
    @endforeach
</ul>
</body>
</html>
