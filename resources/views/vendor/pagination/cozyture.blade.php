@if ($paginator->hasPages())
<nav class="flex items-center gap-1" aria-label="Pagination">

    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span class="px-3 py-2 text-sm text-sand/40 cursor-not-allowed">&larr;</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"
           class="px-3 py-2 text-sm text-charcoal/60 hover:text-walnut transition-colors">&larr;</a>
    @endif

    {{-- Pages --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="px-2 py-2 text-sm text-sand/50">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="w-9 h-9 flex items-center justify-center text-sm bg-walnut text-cream rounded-sm">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}"
                       class="w-9 h-9 flex items-center justify-center text-sm text-charcoal/60
                              hover:bg-cream hover:text-walnut rounded-sm transition-colors">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           class="px-3 py-2 text-sm text-charcoal/60 hover:text-walnut transition-colors">&rarr;</a>
    @else
        <span class="px-3 py-2 text-sm text-sand/40 cursor-not-allowed">&rarr;</span>
    @endif

</nav>
@endif