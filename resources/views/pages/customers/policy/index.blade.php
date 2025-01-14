@extends('layouts.app')

@section('title', 'Kebijakan Privasi | E-Commerce')

@section('content')
 @include('components.customers.policy.hero', ['title' => $title, 'description' => $description])
 @include('components.customers.policy.content', ['content' => $content])
@endsection
