<div class="row">
    @if ($paginator->hasPages())
        <div class="col-lg-12">
            <ul class="pagination pagination-rounded justify-content-center mt-2 mb-5">

                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <a href="javascript: void(0);" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                    </li>
                @else
                    <li class="page-item">
                        <button class="page-link" wire:click="previousPage('page')" wire:loading.attr="disabled"><i
                                class="mdi mdi-chevron-left"></i></button>
                    </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="page-item disabled">
                            <a href="javascript: void(0);" class="page-link">{{ $element }}</a>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <a href="javascript: void(0);" class="page-link">{{ $page }}</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <button wire:click="gotoPage({{ $page }}, 'page')"
                                        class="page-link">{{ $page }}</button>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <button type="button" dusk="nextPage" class="page-link" wire:click="nextPage('page')"
                            wire:loading.attr="disabled"><i class="mdi mdi-chevron-right"></i></button>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a href="#" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                    </li>
                @endif
            </ul>
        </div>
    @endif
</div>
