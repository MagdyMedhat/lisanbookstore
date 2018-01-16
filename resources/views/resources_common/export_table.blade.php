@if(count($items))
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Artist</th>
            <th>Thumbnail</th>
        </tr>
        </thead>
        @foreach($items->get() as $item)

            <tr>
                <td>{{$item->code}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->artist_name}}</td>
                <td><img src="{{$item->thumbnail_location}}" class="img-thumbnail" width="75" height="100">
                </td>

            </tr>
        @endforeach

    </table>

@endif
