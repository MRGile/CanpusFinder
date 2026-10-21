<aside class="filter-sidebar" id="filterSidebar" style="position:sticky;top:96px;" aria-label="Panel filter kampus">
    <form action="/kampus" method="GET" style="background:white;border:1px solid var(--gray-200);border-radius:16px;overflow:hidden;box-shadow:var(--shadow-sm);">
        @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
        @if(request('fakultas'))<input type="hidden" name="fakultas" value="{{ request('fakultas') }}">@endif
        <div style="background:var(--primary);padding:16px 20px;color:white;">
            <h3 style="font-size:0.92rem;font-weight:700;">Filter Kampus</h3>
        </div>
        <div style="padding:20px;">
            <label for="filter-city" style="display:block;font-size:0.8rem;font-weight:700;margin-bottom:8px;">Kota</label>
            <select id="filter-city" name="kota" class="search-select" style="width:100%;margin-bottom:18px;">
                <option value="">Semua Kota</option>
                @foreach($filterCities as $city)
                <option value="{{ $city }}" {{ request('kota') === $city ? 'selected' : '' }}>{{ $city }}</option>
                @endforeach
            </select>

            <label for="filter-type" style="display:block;font-size:0.8rem;font-weight:700;margin-bottom:8px;">Jenis Kampus</label>
            <select id="filter-type" name="jenis" class="search-select" style="width:100%;margin-bottom:18px;">
                <option value="">Semua Jenis</option>
                @foreach($filterTypes as $type)
                <option value="{{ strtolower($type) }}" {{ strtolower(request('jenis', '')) === strtolower($type) ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary" style="width:100%;">Terapkan Filter</button>
            <a href="/kampus" style="display:block;text-align:center;font-size:0.8rem;margin-top:12px;color:var(--gray-600);">Hapus Filter</a>
        </div>
    </form>
</aside>
