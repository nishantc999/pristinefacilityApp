@extends('layouts.app')

@push('style')
    <link href="{{ asset('assets/backend/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <style>
        .row.row-broken {
            padding-bottom: 0;
        }

        .col-inside-lg {
            padding: 20px;
        }

        .chat {
            height: calc(100vh - 180px);
            /* height: 100vh; */
        }

        .decor-default {
            background-color: #ffffff;
        }

        .chat-users h6 {
            font-size: 20px;
            margin: 0 0 20px;
        }

        .chat-users .user {
            position: relative;
            padding: 0 0 0 50px;
            display: block;
            cursor: pointer;
            margin: 0 0 20px;
        }

        .chat-users .user .avatar {
            top: 0;
            left: 0;
        }

        .chat .avatar {
            width: 40px;
            height: 40px;
            position: absolute;
        }

        .chat .avatar img {
            display: block;
            border-radius: 20px;
            height: 100%;
        }

        .chat .avatar .status.off {
            border: 1px solid #5a5a5a;
            background: #ffffff;
        }

        .chat .avatar .status.online {
            background: #4caf50;
        }

        .chat .avatar .status.busy {
            background: #ffc107;
        }

        .chat .avatar .status.offline {
            background: #ed4e6e;
        }

        .chat-users .user .status {
            bottom: 0;
            left: 28px;
        }

        .chat .avatar .status {
            width: 10px;
            height: 10px;
            border-radius: 5px;
            position: absolute;
        }

        .chat-users .user .name {
            font-size: 14px;
            font-weight: bold;
            line-height: 20px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-users .user .mood {
            font: 200 14px/20px "Raleway", sans-serif;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /*****************CHAT BODY *******************/
        .chat-body h6 {
            font-size: 20px;
            margin: 0 0 20px;
        }

        .chat-body .answer.left {
            padding: 0 0 0 58px;
            text-align: left;
            float: left;
        }

        .chat-body .answer {
            position: relative;
            max-width: 600px;
            overflow: hidden;
            clear: both;
        }

        .chat-body .answer.left .avatar {
            left: 0;
        }

        .chat-body .answer .avatar {
            bottom: 36px;
        }

        .chat .avatar {
            width: 40px;
            height: 40px;
            position: absolute;
        }

        .chat .avatar img {
            display: block;
            border-radius: 20px;
            height: 100%;
        }

        .chat-body .answer .name {
            font-size: 14px;
            line-height: 36px;
        }

        .chat-body .answer.left .avatar .status {
            right: 4px;
        }

        .chat-body .answer .avatar .status {
            bottom: 0;
        }

        .chat-body .answer.left .text {
            background: #ebebeb;
            color: #333333;
            border-radius: 8px 8px 8px 0;
        }

        .chat-body .answer .text {
            padding: 12px;
            font-size: 16px;
            line-height: 26px;
            position: relative;
        }

        .chat-body .answer.left .text:before {
            left: -30px;
            border-right-color: #ebebeb;
            border-right-width: 12px;
        }

        .chat-body .answer .text:before {
            content: '';
            display: block;
            position: absolute;
            bottom: 0;
            border: 18px solid transparent;
            border-bottom-width: 0;
        }

        .chat-body .answer.left .time {
            padding-left: 12px;
            color: #333333;
        }

        .chat-body .answer .time {
            font-size: 16px;
            line-height: 36px;
            position: relative;
            padding-bottom: 1px;
        }

        /*RIGHT*/
        .chat-body .answer.right {
            padding: 0 58px 0 0;
            text-align: right;
            float: right;
        }

        .chat-body .answer.right .avatar {
            right: 0;
        }

        .chat-body .answer.right .avatar .status {
            left: 4px;
        }

        .text {
            word-break: break-all;
        }

        .chat-body .answer.right .text {
            background: #7266ba;
            color: #ffffff;
            border-radius: 8px 8px 0 8px;
        }

        .chat-body .answer.right .text:before {
            right: -30px;
            border-left-color: #7266ba;
            border-left-width: 12px;
        }

        .chat-body .answer.right .time {
            padding-right: 12px;
            color: #333333;
        }

        /**************ADD FORM ***************/
        .chat-body .answer-add {
            clear: both;
            position: relative;
            margin: 20px -20px -20px;
            padding: 20px;
            background: #46be8a;
        }

        .chat-body .answer-add input {
            border: none;
            background: none;
            display: block;
            width: 100%;
            font-size: 16px;
            line-height: 20px;
            padding: 0;
            color: #ffffff;
        }

        .chat input {
            -webkit-appearance: none;
            border-radius: 0;
        }

        .chat-body .answer-add .answer-btn-1 {
            background: url("http://91.234.35.26/iwiki-admin/v1.0.0/admin/img/icon-40.png") 50% 50% no-repeat;
            right: 56px;
        }

        .chat-body .answer-add .answer-btn {
            display: block;
            cursor: pointer;
            width: 36px;
            height: 36px;
            position: absolute;
            top: 50%;
            margin-top: -18px;
        }

        .chat-body .answer-add .answer-btn-2 {
            background: url("http://91.234.35.26/iwiki-admin/v1.0.0/admin/img/icon-41.png") 50% 50% no-repeat;
            right: 20px;
        }

        .chat input::-webkit-input-placeholder {
            color: #fff;
        }

        .chat input:-moz-placeholder {
            /* Firefox 18- */
            color: #fff;
        }

        .chat input::-moz-placeholder {
            /* Firefox 19+ */
            color: #fff;
        }

        .chat input:-ms-input-placeholder {
            color: #fff;
        }

        .chat input {
            -webkit-appearance: none;
            border-radius: 0;
        }

        .chat-footer {
            position: initial;
            z-index: 111;
            width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            @if (\Session::has('success'))
                @include('includes.partial.success_alert')
            @endif
            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleLargeModal">Large Modal</button> --}}
       
            {{-- <div class="chat-wrapper">
            <div class="chat-sidebar">
                <div class="chat-sidebar-header">
                    <div class="d-flex align-items-center">
                        <div class="chat-user-online">
                            <img src="assets/images/avatars/avatar-1.png" width="45" height="45" class="rounded-circle" alt="" />
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <p class="mb-0">Rachel Zane</p>
                        </div>
                        <div class="dropdown">
                            <div class="cursor-pointer font-24 dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded'></i>
                            </div>
                            <div class="dropdown-menu dropdown-menu-end"> <a class="dropdown-item" href="javascript:;">Settings</a>
                                <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Help & Feedback</a>
                                <a class="dropdown-item" href="javascript:;">Enable Split View Mode</a>
                                <a class="dropdown-item" href="javascript:;">Keyboard Shortcuts</a>
                                <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Sign Out</a>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3"></div>
                    <div class="input-group input-group-sm"> <span class="input-group-text bg-transparent"><i class='bx bx-search'></i></span>
                        <input type="text" class="form-control" placeholder="People, groups, & messages"> <span class="input-group-text bg-transparent"><i class='bx bx-dialpad'></i></span>
                    </div>
                    <div class="chat-tab-menu mt-3">
                        <ul class="nav nav-pills nav-justified">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="pill" href="javascript:;">
                                    <div class="font-24"><i class='bx bx-conversation'></i>
                                    </div>
                                    <div><small>Chats</small>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill" href="javascript:;">
                                    <div class="font-24"><i class='bx bx-phone'></i>
                                    </div>
                                    <div><small>Calls</small>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill" href="javascript:;">
                                    <div class="font-24"><i class='bx bxs-contact'></i>
                                    </div>
                                    <div><small>Contacts</small>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill" href="javascript:;">
                                    <div class="font-24"><i class='bx bx-bell'></i>
                                    </div>
                                    <div><small>Notifications</small>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="chat-sidebar-content">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-Chats">
                            <div class="p-3">
                                <div class="meeting-button d-flex justify-content-between">
                                    <div class="dropdown"> <a href="#" class="btn btn-white btn-sm radius-30 dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown"><i class='bx bx-video me-2'></i>Meet Now<i class='bx bxs-chevron-down ms-2'></i></a>
                                        <div class="dropdown-menu"> <a class="dropdown-item" href="#">Host a meeting</a>
                                            <a class="dropdown-item" href="#">Join a meeting</a>
                                        </div>
                                    </div>
                                    <div class="dropdown"> <a href="#" class="btn btn-white btn-sm radius-30 dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown" data-display="static"><i class='bx bxs-edit me-2'></i>New Chat<i class='bx bxs-chevron-down ms-2'></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">	<a class="dropdown-item" href="#">New Group Chat</a>
                                            <a class="dropdown-item" href="#">New Moderated Group</a>
                                            <a class="dropdown-item" href="#">New Chat</a>
                                            <a class="dropdown-item" href="#">New Private Conversation</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown mt-3"> <a href="#" class="text-uppercase text-secondary dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">Recent Chats <i class='bx bxs-chevron-down'></i></a>
                                    <div class="dropdown-menu">	<a class="dropdown-item" href="#">Recent Chats</a>
                                        <a class="dropdown-item" href="#">Hidden Chats</a>
                                        <div class="dropdown-divider"></div>	<a class="dropdown-item" href="#">Sort by Time</a>
                                        <a class="dropdown-item" href="#">Sort by Unread</a>
                                        <div class="dropdown-divider"></div>	<a class="dropdown-item" href="#">Show Favorites</a>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-list">
                                <div class="list-group list-group-flush">
                                    <a href="javascript:;" class="list-group-item">
                                        <div class="d-flex">
                                            <div class="chat-user-online">
                                                <img src="assets/images/avatars/avatar-2.png" width="42" height="42" class="rounded-circle" alt="" />
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h6 class="mb-0 chat-title">Louis Litt</h6>
                                                <p class="mb-0 chat-msg">You just got LITT up, Mike.</p>
                                            </div>
                                            <div class="chat-time">9:51 AM</div>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="list-group-item active">
                                        <div class="d-flex">
                                            <div class="chat-user-online">
                                                <img src="assets/images/avatars/avatar-3.png" width="42" height="42" class="rounded-circle" alt="" />
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h6 class="mb-0 chat-title">Harvey Specter</h6>
                                                <p class="mb-0 chat-msg">Wrong. You take the gun....</p>
                                            </div>
                                            <div class="chat-time">4:32 PM</div>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="list-group-item">
                                        <div class="d-flex">
                                            <div class="chat-user-online">
                                                <img src="assets/images/avatars/avatar-4.png" width="42" height="42" class="rounded-circle" alt="" />
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h6 class="mb-0 chat-title">Rachel Zane</h6>
                                                <p class="mb-0 chat-msg">I was thinking that we could...</p>
                                            </div>
                                            <div class="chat-time">Wed</div>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="list-group-item">
                                        <div class="d-flex">
                                            <div class="chat-user-online">
                                                <img src="assets/images/avatars/avatar-5.png" width="42" height="42" class="rounded-circle" alt="" />
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h6 class="mb-0 chat-title">Donna Paulsen</h6>
                                                <p class="mb-0 chat-msg">Mike, I know everything!</p>
                                            </div>
                                            <div class="chat-time">Tue</div>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="list-group-item">
                                        <div class="d-flex">
                                            <div class="chat-user-online">
                                                <img src="assets/images/avatars/avatar-6.png" width="42" height="42" class="rounded-circle" alt="" />
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h6 class="mb-0 chat-title">Jessica Pearson</h6>
                                                <p class="mb-0 chat-msg">Have you finished the draft...</p>
                                            </div>
                                            <div class="chat-time">9/3/2020</div>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="list-group-item">
                                        <div class="d-flex">
                                            <div class="chat-user-online">
                                                <img src="assets/images/avatars/avatar-7.png" width="42" height="42" class="rounded-circle" alt="" />
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h6 class="mb-0 chat-title">Harold Gunderson</h6>
                                                <p class="mb-0 chat-msg">Thanks Mike! :)</p>
                                            </div>
                                            <div class="chat-time">12/3/2020</div>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="list-group-item">
                                        <div class="d-flex">
                                            <div class="chat-user-online">
                                                <img src="assets/images/avatars/avatar-9.png" width="42" height="42" class="rounded-circle" alt="" />
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h6 class="mb-0 chat-title">Katrina Bennett</h6>
                                                <p class="mb-0 chat-msg">I've sent you the files for...</p>
                                            </div>
                                            <div class="chat-time">16/3/2020</div>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="list-group-item">
                                        <div class="d-flex">
                                            <div class="chat-user-online">
                                                <img src="assets/images/avatars/avatar-10.png" width="42" height="42" class="rounded-circle" alt="" />
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h6 class="mb-0 chat-title">Charles Forstman</h6>
                                                <p class="mb-0 chat-msg">Mike, this isn't over.</p>
                                            </div>
                                            <div class="chat-time">18/3/2020</div>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="list-group-item">
                                        <div class="d-flex">
                                            <div class="chat-user-online">
                                                <img src="assets/images/avatars/avatar-11.png" width="42" height="42" class="rounded-circle" alt="" />
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h6 class="mb-0 chat-title">Jonathan Sidwell</h6>
                                                <p class="mb-0 chat-msg">That's bullshit. This deal..</p>
                                            </div>
                                            <div class="chat-time">24/3/2020</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat-header d-flex align-items-center">
                <div class="chat-toggle-btn"><i class='bx bx-menu-alt-left'></i>
                </div>
                <div>
                    <h4 class="mb-1 font-weight-bold">Harvey Inspector</h4>
                    <div class="list-inline d-sm-flex mb-0 d-none"> <a href="javascript:;" class="list-inline-item d-flex align-items-center text-secondary"><small class='bx bxs-circle me-1 chart-online'></small>Active Now</a>
                        <a href="javascript:;" class="list-inline-item d-flex align-items-center text-secondary">|</a>
                        <a href="javascript:;" class="list-inline-item d-flex align-items-center text-secondary"><i class='bx bx-images me-1'></i>Gallery</a>
                        <a href="javascript:;" class="list-inline-item d-flex align-items-center text-secondary">|</a>
                        <a href="javascript:;" class="list-inline-item d-flex align-items-center text-secondary"><i class='bx bx-search me-1'></i>Find</a>
                    </div>
                </div>
                <div class="chat-top-header-menu ms-auto"> <a href="javascript:;"><i class='bx bx-video'></i></a>
                    <a href="javascript:;"><i class='bx bx-phone'></i></a>
                    <a href="javascript:;"><i class='bx bx-user-plus'></i></a>
                    
                </div>
            </div>
            <div class="chat-content">
                <div class="chat-content-leftside">
                    <div class="d-flex">
                        <img src="assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
                        <div class="flex-grow-1 ms-2">
                            <p class="mb-0 chat-time">Harvey, 2:35 PM</p>
                            <p class="chat-left-msg">Hi, harvey where are you now a days?</p>
                        </div>
                    </div>
                </div>
                <div class="chat-content-rightside">
                    <div class="d-flex ms-auto">
                        <div class="flex-grow-1 me-2">
                            <p class="mb-0 chat-time text-end">you, 2:37 PM</p>
                            <p class="chat-right-msg">I am in USA</p>
                        </div>
                    </div>
                </div>
                <div class="chat-content-leftside">
                    <div class="d-flex">
                        <img src="assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
                        <div class="flex-grow-1 ms-2">
                            <p class="mb-0 chat-time">Harvey, 2:48 PM</p>
                            <p class="chat-left-msg">okk, what about admin template?</p>
                        </div>
                    </div>
                </div>
                <div class="chat-content-rightside">
                    <div class="d-flex">
                        <div class="flex-grow-1 me-2">
                            <p class="mb-0 chat-time text-end">you, 2:49 PM</p>
                            <p class="chat-right-msg">i have already purchased the admin template</p>
                        </div>
                    </div>
                </div>
                <div class="chat-content-leftside">
                    <div class="d-flex">
                        <img src="assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
                        <div class="flex-grow-1 ms-2">
                            <p class="mb-0 chat-time">Harvey, 3:12 PM</p>
                            <p class="chat-left-msg">ohhk, great, which admin template you have purchased?</p>
                        </div>
                    </div>
                </div>
                <div class="chat-content-rightside">
                    <div class="d-flex">
                        <div class="flex-grow-1 me-2">
                            <p class="mb-0 chat-time text-end">you, 3:14 PM</p>
                            <p class="chat-right-msg">i purchased dashtreme admin template from. it is very good product for web application</p>
                        </div>
                    </div>
                </div>
                <div class="chat-content-leftside">
                    <div class="d-flex">
                        <img src="assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
                        <div class="flex-grow-1 ms-2">
                            <p class="mb-0 chat-time">Harvey, 3:16 PM</p>
                            <p class="chat-left-msg">who is the author of this template?</p>
                        </div>
                    </div>
                </div>
                <div class="chat-content-rightside">
                    <div class="d-flex">
                        <div class="flex-grow-1 me-2">
                            <p class="mb-0 chat-time text-end">you, 3:22 PM</p>
                            <p class="chat-right-msg">codervent is the author of this admin template</p>
                        </div>
                    </div>
                </div>
                <div class="chat-content-leftside">
                    <div class="d-flex">
                        <img src="assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
                        <div class="flex-grow-1 ms-2">
                            <p class="mb-0 chat-time">Harvey, 3:16 PM</p>
                            <p class="chat-left-msg">ohh i know about this author. he has good admin products in his portfolio.</p>
                        </div>
                    </div>
                </div>
                <div class="chat-content-rightside">
                    <div class="d-flex">
                        <div class="flex-grow-1 me-2">
                            <p class="mb-0 chat-time text-end">you, 3:30 PM</p>
                            <p class="chat-right-msg">yes, codervent has multiple admin templates. also he is very supportive.</p>
                        </div>
                    </div>
                </div>
                <div class="chat-content-leftside">
                    <div class="d-flex">
                        <img src="assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
                        <div class="flex-grow-1 ms-2">
                            <p class="mb-0 chat-time">Harvey, 3:33 PM</p>
                            <p class="chat-left-msg">All the best for your target. thanks for giving your time.</p>
                        </div>
                    </div>
                </div>
                <div class="chat-content-rightside">
                    <div class="d-flex">
                        <div class="flex-grow-1 me-2">
                            <p class="mb-0 chat-time text-end">you, 3:35 PM</p>
                            <p class="chat-right-msg">thanks Harvey</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat-footer d-flex align-items-center">
                <div class="flex-grow-1 pe-2">
                    <div class="input-group">	<span class="input-group-text"><i class='bx bx-smile'></i></span>
                        <input type="text" class="form-control" placeholder="Type a message">
                    </div>
                </div>
                <div class="chat-footer-menu"> <a href="javascript:;"><i class='bx bx-file'></i></a>
                    <a href="javascript:;"><i class='bx bxs-contact'></i></a>
                    <a href="javascript:;"><i class='bx bx-microphone'></i></a>
                    <a href="javascript:;"><i class='bx bx-dots-horizontal-rounded'></i></a>
                </div>
            </div>
            <!--start chat overlay-->
            <div class="overlay chat-toggle-btn-mobile"></div>
            <!--end chat overlay-->
        </div> --}}

            <div class="row row-broken bg-white ">

                <div class="col-sm-12 col-xs-12 chat" style="overflow: hidden; outline: none;" tabindex="5001">
                    <div class="col-inside-lg decor-default">
                        <div class="chat-header d-flex align-items-center" style="position: sticky">
                            {{-- <div class="chat-toggle-btn"><i class='bx bx-menu-alt-left'></i>
                            </div> --}}
                            <div>
                                <h4 class="mb-1 font-weight-bold">Ticket No. #{{ $complaint->id }}</h4>
                                <div class="list-inline d-sm-flex mb-0 d-none">
                                    <a href="javascript:;"
                                        class="list-inline-item d-flex align-items-center text-secondary">
                                        <small
                                            class="bx bxs-circle me-1 {{ $complaint->ticket_status == 'opened' ? 'chart-online' : 'chart-ofline' }}"></small>{{ $complaint->ticket_status == 'opened' ? 'Opened' : 'Closed' }}</a>
                                    <a href="javascript:;"
                                        class="list-inline-item d-flex align-items-center text-secondary">|</a>
                                    <a href="javascript:;"
                                        class="list-inline-item d-flex align-items-center text-secondary"><i
                                            class='bx bx-comment-minus me-1'></i>Subject: {{ $complaint->subject }} </a>
                                    {{-- <a href="javascript:;" class="list-inline-item d-flex align-items-center text-secondary">|</a>
                                <a href="javascript:;" class="list-inline-item d-flex align-items-center text-secondary"><i class='bx bx-search me-1'></i>Find</a> --}}
                                </div>
                            </div>
                            <div class="chat-top-header-menu ms-auto"> 
                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"><i class='bx bx-info-circle'></i></a>
                                {{-- <a href="javascript:;"><i class='bx bx-phone'></i></a>
                                <a href="javascript:;"><i class='bx bx-user-plus'></i></a> --}}

                            </div>
                        </div>
                        <div class="chat-body">
                            {{-- <h6>Mini Chat</h6> --}}
                            {{-- <div class="answer left">
                      <div class="avatar">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="User name">
                        <div class="status offline"></div>
                      </div>
                      <div class="name">Alexander Herthic</div>
                      <div class="text">
                        Lorem ipsum dolor amet, consectetur adipisicing elit Lorem ipsum dolor amet, consectetur adipisicing elit Lorem ipsum dolor amet, consectetur adiping elit
                      </div>
                      <div class="time">5 min ago</div>
                    </div> --}}
                            @foreach ($complaint->replies as $reply)
                                @if ($reply->sending_by == 'user')
                                    <div class="answer right">
                                        <div class="avatar">
                                            <img src="{{ asset('assets/images/profile/' . $reply->user->profile) }}"
                                                alt="User name">
                                            <div class="status offline"></div>
                                        </div>
                                        <div class="name">{{ $reply->user->name }}</div>
                                        <div class="text">
                                            @if ($reply->message)
                                                {{ $reply->message }}
                                            @endif
                                            @if ($reply->attachment)
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <a href="{{ asset('assets/images/' . $reply->attachment) }}"
                                                            target="_blank" class="">View Attachment</a>

                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                        <div class="time">{{ $reply->created_at->format('d-m-Y h:i A') }}</div>
                                    </div>
                                @else
                                    <div class="answer left">
                                        <div class="avatar">
                                            <img src="{{ asset('assets/images/profile/' . $reply->client->profile) }}"
                                                alt="User name">
                                            <div class="status offline"></div>
                                        </div>
                                        <div class="name">{{ $reply->client->name }}</div>
                                        <div class="text">
                                            @if ($reply->message)
                                                {{ $reply->message }}
                                            @endif
                                            @if ($reply->attachment)
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <a href="{{ asset('assets/images/' . $reply->attachment) }}"
                                                            target="_blank" class="">View Attachment</a>

                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                        <div class="time">{{ $reply->created_at->format('d-m-Y h:i A') }}</div>
                                    </div>
                                @endif
                            @endforeach
                            {{-- <div class="answer right">
                      <div class="avatar">
                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="User name">
                        <div class="status offline"></div>
                      </div>
                      <div class="name">Alexander Herthic</div>
                      <div class="text">
                        Lorem ipsum dolor amet, consectetur adipisicing elit Lorem ipsum dolor amet, consectetur adipisicing elit Lorem ipsum dolor amet, consectetur adiping elit
                      </div>
                      <div class="time">5 min ago</div>
                    </div>
                    <div class="answer left">
                      <div class="avatar">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="User name">
                        <div class="status online"></div>
                      </div>
                      <div class="name">Alexander Herthic</div>
                      <div class="text">
                        ...
                      </div>
                      <div class="time">5 min ago</div>
                    </div>
                    <div class="answer right">
                      <div class="avatar">
                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="User name">
                        <div class="status busy"></div>
                      </div>
                      <div class="name">Alexander Herthic</div>
                      <div class="text">
                        It is a long established fact that a reader will be. Thanks Mate!
                      </div>
                      <div class="time">5 min ago</div>
                    </div> --}}




                            {{-- for remove --}}






                            {{-- <div class="answer right">
                      <div class="avatar">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="User name">
                        <div class="status off"></div>
                      </div>
                      <div class="name">Alexander Herthic</div>
                      <div class="text">
                        It is a long established fact that a reader will be. Thanks Mate!
                      </div>
                      <div class="time">5 min ago</div>
                    </div>
                    <div class="answer left">
                      <div class="avatar">
                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="User name">
                        <div class="status offline"></div>
                      </div>
                      <div class="name">Alexander Herthic</div>
                      <div class="text">
                        Lorem ipsum dolor amet, consectetur adipisicing elit Lorem ipsum dolor amet, consectetur adipisicing elit Lorem ipsum dolor amet, consectetur adiping elit
                      </div>
                      <div class="time">5 min ago</div>
                    </div>
                    <div class="answer right">
                      <div class="avatar">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="User name">
                        <div class="status offline"></div>
                      </div>
                      <div class="name">Alexander Herthic</div>
                      <div class="text">
                        Lorem ipsum dolor amet, consectetur adipisicing elit Lorem ipsum dolor amet, consectetur adipisicing elit Lorem ipsum dolor amet, consectetur adiping elit
                      </div>
                      <div class="time">5 min ago</div>
                    </div>
                    <div class="answer left">
                      <div class="avatar">
                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="User name">
                        <div class="status online"></div>
                      </div>
                      <div class="name">Alexander Herthic</div>
                      <div class="text">
                        ...
                      </div>
                      <div class="time">5 min ago</div>
                    </div>
                    <div class="answer right">
                      <div class="avatar">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="User name">
                        <div class="status busy"></div>
                      </div>
                      <div class="name">Alexander Herthic</div>
                      <div class="text">
                        It is a long established fact that a reader will be. Thanks Mate!
                      </div>
                      <div class="time">5 min ago</div>
                    </div>
                    <div class="answer right">
                      <div class="avatar">
                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="User name">
                        <div class="status off"></div>
                      </div>
                      <div class="name">Alexander Herthic</div>
                      <div class="text">
                        It is a long established fact that a reader will be. Thanks Mate!
                      </div>
                      <div class="time">5 min ago</div>
                    </div> --}}
                            <div id="chat-messages">
                                <!-- Messages will be dynamically added here -->

                            </div>

                            <div class="mt-5">


                                <div class="chat-footer d-flex align-items-center" style="position: sticky;">
                                    <div class="flex-grow-1 pe-2">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-smile"></i></span>
                                            <input type="text" id="message" class="form-control"
                                                placeholder="Type a message">
                                        </div>
                                    </div>
                                    <div class="chat-footer-menu d-flex">
                                        <a href="javascript:;" onclick="document.getElementById('attachment').click();"><i
                                                class="bx bx-file"></i></a>
                                        <input type="file" id="attachment" style="display:none;">
                                        <a href="javascript:;" id="send-button"><i class="bx bx-send"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

         <!-- Modal -->
         <div class="modal fade" id="exampleLargeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur.</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>
    <script src="{{ asset('assets/backend/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        // $(document).ready(function() {
        //     var table = $('#example2').DataTable({
        //         lengthChange: true,
        //         // "order": [[0, 'desc']],
        //         buttons: ['copy', 'excel', 'pdf', 'print']
        //     });

        //     table.buttons().container()
        //         .appendTo('#example2_wrapper .col-md-6:eq(0)');
        // });





        // $('#client_id').select2({
        //     theme: "bootstrap-5",
        //     width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        //     placeholder: $(this).data('placeholder'),
        //     allowClear: true
        // });
    </script>

    <script>
        //         $(function(){
        //     $(".chat").niceScroll();



        // }) 
        $(document).ready(function() {
            // Initialize niceScroll on .chat container
            $(".chat").niceScroll();

            // Scroll to the bottom when page loads
            $(".chat").niceScroll().resize().scrollTop($(".chat")[0].scrollHeight);
        });

        // new PerfectScrollbar('.chat-list');
        // new PerfectScrollbar('.chat-content');
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#send-button').on('click', function() {
                var message = $('#message').val();
                var complaint_ticket_id = {{ $complaint->id }};
                var attachment = $('#attachment')[0].files[0];

                if (!message && !attachment) {
                    alert('Please enter a message or select an attachment.');
                    return;
                }

                var formData = new FormData();
                formData.append('message', message);
                formData.append('complaint_ticket_id', complaint_ticket_id);
                formData.append('_token', '{{ csrf_token() }}');
                if (attachment) {
                    formData.append('attachment', attachment);
                }

                $.ajax({
                    url: '/ticket/reply',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response)
                        $('#message').val('');
                        $('#attachment').val('');

                        var chatMessages = $('#chat-messages');
                        // var newMessage = $('<div>', { class: 'chat-message' }).html(`
                    //     <div class="message-content">
                    //         ${response.message}
                    //         ${response.attachment ? `<a href="${response.attachment}" target="_blank">View Attachment</a>` : ''}
                    //     </div>
                    // `);
                        var newMessage = $('<div>', {
                            class: 'chat-message'
                        }).html(`
                <div class="answer right">
                <div class="avatar">
                <img src="{{ asset('assets/images/profile/' . auth()->user()->profile) }}" alt="User name">
                <div class="status offline"></div>
                </div>
                <div class="name">{{ auth()->user()->name }}</div>
                <div class="text">

       
            ${response.message?response.message:''} 

           
           
           ${response.attachment ? `<div class="card text-center">
                <div class="card-body"><a href="${response.attachment}" target="_blank">View Attachment</a>    </div>
            </div>` : ''}
           
      
        
     

                    </div>
                    <div class="time">${response.created_at}</div>
                </div>


        `);
                        chatMessages.append(newMessage);
                        // chatMessages.scrollTop(chatMessages[0].scrollHeight);
                        $(".chat").niceScroll().resize().scrollTop($(".chat")[0].scrollHeight);
                    },
                    error: function(xhr, status, error) {
                        console.error('An error occurred:', xhr
                        .responseText); // Log full error response

                        var errorMessage = 'An error occurred while sending the message.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }

                        alert(errorMessage); // Display user-friendly error message
                    }
                });
            });
        });
    </script>



   
@endpush
