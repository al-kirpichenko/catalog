@extends('layouts.app')

@section('content')
    <h1>Заказы</h1>
    <ul>
        @foreach ($orders as $order)
            <li>
                <h2>Заказ #{{ $order->id }}</h2>
                <p>Дата: {{ $order->created_at }}</p>
                <p>Товары: {{ $order->items->pluck('product.name')->implode(', ') }}</p>
                <p>Общая стоимость товаров: {{ $order->total_price }}</p>
                <form action="{{ route('orders.delete', $order->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Удалить заказ</button>
                </form>
            </li>
        @endforeach
    </ul>

    <h3>Итоговая стоимость всех заказов: {{ $totalPrice }}</h3>
@endsection
