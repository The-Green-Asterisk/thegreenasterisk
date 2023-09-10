<div class="tab-row">
    @foreach ($tabs as $tab)
        <div class="tab-wrapper">
            <a href="{{ $tab->link }}">
                <div class="tab {{ $tab->active ? 'active' : '' }}" bg="{{ asset('storage/images/'.$tab->shortName.'_bg.jpg') }}">
                    <h3>{{ $tab->name }}</h3>
                </div>
            </a>
        </div>
    @endforeach
    @admin()
        <div class="tab-wrapper">
            <a href="#">
                <div class="tab" name="admin">
                    <h3>+</h3>
                </div>
            </a>
        </div>
    @endadmin
</div>