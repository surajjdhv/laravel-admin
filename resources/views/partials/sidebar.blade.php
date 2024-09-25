<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
	<div class="sidebar-brand d-none d-md-flex">
		<svg class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
			<use xlink:href="{{ asset('assets/brand/coreui.svg#full') }}"></use>
		</svg>
		<svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
			<use xlink:href="{{ asset('assets/brand/coreui.svg#signet') }}"></use>
		</svg>
	</div>
	<ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
		<li class="nav-item">
			<a class="nav-link" href="{{ route('home') }}">
				<i class="nav-icon cil-speedometer"></i>
				Dashboard
			</a>
		</li>
		@if($loggedInUser->isAdmin())
			<li class="nav-item">
				<a class="nav-link" href="{{ route('users.index') }}">
					<i class="nav-icon cil-group"></i>
					Users
				</a>
			</li>
		@endif
	</ul>
	<button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>