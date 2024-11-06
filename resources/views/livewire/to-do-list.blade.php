<div>
    <h2>Your ToDos</h2>
    <ul>
        @foreach($todos as $todo)
            <li>{{ $todo->title }} - Due: {{ $todo->due_date }}</li>
        @endforeach
    </ul>
</div>
