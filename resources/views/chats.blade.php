@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1 class="m-0 text-dark">{{__('chat.title')}}</h1>
@stop

@section('content')
<div class="container">

    <chats :user="{{ auth()->user() }}"></chats>





</div>
@endsection
