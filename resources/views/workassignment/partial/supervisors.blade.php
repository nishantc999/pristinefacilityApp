
<h6>Select supervisor:</h6>
<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center gap-3" >
        @if(count($supervisors)>0)
            @foreach ($supervisors as $area)
        
                <div class="form-check form-check-success">
                    <input class="form-check-input supervisorOption" type="radio" name="supervisor_id" value="{{ $area->id }}"><label
                        class="form-check-label">{{$area->name}}</label>
                </div>
            @endforeach
            @else

            No supervisior in this site
            @endif


        </div>
    </div>
</div>
