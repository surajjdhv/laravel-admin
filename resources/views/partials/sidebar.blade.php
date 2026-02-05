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
			<li class="nav-group" aria-expanded="true">
				<a class="nav-link nav-group-toggle" href="#">
					<i class="nav-icon cil-people"></i>
					User Management
				</a>
				<ul class="nav-group-items">
					@can('users.view')
						<li class="nav-item">
							<a class="nav-link" href="{{ route('users.index') }}">
								<span class="nav-icon"></span>
								Users
							</a>
						</li>
					@endcan
					@can('roles.view')
						<li class="nav-item">
							<a class="nav-link" href="{{ route('roles.index') }}">
								<span class="nav-icon"></span>
								Roles
							</a>
						</li>
					@endcan
					@can('permissions.view')
						<li class="nav-item">
							<a class="nav-link" href="{{ route('permissions.index') }}">
								<span class="nav-icon"></span>
								Permissions
							</a>
						</li>
					@endcan
				</ul>
			</li>
		@endcanany
		@can('activity-logs.view')
			<li class="nav-item">
				<a class="nav-link" href="{{ route('activity-logs.index') }}">
					<i class="nav-icon cil-list"></i>
					Activity Logs
				</a>
			</li>
		@endcan
		@can('log-viewer.view')
			<li class="nav-item">
				<a class="nav-link" href="{{ url(config('log-viewer.route_path', 'log-viewer')) }}">
					<i class="nav-icon cil-file"></i>
					Log Viewer
				</a>
			</li>
		@endcan
	</ul>
	<button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
