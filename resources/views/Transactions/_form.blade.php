
{{--{{dd($transaction)}}--}}
<div id="controls">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('client_id', 'Client: ') !!}
            {!! Form::select('client_id', $clients, null, ['class' => 'form-control'] ) !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('category_id', 'Category: ') !!}
            {!! Form::select('category_id', $categories, null, ['class' => 'form-control'] ) !!}
        </div>
    </div>
</div>

{!! Form::hidden('resources', '', ['id' => 'resources']) !!}
{!! Form::hidden('id', '', ['id' => 'transactionId']) !!}


<style>
    #formSubmit{
        margin-top: 20px;
    }
</style>

