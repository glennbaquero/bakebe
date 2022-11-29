@extends('web.auth-master')

@section('meta:title', 'Login')

@section('content')
<login-view
    submit-url="{{ route('web.login') }}"

></login-view>


@endsection