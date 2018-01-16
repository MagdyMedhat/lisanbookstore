<div class="container">
    <h2>Edit {{$item->name}}</h2>
    <hr/>

    <div class="well">
        {!! Form::model($item, ['url' => url("{$resourceName}/{$item->id}"), 'files' => true, 'method' => 'put']) !!}

        @include('errors._errors')

        <div class="row">

            @include('resources_common._form', ['editFlag' => 'a different'])
            {{--<div class="col-md-6">--}}
            {{--<img src="{{$card->thumbnail_location}}" class="img-thumbnail" width="75" height="100">--}}
            {{--</div>--}}
            <div class="col-md-6">

                {!! Form::submit('Save', ['class' => 'btn btn-lg btn-primary']) !!}
                {!! Form::close() !!}


            </div>

        </div>
    </div>
</div>
