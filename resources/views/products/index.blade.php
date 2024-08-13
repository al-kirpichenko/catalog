@extends('layouts.app')

@section('content')
    @if(session()->has('success'))
        {{ session()->get('success') }}
    @endif
    <h1>Товары</h1>
    <ul>
        @foreach ($products as $product)
            <li>
                <h2>{{ $product->name }}</h2>
                <p>Цена: {{ $product->price }}</p>
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1">
                    <button type="submit">Добавить в корзину</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
