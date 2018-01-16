@if(count($books))
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Code</th>
            <th>Title</th>
            <th>Writer</th>
            <th>Artist</th>
        </tr>
        </thead>
        @foreach($books as $book)

            <tr>
                <td>{{$book->code}}</td>
                <td>{{$book->name}}</td>
                <td>{{$book->writer_name}}</td>
                <td>{{$book->artist_name}}</td>
            </tr>
        @endforeach
    </table>

@endif