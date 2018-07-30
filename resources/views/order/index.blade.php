@extends('default')
@section('content')
    <table class="table table-bordered table-hover">
        <tr>
            <th>id</th>
            <th>订单编号</th>
            <th>会员姓名</th>
            <th>创建时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach($all as $value)
            <tr>
                <td>{{ $value->id }}</td>
                <td>{{ $value->sn }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ (string)$value->created_at }}</td>
                <td>@switch($value->status)
                    @case(-1)
                    已取消
                    @break

                    @case(0)
                    待支付
                    @break

                    @case(1)
                    待发货
                    @break

                    @case(2)
                    待确认
                    @break

                    @case(3)
                    完成
                    @break
                    @endswitch
                </td>
                <td>
                    <form action="{{ route('order.destroy',[$value]) }}" method="post">
                        <button type="button" class="btn btn-default btn-sm" aria-label="Left Align" title="编辑">
                            <a href="{{ route('order.show',[$value]) }}"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true" style="color: #000">查看</span>
                            </a>
                        </button>
                        <button type="button" class="btn btn-default btn-sm" aria-label="Left Align" title="发货">
                            <a href="{{ route('order.ship',[$value]) }}"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true" style="color: #000">发货</span>
                            </a>
                        </button>
                        <button type="button" class="btn btn-default btn-sm" aria-label="Left Align" title="编辑">
                            <a href="{{ route('order.cancel',[$value]) }}"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true" style="color: #000">取消</span>
                            </a>
                        </button>
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        {{--<button type="submit" class="btn btn-default btn-sm" aria-label="Left Align" title="删除">--}}
                            {{--<span class="glyphicon glyphicon-trash" aria-hidden="true" style="color: red">删除</span>--}}
                        {{--</button>--}}
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $all->links() }}
@stop