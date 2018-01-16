<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('name', 'Name: ') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('email', 'E-mail: ') !!}
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('address', 'Address: ') !!}
        {!! Form::text('address', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('telephone', 'Telephone: ') !!}
        {!! Form::text('telephone', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('rank_id', 'Rank: ') !!}
        {!! Form::select('rank_id', $ranks, null, ['class' => 'form-control'] ) !!}
    </div>
</div>