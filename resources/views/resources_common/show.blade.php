<div class="container">
    <div class="row well">
        <div class="col-md-6">
            <label>Code</label>

            <p>{{$item->code}}</p>
        </div>
        <div class="col-md-6">
            <label>Title</label>

            <p>{{$item->name}}</p>
        </div>
        <div class="col-md-6">
            <label>Description</label>

            <p>{{$item->description}}</p>
        </div>
        <div class="col-md-6">
            <label>Artist</label>

            <p>{{$item->artist->name}}</p>
        </div>
        <div class="col-md-6">
            <label>Sales</label>

            <p>{{$item->sold_count}}</p>
        </div>
        <div class="col-md-6">
            <label>Quantity in Stock</label>

            <p>{{$item->stock_count}}</p>
        </div>
        <div class="col-md-6">
                <span>
                <label>Width</label>
                <p>{{$item->width}}</p>
                    </span>
                <span>
                <label>Height</label>
                <p>{{$item->height}}</p>
                </span>
        </div>
        <div class="col-md-6">
            <label>Thumbnail</label>
            </br>
            <img src="{{url($item->thumbnail_location)}}" class="img-thumbnail" width="75" height="100">
        </div>
        <div class="col-md-6">
            <label>Notes</label>

            <p>{{$item->notes}}</p>
        </div>
    </div>
</div>
<hr/>

<style>
    .col-md-6 {
        font-size: 20px;
    }
</style>