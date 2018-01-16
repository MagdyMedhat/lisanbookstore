<div class="container">
    <h2>Add New {{$resourceName}}</h2>
    <hr/>

    <div class="well">
        {!! Form::open(['url' => url("{$resourceName}"), 'files' => true]) !!}

        @include('errors._errors')

        <div class="row">

            @include('resources_common._form', ['editFlag' => ''])
            <div class="col-md-6">

                {!! Form::submit('Add', ['class' => 'btn btn-lg btn-primary']) !!}
                {!! Form::close() !!}
                <div>

                </div>


            </div>

        </div>
    </div>
</div>
