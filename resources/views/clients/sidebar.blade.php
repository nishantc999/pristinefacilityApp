<div class="card">
    <div class="card-body">
        <div class="fm-menu">


            <div class="list-group list-group-flush">
                <a href="{{ route('dashboard', $id) }}" class="list-group-item py-1">
                    <i class='bx bx-folder me-2'></i><span>Dashboard</span>
                </a>
                <a href="{{ route('business-details', $id) }}" class="list-group-item py-1">
                    <i class='bx bx-devices me-2'></i><span>Business Details</span>
                </a>
                <a href="{{ route('shifts', $id) }}" class="list-group-item py-1">
                    <i class='bx bx-analyse me-2'></i><span>Shifts</span>
                </a>
                <a href="{{ route('areas', $id) }}" class="list-group-item py-1">
                    <i class='bx bx-plug me-2'></i><span>Areas</span>
                </a>
                <a href="{{ route('variables', $id) }}" class="list-group-item py-1">
                    <i class='bx bx-plug me-2'></i><span>Chaecklist Variables</span>
                </a>
                <a href="{{ route('checklist', $id) }}" class="list-group-item py-1">
                    <i class='bx bx-plug me-2'></i><span>Checklists</span>
                </a>
                <a href="{{ route('site', $id) }}" class="list-group-item py-1">
                    <i class='bx bx-trash-alt me-2'></i><span>Lines/Floors</span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="col">
            <div class="card radius-10 shadow-none border mb-0">
                <div class="card-body">
                    <div class="text-center">
                        <div class="w_chart chart8 mb-1" data-percent="78">
                            <span class="w_percent">70</span>
                          <canvas height="110" width="110"></canvas></div>
                        <p class="mb-0">Bounce Rate</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="progress mt-3" style="height:7px;">
            <div class="progress-bar" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0"
                aria-valuemax="100"></div>
            <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30"
                aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20"
                aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="mt-3"></div>
        <div class="d-flex align-items-center">
            <div class="fm-file-box bg-light-primary text-primary"><i class='bx bx-image'></i>
            </div>
            <div class="flex-grow-1 ms-2">
                <h6 class="mb-0">Total Shifts</h6>
                <p class="mb-0 text-secondary">1,756 files</p>
            </div>
            <h6 class="text-primary mb-0">15.3 GB</h6>
        </div>
        <div class="d-flex align-items-center mt-3">
            <div class="fm-file-box bg-light-success text-success"><i class='bx bxs-file-doc'></i>
            </div>
            <div class="flex-grow-1 ms-2">
                <h6 class="mb-0">Total Lines</h6>
                <p class="mb-0 text-secondary">123 files</p>
            </div>
            <h6 class="text-primary mb-0">256 MB</h6>
        </div>
        <div class="d-flex align-items-center mt-3">
            <div class="fm-file-box bg-light-danger text-danger"><i class='bx bx-video'></i>
            </div>
            <div class="flex-grow-1 ms-2">
                <h6 class="mb-0">Total Employess</h6>
                <p class="mb-0 text-secondary">24 files</p>
            </div>
            <h6 class="text-primary mb-0">3.4 GB</h6>
        </div>

    </div>
</div>
