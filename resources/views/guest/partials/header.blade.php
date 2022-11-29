<div class="hdr--holder position-fixed fixed-top w-100 desktop-show">
	<div class="vertical-parent">
		<div class="vertical-align">
			<div class="w-90 mx-auto">
				<div class="nav-bar navbar-expand">
					<div class="navbar-nav">
						<li class="nav-item w-20">
							<div class="vertical-parent">
								<div class="vertical-align">
									<a class="nav-link text-black font-weight-bold" href="https://www.bakebe.com/tl/homepage-ph/">HOME</a>		
								</div>
							</div>
							
						</li>
						<li class="nav-item w-20">
							<div class="vertical-parent">
								<div class="vertical-align">
									<a class="nav-link text-black font-weight-bold howto" href="/#howto">HOW TO BOOK</a>	
								</div>
							</div>
						</li>
						<li class="w-20 text-center">	
							<div class="hdr--logo mx-auto" style="background-image: url('{{ asset('images/assets/logo.png') }}');"></div>
						</li>
						<li class="nav-item w-20 text-right">
							<div class="vertical-parent">
								<div class="vertical-align">
									<a class="nav-link text-black font-weight-bold promos" href="/#promos">PROMOS AND DISCOUNTS</a>	
								</div>
							</div>
						</li>
						<li class="nav-item w-20 text-right">
							<div class="vertical-parent">
								<div class="vertical-align">
									@if(Auth::guard('web')->check())
									<div class="inlineBlock-parent"><i class="fas fa-user"></i> <a class="nav-link text-black font-weight-bold" href="{{ route('web.dashboard') }}">{{ auth()->guard('web')->user()->first_name }}</a></div>
										
									@else
									<div class="inlineBlock-parent">
										<i class="fas fa-user"></i> <a class="nav-link text-black font-weight-bold" href="{{ route('web.login') }}">LOGIN/SIGN UP</a>
									</div>
									@endif	
								</div>
							</div>
						</li>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>


<div class="mbl--hdr position-fixed fixed-top w-100 mobile-show">
	<div class="vertical-parent">
		<div class="vertical-align">
			<div class="mbl-hdr__inner w-90 mx-auto	inlineBlock-parent">
				<div class="w-50">
					<div class="mbl--logo" style="background-image: url('{{ asset('images/assets/logo.png') }}');"></div>
				</div
				><div class="w-50">
					<div class="mbl--HamMenu">
						<div class="mbl--hmenu"></div>
						<div class="mbl--hmenu"></div>
						<div class="mbl--hmenu"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="mbl-menu__holder py-3">
		<div class="w-90 mx-auto">
			<i class="far fa-times-circle text-primary mbl--close"></i>
			<div class="w-50 mb-5">
				<a href="/"><div class="mbl--logo" style="background-image: url('{{ asset('images/assets/logo.png') }}');"></div></a>
			</div>

			<div class="nav-bar w-100">
				<ul class="navbar-nav">
					<li class="nav-item w-100 mb-3">
						<div class="vertical-parent">
							<div class="vertical-align">
								<a class="nav-link text-primary font-weight-bold close--menu" href="https://www.bakebe.com/tl/homepage-ph/">HOME</a>		
							</div>
						</div>
						
					</li>
					<li class="nav-item w-100 mb-3">
						<div class="vertical-parent">
							<div class="vertical-align">
								<a class="nav-link text-primary font-weight-bold howto close--menu" href="/#howto">HOW TO BOOK</a>	
							</div>
						</div>
					</li>
					<li class="nav-item w-100 mb-3">
						<div class="vertical-parent">
							<div class="vertical-align">
								<a class="nav-link text-primary font-weight-bold promos close--menu" href="/#promos">PROMOS AND DISCOUNTS</a>	
							</div>
						</div>
					</li>
					<li class="nav-item w-100">
						<div class="vertical-parent">
							<div class="vertical-align">
								@if(Auth::guard('web')->check())
								<div class="inlineBlock-parent"><i class="fas fa-user text-primary"></i> <a class="nav-link text-primary font-weight-bold" href="login">{{ auth()->guard('web')->user()->first_name }}</a></div>
									
								@else
								<div class="inlineBlock-parent">
									<i class="fas fa-user text-primary"></i> <a class="nav-link text-primary font-weight-bold" href="login">LOGIN/SIGN UP</a>
								</div>
								@endif	
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>

		<div class="frm-bckgrnds right--bg bring-back" style="background-image: url('images/assets/rightcake.png')"></div>
	</div>	
</div>