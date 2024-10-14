<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks Report</title>
</head>

<body>
    <h1>Tasks Report</h1>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Task Title</th>
                <th>Assigned Employee</th>
                <th>Assigned At</th>
                <th>Resolved At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>
                    @if($task->assignedEmployee)
                    {{ $task->assignedEmployee->name }}
                    @else
                    Unassigned
                    @endif
                </td>
                <td>{{ $task->assigned_at}}</td>
                <td>
                    @if($task->resolve_status == 'Resolved')
                    Resolved
                    @else
                    Not Resolved
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>