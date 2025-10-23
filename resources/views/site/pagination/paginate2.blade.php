
@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end">


            @if (!$paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                    <span aria-hidden="true">
                        <i class="arrow_carrot-left"></i>
                    </span>
                        <span class="sr-only">
                        Trang trước
                    </span>
                    </a>
                </li>
            @endif

                @foreach ($elements as $element)
                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <a class="page-link" href="#">
                                        {{ $page }}
                                        <span class="sr-only">
                                             (Hiện tại)
                                        </span>
                                    </a>
                                </li>
                            @else

                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">
                                        {{ $page }}
                                    </a>
                                </li>

                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                    <span aria-hidden="true">
                        <i class="arrow_carrot-right"></i>
                    </span>
                            <span class="sr-only">
                        Trang sau
                    </span>
                        </a>
                    </li>
                @endif

        </ul>
    </nav>

@endif

