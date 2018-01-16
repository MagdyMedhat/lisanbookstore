<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('name', 'Name: ') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('birth_date', 'Date of Birth: ') !!}
        {{--{!! Form::input('date', 'published_date', Carbon\Carbon::now()->format('m-d-Y'), ['class' => 'form-control']) !!}--}}
        {!! Form::input('date', 'birth_date', date('Y-m-d'), ['class' => 'form-control'])!!}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('nationality', 'Nationality: ') !!}
        {!! Form::text('nationality', null, ['class' => 'form-control']) !!}
    </div>
</div>
</hr>
