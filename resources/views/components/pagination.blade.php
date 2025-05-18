@if ($paginator->hasPages())
    <nav role="navigation" class="flex justify-center mt-8">
        <ul class="inline-flex items-center space-x-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="btn btn-disabled btn-sm">Anterior</li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-primary btn-sm">
                        {{__('Anterior')}}
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="btn btn-sm btn-disabled">{{ $element }}</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="btn btn-sm btn-primary-active">{{ $page }}</li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="btn btn-ghost btn-sm text-primary hover:bg-primary/20">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-primary btn-sm">
                        Siguiente
                    </a>
                </li>
            @else
                <li class="btn btn-disabled btn-sm">{{__('Siguiente')}}</li>
            @endif
        </ul>
    </nav>
@endif
