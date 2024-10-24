<style>
    .page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #000;
    border-color: #000;
}
.page-item .page-link {
    border-color: #000;
    color: #000;
}
.page-item .page-link:hover {
    background-color: #000;
} 
.page-item:last-child .page-link {

 }

</style>
<ul class="pagination">
    {{-- Previous Page Link --}}
    <li class="page-item">
        <a class="page-link page-prev" href="{{ $paginator->previousPageUrl() }}" @if (!$paginator->hasMorePages()) aria-disabled="true" @endif>
        </a>
    </li>

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <li class="page-item disabled"><a class="page-link">{{ $element }}</a></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    <li class="page-item">
        <a class="page-link text-black page-next" href="{{ $paginator->nextPageUrl() }}" @if (!$paginator->hasMorePages()) aria-disabled="true" @endif>
        </a>
    </li>
</ul>
