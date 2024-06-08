@extends('layouts.app')

@push('style')
@endpush
@section('content')

    <div class="page-wrapper">
        <div class="page-content">
            @if (\Session::has('error'))
            @include('includes.partial.error_alert')
            @endif

            {{-- <div class="row row-cols-1 row-cols-lg-4">
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-start gap-3">
                                <div class="widgets-icons-3 bg-gradient-deepblue text-white">
                                    <i class='bx bx-wallet'></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between mb-2 w-100">
                                        <p class="mb-0">Total Distributers</p>
                                    </div>
                                    <h2 class="mb-0">{{ $total_distributer }}</h2>
                                 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             


            </div> --}}
            
            <!--end row-->
            {{-- <div class="row">
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-start gap-3">
                                <div class="widgets-icons-3 bg-gradient-deepblue text-white">
                                    <i class='bx bx-wallet'></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between mb-2 w-100">
                                        <p class="mb-0">Total SKU's</p>
                                    </div>
                                    <h2 class="mb-0">{{ $skus }}</h2>
                                 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-start gap-3">
                                <div class="widgets-icons-3 bg-gradient-purple text-white">
                                    <i class='bx bx-group'></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between mb-2 w-100">
                                        <p class="mb-0">Total Vehicles</p>

                                    </div>
                                    <h2 class="mb-0">{{ $vehicles }}</h2>
                                    <p class="mb-0">Active </p> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> --}}

            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <h6 class="mb-0">Sales Overview</h6>
                                </div>
                                <div class="ms-auto d-flex align-items-center gap-2">
                                    <div class="dropdown">
                                        <a href="javascript:;"
                                            class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-nocaret"
                                            data-bs-toggle="dropdown">
                                            This Month<i class='bx bx-chevron-down ms-2'></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">This Month</a>
                                            <a class="dropdown-item" href="#">Last Month</a>
                                            <a class="dropdown-item" href="#">Last year</a>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="javascript:;" class="btn btn-sm btn-dark">
                                            Download<i class='bx bx-cloud-download ms-2'></i>
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <div class="chart-container">
                                <canvas id="chart1"></canvas>
                            </div>

                        </div>
                    </div>
                </div>

            </div><!--end row-->


            <div class="row">
                <div class="col-12 col-lg-4 d-flex">
                    <div class="card radius-10 overflow-hidden w-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <h6 class="mb-0">Product Earnings</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                        data-bs-toggle="dropdown"><i
                                            class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chart-container-9">
                                <div class="piechart-legend">
                                    <h2 class="mb-1">$85K</h2>
                                    <h6 class="mb-0">Total Income</h6>
                                </div>
                                <canvas id="chart2"></canvas>
                            </div>
                        </div>
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td><i class='bx bxs-square-rounded me-2 text-primary'></i>Clothing</td>
                                    <td>
                                        <div>224</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">$2893</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class='bx bxs-square-rounded me-2 text-danger'></i>Electronic</td>
                                    <td>
                                        <div>357</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">$6823</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class='bx bxs-square-rounded me-2 text-success'></i>Furniture</td>
                                    <td>
                                        <div>890</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">$8975</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-lg-4 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <h6 class="mb-0">Product List</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                        data-bs-toggle="dropdown"><i
                                            class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-list">
                                <div class="d-flex align-items-center gap-3">
                                    <div>
                                        <input class="form-check-input" type="checkbox" id="checkboxNoLabel"
                                            value="" aria-label="...">
                                    </div>
                                    <div class="">
                                        <img src="assets/images/app/html-5.png" width="50" height="50"
                                            class="p-2 border radius-10" alt="product img">
                                    </div>
                                    <div class="">
                                        <h6 class="mb-0">Html Admin Template</h6>
                                    </div>
                                    <div class="ms-auto">
                                        <p class="mb-0 border px-2 rounded">230</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex align-items-center gap-3">
                                    <div>
                                        <input class="form-check-input" type="checkbox" id="checkboxNoLabel"
                                            value="" aria-label="...">
                                    </div>
                                    <div class="">
                                        <img src="assets/images/app/angular.png" width="50" height="50"
                                            class="p-2 border radius-10" alt="product img">
                                    </div>
                                    <div class="">
                                        <h6 class="mb-0">Html Admin Template</h6>
                                    </div>
                                    <div class="ms-auto">
                                        <p class="mb-0 border px-2 rounded">230</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex align-items-center gap-3">
                                    <div>
                                        <input class="form-check-input" type="checkbox" id="checkboxNoLabel"
                                            value="" aria-label="...">
                                    </div>
                                    <div class="">
                                        <img src="assets/images/app/vue.png" width="50" height="50"
                                            class="p-2 border radius-10" alt="product img">
                                    </div>
                                    <div class="">
                                        <h6 class="mb-0">Html Admin Template</h6>
                                    </div>
                                    <div class="ms-auto">
                                        <p class="mb-0 border px-2 rounded">230</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex align-items-center gap-3">
                                    <div>
                                        <input class="form-check-input" type="checkbox" id="checkboxNoLabel"
                                            value="" aria-label="...">
                                    </div>
                                    <div class="">
                                        <img src="assets/images/app/react.png" width="50" height="50"
                                            class="p-2 border radius-10" alt="product img">
                                    </div>
                                    <div class="">
                                        <h6 class="mb-0">Html Admin Template</h6>
                                    </div>
                                    <div class="ms-auto">
                                        <p class="mb-0 border px-2 rounded">230</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex align-items-center gap-3">
                                    <div>
                                        <input class="form-check-input" type="checkbox" id="checkboxNoLabel"
                                            value="" aria-label="...">
                                    </div>
                                    <div class="">
                                        <img src="assets/images/app/bootstrap.png" width="50" height="50"
                                            class="p-2 border radius-10" alt="product img">
                                    </div>
                                    <div class="">
                                        <h6 class="mb-0">Html Admin Template</h6>
                                    </div>
                                    <div class="ms-auto">
                                        <p class="mb-0 border px-2 rounded">230</p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 d-flex">
                    <div class="card w-100 radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <h6 class="mb-0">Monthly Sales</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                        data-bs-toggle="dropdown"><i
                                            class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chart-container">
                                <canvas id="chart3"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!--end row-->

            <div class="card radius-10">
                <div class="card-header bg-transparent">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Recent Orders</h6>
                        </div>
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                data-bs-toggle="dropdown"><i
                                    class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Photo</th>
                                    <th>Product ID</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Shipping</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Iphone 5</td>
                                    <td><img src="assets/images/products/01.png" class="product-img-2" alt="product img">
                                    </td>
                                    <td>#9405822</td>
                                    <td><span class="badge bg-gradient-quepal text-white shadow-sm w-100">Paid</span></td>
                                    <td>$1250.00</td>
                                    <td>03 Feb 2020</td>
                                    <td>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-gradient-quepal" role="progressbar"
                                                style="width: 100%"></div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Earphone GL</td>
                                    <td><img src="assets/images/products/02.png" class="product-img-2" alt="product img">
                                    </td>
                                    <td>#8304620</td>
                                    <td><span class="badge bg-gradient-blooker text-white shadow-sm w-100">Pending</span>
                                    </td>
                                    <td>$1500.00</td>
                                    <td>05 Feb 2020</td>
                                    <td>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-gradient-blooker" role="progressbar"
                                                style="width: 60%"></div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>HD Hand Camera</td>
                                    <td><img src="assets/images/products/03.png" class="product-img-2" alt="product img">
                                    </td>
                                    <td>#4736890</td>
                                    <td><span class="badge bg-gradient-bloody text-white shadow-sm w-100">Failed</span>
                                    </td>
                                    <td>$1400.00</td>
                                    <td>06 Feb 2020</td>
                                    <td>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-gradient-bloody" role="progressbar"
                                                style="width: 70%"></div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Clasic Shoes</td>
                                    <td><img src="assets/images/products/04.png" class="product-img-2" alt="product img">
                                    </td>
                                    <td>#8543765</td>
                                    <td><span class="badge bg-gradient-quepal text-white shadow-sm w-100">Paid</span></td>
                                    <td>$1200.00</td>
                                    <td>14 Feb 2020</td>
                                    <td>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-gradient-quepal" role="progressbar"
                                                style="width: 100%"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sitting Chair</td>
                                    <td><img src="assets/images/products/06.png" class="product-img-2" alt="product img">
                                    </td>
                                    <td>#9629240</td>
                                    <td><span class="badge bg-gradient-blooker text-white shadow-sm w-100">Pending</span>
                                    </td>
                                    <td>$1500.00</td>
                                    <td>18 Feb 2020</td>
                                    <td>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-gradient-blooker" role="progressbar"
                                                style="width: 60%"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hand Watch</td>
                                    <td><img src="assets/images/products/05.png" class="product-img-2" alt="product img">
                                    </td>
                                    <td>#8506790</td>
                                    <td><span class="badge bg-gradient-bloody text-white shadow-sm w-100">Failed</span>
                                    </td>
                                    <td>$1800.00</td>
                                    <td>21 Feb 2020</td>
                                    <td>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-gradient-bloody" role="progressbar"
                                                style="width: 40%"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('script')
@endpush
