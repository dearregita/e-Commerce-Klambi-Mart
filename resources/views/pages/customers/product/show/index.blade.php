@extends('layouts.app')

@section('title', 'Produk | E-Commerce')

@section('content')
  <main class="pt-20">
    @include('components.customers.produk.show.detail', ['product' => $product])
  </main>
@endsection
