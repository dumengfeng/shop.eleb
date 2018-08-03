@extends('default')
@section('content')
        <button type="button" class="btn btn-primary"><a href="{{ route('order.count_day') }}" style="color: #0f0f0f">按日期搜索</a></button>
        <button type="button" class="btn btn-primary"><a href="{{ route('order.count_month') }}" style="color: #0f0f0f">按月份搜索</a></button>

    <table class="table table-bordered table-hover">
        <tr>
            <th>订单总数量</th>
        </tr>
            <tr>
                <td>{{ $count }}</td>
            </tr>
    </table>
    {{--{{ $all->appends(['keyword'=>$keyword])->links() }}--}}
@stop