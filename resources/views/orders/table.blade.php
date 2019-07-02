<table class="table">
    <thead>
        <tr>
            <th>ID заказа</th>
            <th>Партнер</th>
            <th>Стоимость заказа</th>
            <th>Состав заказа</th>
            <th>Статус заказа</th>
        </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            <td><a href="{{ route('orders.edit', $order->id) }}" target="_blank">{{ $order->id }}</a></td>
            <td>{{ $order->partner->name }}</td>
            <td>{{ $order->getTotalPrice() }}</td>
            <td>
            @foreach($order->products as $product)
                <div>{{ $product->name }} ({{ $product->pivot->quantity }} шт)</div>
            @endforeach
            </td>
            <td>{{ \App\Enums\OrderStatus::getKey($order->status) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>