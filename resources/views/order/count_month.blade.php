@extends('default')
@section('content')
    <form class="navbar-form navbar-left" action="">
        <div class="form-group">
            <input type="month" class="form-control" placeholder="Search" name="keyword">
        </div>
        <button type="submit" class="btn btn-default">搜索</button>
        <button type="button" class="btn btn-primary"><a href="{{ route('order.count') }}" style="color: #0f0f0f">总计</a></button>
        <button type="button" class="btn btn-primary"><a href="{{ route('order.count_day') }}" style="color: #0f0f0f">按日期搜索</a></button>
    </form>
    <table class="table table-bordered table-hover">
        <tr>
            <th>日期</th>
            <th>订单数量</th>
        </tr>
            <tr>
                <td>{{ date('Y-m',strtotime($keyword)) }}</td>
                <td>{{ $count }}</td>
            </tr>
    </table>
    {{--{{ $all->appends(['keyword'=>$keyword])->links() }}--}}
@stop