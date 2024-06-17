<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('assets/logops.png') }}" class="logo-icon" alt="logo icon" style="width:45px !important;">

        </div>

        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">

        <li>
            <a href="{{ route('dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <hr>
        @if (ispermission('user management', 'update') || ispermission('user management', 'show'))
        <li>


            <a href="{{ route('usermanagement.index') }}">


                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">User Management</div>
            </a>
        </li>
        <hr>
        @endif
        @if (ispermission('client management', 'update') || ispermission('client management', 'show'))
        <li>
            <a href="{{ route('clients.index') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Client Management</div>
            </a>
        </li>
        <hr>
        @endif
        @if (ispermission('employee management', 'update') || ispermission('employee management', 'show'))
        <li>
            <a href="{{ route('employeemanagement.index') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Employee Management</div>
            </a>
        </li>
        <hr>
        @endif
        @if (ispermission('role management', 'update') || ispermission('role management', 'show'))
        {{-- <li>


            <a href="{{ route('role.index') }}">


                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Role Management</div>
            </a>
        </li> --}}
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Role Management</div>
            </a>
            <ul>
                <li> <a href="{{ route('role.index') }}"><i class='bx bx-radio-circle'></i>CRM Role</a>
                </li>
                <li> <a href="{{ route('role.feildexecutive.index') }}"><i class='bx bx-radio-circle'></i>Feild Executive Role</a>
                </li>
                
            </ul>
        </li>
        <hr>
        @endif
        @if (ispermission('sku management', 'update') || ispermission('sku management', 'show'))


        <li>


            <a href="{{ route('sku.index') }}">


                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">SKUS Management</div>
            </a>
        </li>
        <hr>
        @endif
        @if (ispermission('shift management', 'update') || ispermission('shift management', 'show'))
        <li>


            <a href="{{ route('shiftmanagement.index') }}">


                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Shift Management</div>
            </a>
        </li>
        <hr>
        @endif
        @if (ispermission('work assignment', 'update') || ispermission('work assignment', 'show'))
        <li>


            <a href="{{ route('workassignment.index') }}">


                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Work Assignment</div>
            </a>
        </li>
        <hr>
        @endif
        @if (ispermission('employee attendance', 'show'))
        <li>


            <a href="{{ route('employee.attendance.employeewise') }}">


                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Employee Attendance</div>
            </a>
        </li>
        <hr>
        @endif
        {{-- Manager & Admin & Distributer Sidebar --}}






    </ul>
    <!--end navigation-->
</div>
