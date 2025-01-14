@extends('layouts.app')

@section('title', 'Tentang Kami | E-Commerce')

@section('content')
  @include('components.customers.about.hero', ['title' => $title, 'description' => $description])
  @include('components.customers.about.content', ['image' => $image, 'content' => $content])
@endsection
