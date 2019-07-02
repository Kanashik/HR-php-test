@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="{{ route('orders.update', $order->id) }}" method="POST">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <div class="form-group @if($errors->has('client_email')) has-error @endif">
                                <label for="client-email">Email клиента</label>
                                <input id="client-email" type="email" class="form-control" name="client_email" value="{{ $order->client_email }}">
                            @if($errors->has('client_email'))
                                <span class="help-block">{{ $errors->first('client_email') }}</span>
                            @endif
                            </div>
                            <div class="form-group">
                                <label for="partner">Партнер</label>
                                <select id="partner" class="form-control" name="partner_id">
                                @foreach($partners as $partner)
                                    <option value="{{ $partner->id }}" @if($order->partner_id == $partner->id) selected @endif>{{ $partner->name }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Продукты</label>
                                <ul>
                                @foreach($order->products as $product)
                                    <li>{{ $product->name }} ({{ $product->pivot->quantity }} шт)</li>
                                @endforeach
                                </ul>
                            </div>
                            <div class="form-group">
                                <label for="order-status">Статус заказа</label>
                                <select id="order-status" class="form-control" name="status">
                                @foreach(\App\Enums\OrderStatus::getValues() as $status)
                                    <option value="{{ $status }}" @if($order->status == $status) selected @endif>{{ \App\Enums\OrderStatus::getKey($status) }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="total-price">Стоимость заказа</label>
                                <input id="total-price" type="text" class="form-control" value="{{ $order->getTotalPrice() }}" readonly>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default">Сохранить</button>
                            </div>
                        @if(session('status_message'))
                            <div class="form-group">
                                <div class="alert alert-success">{{ session('status_message') }}</div>
                            </div>
                        @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection