
  @foreach ($errors->all() as $error)
  <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
    <div class="d-flex align-items-center">
        <div class="font-35 text-white"><i class='bx bxs-check-circle'></i>
        </div>
        <div class="ms-3">
            <h6 class="mb-0 text-white">Danger Alerts</h6>
            <div class="mb-0 text-white">{{ $error }}</div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
                @endforeach