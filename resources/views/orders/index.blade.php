@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#orders-expired" aria-controls="orders-expired" role="tab" data-toggle="tab">Просроченные</a></li>
                            <li role="presentation"><a href="#orders-current" aria-controls="orders-current" role="tab" data-toggle="tab">Текущие</a></li>
                            <li role="presentation"><a href="#orders-new" aria-controls="orders-new" role="tab" data-toggle="tab">Новые</a></li>
                            <li role="presentation"><a href="#orders-completed" aria-controls="orders-completed" role="tab" data-toggle="tab">Выполненные</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="orders-expired">@include('orders.table', ['orders' => $ordersExpired])</div>
                            <div role="tabpanel" class="tab-pane" id="orders-current">@include('orders.table', ['orders' => $ordersCurrent])</div>
                            <div role="tabpanel" class="tab-pane" id="orders-new">@include('orders.table', ['orders' => $ordersNew])</div>
                            <div role="tabpanel" class="tab-pane" id="orders-completed">@include('orders.table', ['orders' => $ordersCompleted])</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection