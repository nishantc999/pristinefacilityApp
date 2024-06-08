@extends('layouts.app')

@section('content')
<style>
    /* Custom CSS for checked and unchecked states */
    .btn-primary.active, .btn-primary:active {
        background-color: #007bff !important;
        border-color: #007bff !important;
    }
    .btn-secondary.active, .btn-secondary:active {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
    }
</style>
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Shift Management</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Shift</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-header px-4 py-3">
                        <h5 class="mb-0">Edit Shift</h5>
                    </div>
                    <div class="card-body p-4">
                        <form class="row g-3" method="POST" action="{{ route('shiftmanagement.update',$data->id) }}" enctype="multipart/form-data">

                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                       

                              <div class="col-md-6">
                                <label for="label" class="form-label">Shift name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{$data->name }}" placeholder="Shift Name" required>
                                @error('name')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                  </div>
                            @enderror
                            </div>
                              <div class="col-md-6">
                                <label for="label" class="form-label">Description</label>
                                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="description" value="{{$data->description }}" placeholder="Shift description" required>
                                @error('description')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                  </div>
                            @enderror
                            </div>
                           
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label">Start Time</label>
                                        <input type="text" class="form-control time-picker flatpickr-input active @error('start_time') is-invalid @enderror" name="start_time" value="{{$data->start_time }}" readonly="readonly">
                                    </div>
                                    @error('start_time')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                      </div>
                                @enderror
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label">End Time</label>
                                        <input type="text" class="form-control time-picker flatpickr-input active @error('end_time') is-invalid @enderror" name="end_time" value="{{$data->end_time }}"readonly="readonly">
                                    </div>
                                    @error('end_time')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                      </div>
                                @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="label" class="form-label">Shift Days</label>
                                <div class="btn-group-toggle d-md-flex justify-content-between" data-toggle="buttons">
                                <label class="btn btn-primary">
                                    <input type="checkbox" name="weekday[]" value="Monday" {{ in_array('Monday', $data->weekday?? []) ? 'checked' : '' }}> Monday
                                </label><br>
                                <label class="btn btn-primary">
                                    <input type="checkbox" name="weekday[]" value="Tuesday" {{ in_array('Tuesday', $data->weekday?? []) ? 'checked' : '' }}> Tuesday
                                </label><br>
                                <label class="btn btn-primary">
                                    <input type="checkbox" name="weekday[]" value="Wednesday" {{ in_array('Wednesday', $data->weekday?? []) ? 'checked' : '' }}> Wednesday
                                </label><br>
                                <label class="btn btn-primary">
                                    <input type="checkbox" name="weekday[]" value="Thursday" {{ in_array('Thursday', $data->weekday?? []) ? 'checked' : '' }}> Thursday
                                </label><br>
                                <label class="btn btn-primary">
                                    <input type="checkbox" name="weekday[]" value="Friday" {{ in_array('Friday', $data->weekday?? []) ? 'checked' : '' }}> Friday
                                </label><br>
                                <label class="btn btn-primary">
                                    <input type="checkbox" name="weekday[]" value="Saturday" {{ in_array('Saturday', $data->weekday?? []) ? 'checked' : '' }}> Saturday
                                </label><br>
                                <label class="btn btn-primary">
                                    <input type="checkbox" name="weekday[]" value="Sunday" {{ in_array('Sunday', $data->weekday?? []) ? 'checked' : '' }}> Sunday
                                </label><br>
                            </div>
                            @error('weekday')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                              </div>
                        @enderror
                                </div>
                            <div class="col-md-12">
                                <label class="form-label">Shift Type</label>
                                <div class="btn-group-toggle d-flex" data-toggle="buttons">
                              
                                    <label class="btn btn-primary">
                                        <input type="radio" name="shift_hr" value="12" {{ $data->shift_hr==12? 'checked' : '' }}> 12 Hr.
                                    </label><br>
                                    <label class="btn btn-primary">
                                        <input type="radio" name="shift_hr" value="8" {{ $data->shift_hr==8? 'checked' : '' }}> 8 Hr.
                                    </label><br>
                                </div>
                                @error('shift_hr')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                  </div>
                            @enderror
                            </div>
                            
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->





    </div>
</div>
@endsection
@push('script')
<script>
$(".time-picker").flatpickr({
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
});

    </script>



@endpush




