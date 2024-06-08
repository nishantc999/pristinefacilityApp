@if (\Session::get('role_id') == 1 || \Session::get('role_id') == 0)
    {{-- <div class="page-wrapper" style="height: initial">
    <div class="page-content"> --}}
    @php

        $global_cities = App\Models\City::where('status', 1)
            ->when(\Session::has('distributor'), function ($query) {
                $distributor_cities = App\Models\User::where('id', \Session::get('distributor'))->value(
                    'distributor_cities',
                );

                $query->whereIn('id', $distributor_cities);
            })
            ->get(['city_name', 'id']);

        $globalwarehouses = App\Models\Warehouse::when(Session::has('city'), function ($query) {
            $query->where('city', Session::get('city'));
        })
            ->when(!Session::has('city') && Session::get('role_id') == 1, function ($query) {
                $query->whereIn('city', Auth::user()->distributor_cities);
            })
            ->when(\Session::has('distributor') && Session::get('role_id') == 0, function ($query) {
                $query->where('user_id', \Session::get('distributor'));
            })
            ->get(['name', 'id']);

    @endphp
    <div class="card">
        <div class="card-body">
            <div class="row m-auto justify-content-center my-3">

                @if (\Session::get('role_id') == 0)
                    <div class="col-sm-12 col-md-4">


                        <form action="{{ route('set_global_distributor') }}" method="POST" id="searchform22">
                            @csrf

                            <select name="distributor" id="setdistributor" class="form-select" onchange="searchformsubmit22()"
                                data-placeholder="Choose Distributor">
                                <option></option>

                                <option value="-1" {{ !Session::has('distributor') ? 'selected' : '' }}>All</option>

                                @foreach (App\Models\User::where('status', 1)->where('role_id', 1)->get(['name', 'id']) as $distributor)
                                    <option value="{{ $distributor->id }}"
                                        {{ \Session::has('distributor') && \Session::get('distributor') == $distributor->id ? 'selected' : '' }}>
                                        {{ $distributor->name }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                @endif

                <div class="col-sm-12 col-md-4">

                    <form action="{{ route('set_global_city') }}" method="POST" id="searchform">
                        @csrf

                        <select name="city" id="setglobalcity" class="form-select" onchange="searchformsubmit()"
                            data-placeholder="Choose Any City">
                            <option></option>
                            <option value="-1" {{ !Session::has('city') ? 'selected' : '' }}>All</option>


                            @foreach ($global_cities as $city)
                                <option value="{{ $city->id }}"
                                    {{ \Session::has('city') && \Session::get('city') == $city->id ? 'selected' : '' }}>
                                    {{ $city->city_name }}</option>
                            @endforeach
                        </select>
                    </form>

                </div>
                <div class="col-sm-12 col-md-4">

                    <form action="{{ route('set_global_warehouse') }}" method="POST" id="searchform23">
                        @csrf

                        <select name="warehouse" id="setwarehouse" class="form-select" onchange="searchformsubmit23()"
                            data-placeholder="Choose Warehouse">
                            <option></option>
                            @if(Session::has('city'))
                            <option value="-1">All</option>

                            @foreach ($globalwarehouses as $warehouse)

                                <option value="{{ $warehouse->id }}"
                                    {{ \Session::has('warehouse') && \Session::get('warehouse') == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}</option>

                            @endforeach
                            @endif
                        </select>
                    </form>

                </div>
            </div>
        </div>

    </div>



    {{-- </div>
</div>  --}}

@endif
