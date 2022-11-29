<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() }}">
<head>

    @include('partials.meta-tags')
    @include('guest.partials.meta-tags')

    @yield('css')

    @include('guest.partials.styles')

</head>
<body>

    <div id="app">

        @include('guest.partials.header')
            <div class="main">
                @yield('content')    
            </div>
        
        @include('guest.partials.footer')

        {{-- Dialogs --}}
        <dialog-container></dialog-container>

    </div>

    @include('partials.script-tags')
    {{-- @include('PRXPayPal::includes.js') --}}
    

</body>
</html>