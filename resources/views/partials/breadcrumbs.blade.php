@if (\Tabuna\Breadcrumbs\Breadcrumbs::has())
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            @foreach (\Tabuna\Breadcrumbs\Breadcrumbs::current() as $crumb)
                @if ($crumb->url() && ! $loop->last)
                    <li class="breadcrumb-item">
                        <a href="{{ $crumb->url() }}">{{ $crumb->title() }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">
                        <span>{{ $crumb->title() }}</span>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
@endif
