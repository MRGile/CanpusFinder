@if($paginator->hasPages())
<nav class="catalog-pagination" aria-label="Navigasi halaman">
    <a class="page-btn {{ $paginator->onFirstPage() ? 'disabled' : '' }}" @if($paginator->previousPageUrl()) href="{{ $paginator->previousPageUrl() }}" @else aria-disabled="true" @endif>‹ <span class="catalog-pagination-label">Sebelumnya</span></a>
    @php
        $startPage = max(1, $paginator->currentPage() - 2);
        $endPage = min($paginator->lastPage(), $paginator->currentPage() + 2);
    @endphp
    @if($startPage > 1)
        <a class="page-btn" href="{{ $paginator->url(1) }}">1</a>
        @if($startPage > 2)<span class="catalog-pagination-ellipsis" aria-hidden="true">…</span>@endif
    @endif
    @foreach(range($startPage, $endPage) as $page)
        <a class="page-btn {{ $page === $paginator->currentPage() ? 'active' : '' }}" href="{{ $paginator->url($page) }}" @if($page === $paginator->currentPage()) aria-current="page" @endif>{{ $page }}</a>
    @endforeach
    @if($endPage < $paginator->lastPage())
        @if($endPage < $paginator->lastPage() - 1)<span class="catalog-pagination-ellipsis" aria-hidden="true">…</span>@endif
        <a class="page-btn" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
    @endif
    <a class="page-btn {{ $paginator->hasMorePages() ? '' : 'disabled' }}" @if($paginator->nextPageUrl()) href="{{ $paginator->nextPageUrl() }}" @else aria-disabled="true" @endif><span class="catalog-pagination-label">Berikutnya</span> ›</a>
</nav>
<style>
.catalog-pagination{display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:8px;margin-top:32px}
.catalog-pagination .page-btn{width:auto;min-width:40px;padding:0 12px;text-decoration:none;gap:6px;white-space:nowrap}
.catalog-pagination .page-btn.disabled{pointer-events:none}
.catalog-pagination-ellipsis{color:var(--gray-500);padding:0 2px}
@media(max-width:520px){.catalog-pagination{gap:5px}.catalog-pagination .page-btn{min-width:36px;height:38px;padding:0 9px}.catalog-pagination-label{display:none}}
</style>
@endif
