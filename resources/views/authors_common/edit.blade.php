<div class="container">
    <h2>Edit {{$item->name}}</h2>
    <hr/>

    <div class="well">
        {!! Form::model($item, ['url' => url("{$resourceName}/{$item->id}"), 'method' => 'put']) !!}

        @include('errors._errors')

        <div class="row">

            @include('authors_common._form')

            <div class="col-md-6">

                {!! Form::submit('Save', ['class' => 'btn btn-lg btn-primary']) !!}
                {!! Form::close() !!}


            </div>

        </div>
    </div>
</div>
