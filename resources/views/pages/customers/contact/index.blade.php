@extends('layouts.app')

@section('title', 'Kontak Kami | E-Commerce')

@section('content')
  @include('components.customers.contact.form', ['title' => $title, 'description' => $description, 'contact' => $contact])
@endsection
