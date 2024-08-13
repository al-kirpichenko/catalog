@extends('layouts.app')

@section('content')
    <h1>Корзина</h1>
    <ul>
        @foreach ($cart as $id => $details)
            <li>
                <h2>{{ $details['name'] }}</h2>
                <p>Количество: {{ $details['quantity'] }}</p>
                <p>Цена: {{ $details['price'] }}</p>
                <p>Всего: {{ $details['price'] * $details['quantity'] }}</p>
            </li>
        @endforeach
    </ul>

    <h3>Общая стоимость: {{ $total }}</h3>

    <form action="{{ route('order.place') }}" method="POST">
        @csrf
        <button type="submit">Оформить заказ</button>
    </form>
@endsection
