@if($pages && $pages['total'] > $pages['inPage'])
    <nav>
        <ul class="pagination">
            @if ($pages['prev'])
                <li class="page-item">
                    <a class="page-link" href="{{ route($route, [
                        'channel' => $channel,
                        'page' => $pages['prev']
                    ]) }}" title="Previous page">&lsaquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">&lsaquo;</span>
                </li>
            @endif

            @if ($pages['next'])
                <li class="page-item">
                    <a class="page-link" href="{{ route($route, [
                        'channel' => $channel,
                        'page' => $pages['next']
                    ]) }}" title="Next page">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endisset
