<div class="container">
    @include('shared._status')

    <h2>{{$resourceName}}s</h2>

    <div class="row">

        <div class="col-md-3">
            {!! Form::open(['method' => 'get']) !!}

            <div class="input-group">
                {{--{!! Form:label('search', '') !!}--}}
                {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'search', 'id' => 'search'])
                !!}
                <span class="input-group-btn">
                {!! Form::button('<span class="glyphicon glyphicon-search" aria-hidden="true"></span>',  ['type' => 'submit' ,'class' => 'btn btn-default']) !!}
                </span>
            </div>
        </div>
        <div class="col-md-7">
        </div>
        <div class="col-md-2">
            <div class="input-group">

                <a href='{{url("{$resourceName}/create")}}' class="btn btn-default">Add New <span
                            class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
            </div>
        </div>
        {!! Form::close() !!}


        <!--Row End --> </div>

    <hr/>

    @if(count($items))
        <table class="table table-striped table-hover">
            <thead>
            {!! Form::open(['url' => url("{$resourceName}/export")]) !!}
            {!! Form::text('viewName', 'resources_common.export_table', ['hidden' => 'true']) !!}
            {!! Form::text('fileName', "{$resourceName}s", ['hidden' => 'true']) !!}
            {!! Form::text('searchWord', '', ['hidden' => 'true', 'id' => 'searchWord']) !!}
            {!! Form::text('resourceName', $resourceName, ['hidden' => 'true']) !!}
            {!! Form::button('Export <span class="glyphicon glyphicon-print" aria-hidden="true"></span>', ['class' =>
            'btn btn-default', 'type' => 'submit']) !!}
            {!! Form::close() !!}
            {{--<a href="{{url("export", ["authors_common.items_table", "Cards"])}}"--}}
            {{--class="btn"></a>--}}
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Artist</th>
                <th>Thumbnail</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            @foreach($items as $item)

                <tr>
                    <td>{{$item->code}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->artist_name}}</td>
                    <td><img src="{{url($item->thumbnail_location)}}" class="img-thumbnail" width="75" height="100">
                    </td>
                    <td><a href="{{url("{$resourceName}/{$item->id}")}}" class="btn"><span
                                    class="glyphicon glyphicon-folder-open"></span></a></td>
                    <td><a href="{{url("{$resourceName}/{$item->id}/edit")}}" class="btn"><span
                                    class="glyphicon glyphicon-edit"></span></a></td>
                    {!! Form::open(['class' => 'delete', 'url' => "{$resourceName}/{$item->id}", 'method' => 'delete'])
                    !!}
                    <td>{!! Form::button('<span class="glyphicon glyphicon-remove"></span>', [
                        'style' => 'background-color: Transparent;
                        background-repeat:no-repeat;
                        border: none;
                        cursor:pointer;
                        overflow: hidden;
                        outline:none;
                        padding-top:10% ',
                        'type' => 'submit',
                        'onClick' => 'return deleteConfirm()']) !!}
                    </td>
                    {!! Form::close() !!}
                </tr>
            @endforeach

        </table>
        {!! $items->links() !!}

    @endif

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
//    $(document).ready(function () {
        function deleteConfirm() {
            return confirm('Do you want to delete this item?');
        }

        $('#search').on('change', function () {

            var value = $('#search').val();
            $('#searchWord').val(value);
        })
//    });
</script>