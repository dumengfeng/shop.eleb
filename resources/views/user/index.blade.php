@extends('default')
@section('content')
    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm" role="button">注册</a>
    <table class="table table-bordered table-hover">
        <tr>
            <th>id</th>
            <th>账号名称</th>
            <th>邮箱</th>
            <th>店铺照片</th>
            <th>状态</th>
            <th>所属商家</th>
            <th>操作</th>
        </tr>
        @foreach($all as $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->email }}</td>
            <td><img src="{{ $value->shops->shop_img }}" alt=""></td>
            <td>
                @if( $value->status ==1)
                    启用
                @else
                    禁用
                @endif
            </td>
            <td>{{ $value->shops->shop_name }}</td>
            <td><form action="{{ route('user.destroy',[$value]) }}" method="post">
                    <button type="button" class="btn btn-default btn-sm" aria-label="Left Align" title="编辑">
                        <a href="{{ route('user.edit',[$value]) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true" style="color: #000">编辑</span></a>
                    </button>
                    <button type="button" class="btn btn-default btn-sm" aria-label="Left Align" title="修改密码">
                        <a href="{{ route('user.pwd',[$value]) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true" style="color: #000">修改密码</span></a>
                    </button>
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