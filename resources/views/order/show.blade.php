@extends('default')
@section('content')
    <table class="table table-bordered table-hover">
        <tr>
            <th>用户</th>
            <td>{{ $res->users->username }}</td>
        </tr>
        <tr>
            <th>商家</th>
            <td>{{ $res->shops->shop_name }}</td>
        </tr>
        <tr>
            <th>订单编号</th>
            <td>{{ $res->sn }}</td>
        </tr>
        <tr>
            <th>省</th>
            <td>{{ $res->province }}</td>
        </tr>
        <tr>
            <th>市</th>
            <td>{{ $res->city }}</td>
        </tr>
        <tr>
            <th>县</th>
            <td>{{ $res->county }}</td>
        </tr>
        <tr>
            <th>详细地址</th>
            <td>{{ $res->address }}</td>
        </tr>
        <tr>
            <th>收货人电话</th>
            <td>{{ $res->tel }}</td>
        </tr>
        <tr>
            <th>收货人姓名</th>
            <td>{{ $res->name }}</td>
        </tr>
        <tr>
            <th>价格</th>
            <td>{{ $res->total }}</td>
        </tr>
        <tr>
            <th>状态</th>
            <td>@switch($res->status)
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
                @endswitch</td>
        </tr>
        <tr>
            <th>创建时间</th>
            <td>{{ (string)$res->created_at }}</td>
        </tr>
    </table>
@stop