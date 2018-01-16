
<style>
    img[src=""] {
        display: none;
    }
</style>
<div class="col-md-6">
    <div class="form-group">
        <label>Upload {{$editFlag}} Image</label>
        <img src="{{($editFlag)? url($item->thumbnail_location) : ''}}" class="img-thumbnail" width="75" height="100"
             style="float:right">
        {!! Form::file('thumbnail_location', ['class' => 'form-control']) !!}
    </div>
</div>
