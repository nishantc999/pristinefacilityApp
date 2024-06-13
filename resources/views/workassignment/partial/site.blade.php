

<h6>Select Site:</h6>
<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center gap-3">
            @if(count($sites)>0)
            @foreach ($sites as $site)
        
                <div class="form-check form-check-success">
                    <input class="form-check-input" type="radio" name="site_id" value="{{ $site->id }}"><label
                        class="form-check-label">{{$site->name}}</label>
                </div>
            @endforeach

            @else

            No Site in this Shift
            @endif

        </div>
    </div>
</div>
