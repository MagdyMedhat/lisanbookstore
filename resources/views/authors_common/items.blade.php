<div class="container">
    @include('shared._status')

    <h2>{{$resourceName}}s</h2>

    <div class="row">

        <div class="col-md-3">
            {!! Form::open(['method' => 'get']) !!}

            <div class="input-group">
                {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'search']) !!}
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
            <tr>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Nationality</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            @foreach($items as $item)

                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->birth_date->toDateString()}}</td>
                    <td>{{$item->nationality}}</td>

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
<script>
    function deleteConfirm() {
        return confirm('Do you want to delete this item?');
    }
</script>