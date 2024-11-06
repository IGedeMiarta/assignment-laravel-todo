<div class="card mt-5">
    <div class="card-body">
        <div class="card-title">
            <h4>All Todo List</h4>
        </div>
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">User</th>
                    <th scope="col">Desctiption</th>
                    <th scope="col">Due</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($todos as $i => $item)
                <tr>
                    <th scope="row">{{ $i+1 }}</th>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->formatted_date }}</td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>