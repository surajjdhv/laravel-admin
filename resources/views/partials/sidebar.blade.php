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
	@canany(['users.view', 'roles.view', 'permissions.view'])
		<li class="nav-item nav-group" id="nav-group-user-management" data-nav-group="user-management">
			<a class="nav-link nav-group-toggle" href="#">
				<i class="nav-icon cil-group"></i> User Management
			</a>
			<ul class="nav-group-items">
				@can('users.view')
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
						Users
					</a>
				</li>
				@endcan
				@can('roles.view')
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
						Roles
					</a>
				</li>
				@endcan
				@can('permissions.view')
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}" href="{{ route('permissions.index') }}">
						Permissions
					</a>
				</li>
				@endcan
			</ul>
		</li>
	@endcanany
	</ul>
	<button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
	const navGroups = document.querySelectorAll('[data-nav-group]');
	
	navGroups.forEach(function(navGroup) {
		const groupKey = 'nav-group-' + navGroup.dataset.navGroup;
		const savedState = localStorage.getItem(groupKey);
		
		// Restore saved state or default to open
		if (savedState === 'open' || savedState === null) {
			navGroup.classList.add('show');
		}
		
		// Use MutationObserver to detect when CoreUI toggles the class
		const observer = new MutationObserver(function(mutations) {
			mutations.forEach(function(mutation) {
				if (mutation.attributeName === 'class') {
					const isOpen = navGroup.classList.contains('show');
					localStorage.setItem(groupKey, isOpen ? 'open' : 'closed');
				}
			});
		});
		
		observer.observe(navGroup, { attributes: true });
	});
});
</script>
@endpush