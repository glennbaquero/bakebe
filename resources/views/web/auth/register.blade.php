@extends('web.auth-master')

@section('meta:title', 'Register')

@section('content')
        <signup-view
            submit-url="{{ route('web.register') }}"
        	terms-condition-text="{{ $content }}"
        ></signup-view>
@endsection