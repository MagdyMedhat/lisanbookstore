{{--<div class="col-md-6">--}}
{{--<div class="form-group">--}}
{{--{!! Form::label('code', 'Code: ') !!}--}}
{{--{!! Form::text('code', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}
{{--</div>--}}
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('name', 'Title: ') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('description', 'Description: ') !!}
        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows'=>'3']) !!}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('width', 'Width: ') !!}
        {!! Form::text('width', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('height', 'Height: ') !!}
        {!! Form::text('height', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('artist_id', 'Artist: ') !!}
        {!! Form::select('artist_id', $artists, null, ['class' => 'form-control'] ) !!}
    </div>
</div>

@include('resources_common._upload_form')
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('sold_count', 'Sales: ') !!}
        {!! Form::text('sold_count', 0, ['class' => 'form-control'] ) !!}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('stock_count', 'Quantity in Stock: ') !!}
        {!! Form::text('stock_count', 0, ['class' => 'form-control'] ) !!}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('notes', 'Notes: ') !!}
        {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => '3'] ) !!}
    </div>
</div>
<hr/>