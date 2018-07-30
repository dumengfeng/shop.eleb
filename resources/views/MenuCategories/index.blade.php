@extends('default')
@section('content')
    <a href="{{ route('MenuCategories.create') }}" class="btn btn-primary btn-sm" role="button">添加</a>
    <table class="table table-bordered table-hover">
        <tr>
            <th>id</th>
            <th>菜品名称</th>
            <th>所属商家</th>
            <th>描述</th>
            <th>是否默认分类</th>
            <th>操作</th>
        </tr>
        @foreach($all as $value)
            <tr>
                <td>{{ $value->id }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->shops->shop_name }}</td>
                <td>{{ $value->description }}</td>
                <td>@if( $value->is_selected ==1)
                        默认√
                    @else
                        非默认×
                    @endif
                </td>
                <td>
                    <form action="{{ route('MenuCategories.destroy',[$value]) }}" method="post">
                        <button type="button" class="btn btn-default btn-sm" aria-label="Left Align" title="编辑">
                            <a href="{{ route('MenuCategories.edit',[$value]) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true" style="color: #000">编辑</span>
                            </a>
                        </button>

                        <button type="button" class="btn btn-default btn-sm" aria-label="Left Align" title="查看">
                            <a href="{{ route('nu.index') }}"><span class="glyphicon glyphicon-edit" aria-hidden="true" style="color: #000">查看</span>
                            </a>
                        </button>

                        @if( $value->is_selected !=1)
                            <button type="button" class="btn btn-default btn-sm" aria-label="Left Align" title="选择默认">
                                <a href="{{ route('MenuCategories.mr',[$value]) }}"><span
                                            class="glyphicon glyphicon-edit" aria-hidden="true"
                                            style="color: #000">选择默认</span></a>
                            </button>
                        @endif

                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-default btn-sm" aria-label="Left Align" title="删除">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true" style="color: red">删除</span>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@stop