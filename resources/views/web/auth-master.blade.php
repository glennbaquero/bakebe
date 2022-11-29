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
        
        <div class="frm-cntnr bg-background">
			<div class="frm-bckgrnds left--bg desktop-show" style="background-image: url('images/assets/leftcake.png')"></div>
			<div class="frm-bckgrnds right--bg desktop-show" style="background-image: url('images/assets/rightcake.png')"></div>
			<div class="w-30 mx-auto pb-8 lgn--holder">
        		@yield('content')    
			</div>
		</div>


        @include('guest.partials.footer')

        {{-- Dialogs --}}
        <dialog-container></dialog-container>

    </div>

    @include('partials.script-tags')

</body>
</html>