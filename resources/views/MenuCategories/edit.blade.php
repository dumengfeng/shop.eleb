@extends('.default')
@section('content')
    <div class="container">
        <form action="{{ route('MenuCategories.update',['shop'=>$edit]) }}" method="post" enctype="multipart/form-data"
              class="form-horizontal">
            <input type="hidden" name="is_selected" value="{{ $edit->is_selected }}">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">菜品分类名称:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control"
                           value="@if(old('name')){{ old('name') }}@else{{ $edit->name }}@endif" name="name"
                           id="inputEmail3" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">菜品分类描述:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $edit->description }}" name="description" id=""
                           placeholder="">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-default">添加</button>
                </div>
            </div>
    </form>




@endsection
