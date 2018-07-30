@extends('default')
@section('content')
    <form method="post" action="{{ route('MenuCategories.store') }}" class="form-horizontal" enctype="multipart/form-data">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">菜品名称:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="inputEmail3" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">菜品描述:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="description" id="" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-default">添加</button>
            </div>
        </div>
    </form>
@stop