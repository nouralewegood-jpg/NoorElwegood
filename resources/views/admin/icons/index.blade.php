@extends('admin.layouts.master')

@section('title', 'مكتبة الأيقونات')

@section('css')
    <style>
        .icon-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            height: 100px;
        }

        .icon-item:hover {
            background-color: rgba(0, 123, 255, 0.1);
            transform: translateY(-5px);
        }

        .icon-item i {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .icon-item .icon-name {
            font-size: 12px;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        .icon-section {
            margin-bottom: 30px;
        }

        .copied-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            display: none;
            z-index: 9999;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .nav-pills .nav-link.active {
            background-color: #1f2940;
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الأدوات المساعدة</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ مكتبة الأيقونات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">مكتبة الأيقونات</h4>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">اختر أيقونة للنسخ واستخدامها في مشروعك</p>
                </div>
                <div class="card-body">
                    <div class="search-container">
                        <input type="text" class="form-control" id="icon-search" placeholder="ابحث عن أيقونة...">
                    </div>

                    <ul class="nav nav-pills mb-4" id="icons-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="bootstrap-icons-tab" data-toggle="pill" href="#bootstrap-icons"
                                role="tab" aria-controls="bootstrap-icons" aria-selected="true">Bootstrap Icons</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="fontawesome-icons-tab" data-toggle="pill" href="#fontawesome-icons"
                                role="tab" aria-controls="fontawesome-icons" aria-selected="false">Font Awesome</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="icons-tabContent">
                        <!-- Bootstrap Icons -->
                        <div class="tab-pane fade show active" id="bootstrap-icons" role="tabpanel"
                            aria-labelledby="bootstrap-icons-tab">
                            <div class="row icon-section">
                                <div class="col-12">
                                    <h5 class="mg-b-20">أيقونات Bootstrap</h5>
                                </div>

                                <!-- General Icons -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-house-fill">
                                        <i class="bi bi-house-fill"></i>
                                        <div class="icon-name">bi bi-house-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-person-fill">
                                        <i class="bi bi-person-fill"></i>
                                        <div class="icon-name">bi bi-person-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-gear-fill">
                                        <i class="bi bi-gear-fill"></i>
                                        <div class="icon-name">bi bi-gear-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-check-circle-fill">
                                        <i class="bi bi-check-circle-fill"></i>
                                        <div class="icon-name">bi bi-check-circle-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-x-circle-fill">
                                        <i class="bi bi-x-circle-fill"></i>
                                        <div class="icon-name">bi bi-x-circle-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-exclamation-circle-fill">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        <div class="icon-name">bi bi-exclamation-circle-fill</div>
                                    </div>
                                </div>

                                <!-- Communication Icons -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-envelope-fill">
                                        <i class="bi bi-envelope-fill"></i>
                                        <div class="icon-name">bi bi-envelope-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-telephone-fill">
                                        <i class="bi bi-telephone-fill"></i>
                                        <div class="icon-name">bi bi-telephone-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-chat-fill">
                                        <i class="bi bi-chat-fill"></i>
                                        <div class="icon-name">bi bi-chat-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-bell-fill">
                                        <i class="bi bi-bell-fill"></i>
                                        <div class="icon-name">bi bi-bell-fill</div>
                                    </div>
                                </div>

                                <!-- Arrows & Direction -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-arrow-right">
                                        <i class="bi bi-arrow-right"></i>
                                        <div class="icon-name">bi bi-arrow-right</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-arrow-left">
                                        <i class="bi bi-arrow-left"></i>
                                        <div class="icon-name">bi bi-arrow-left</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-arrow-up">
                                        <i class="bi bi-arrow-up"></i>
                                        <div class="icon-name">bi bi-arrow-up</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-arrow-down">
                                        <i class="bi bi-arrow-down"></i>
                                        <div class="icon-name">bi bi-arrow-down</div>
                                    </div>
                                </div>

                                <!-- Social Icons -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-facebook">
                                        <i class="bi bi-facebook"></i>
                                        <div class="icon-name">bi bi-facebook</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-twitter-x">
                                        <i class="bi bi-twitter-x"></i>
                                        <div class="icon-name">bi bi-twitter-x</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-linkedin">
                                        <i class="bi bi-linkedin"></i>
                                        <div class="icon-name">bi bi-linkedin</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-instagram">
                                        <i class="bi bi-instagram"></i>
                                        <div class="icon-name">bi bi-instagram</div>
                                    </div>
                                </div>

                                <!-- Files & Folders -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-file-earmark-fill">
                                        <i class="bi bi-file-earmark-fill"></i>
                                        <div class="icon-name">bi bi-file-earmark-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-folder-fill">
                                        <i class="bi bi-folder-fill"></i>
                                        <div class="icon-name">bi bi-folder-fill</div>
                                    </div>
                                </div>

                                <!-- Media Controls -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-play-circle">
                                        <i class="bi bi-play-circle"></i>
                                        <div class="icon-name">bi bi-play-circle</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-pause-circle">
                                        <i class="bi bi-pause-circle"></i>
                                        <div class="icon-name">bi bi-pause-circle</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-skip-forward">
                                        <i class="bi bi-skip-forward"></i>
                                        <div class="icon-name">bi bi-skip-forward</div>
                                    </div>
                                </div>

                                <!-- Additional Icons -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-heart-fill">
                                        <i class="bi bi-heart-fill"></i>
                                        <div class="icon-name">bi bi-heart-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-star-fill">
                                        <i class="bi bi-star-fill"></i>
                                        <div class="icon-name">bi bi-star-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-bookmark-fill">
                                        <i class="bi bi-bookmark-fill"></i>
                                        <div class="icon-name">bi bi-bookmark-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-trash-fill">
                                        <i class="bi bi-trash-fill"></i>
                                        <div class="icon-name">bi bi-trash-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-plus-circle-fill">
                                        <i class="bi bi-plus-circle-fill"></i>
                                        <div class="icon-name">bi bi-plus-circle-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-dash-circle-fill">
                                        <i class="bi bi-dash-circle-fill"></i>
                                        <div class="icon-name">bi bi-dash-circle-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-camera-fill">
                                        <i class="bi bi-camera-fill"></i>
                                        <div class="icon-name">bi bi-camera-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-image-fill">
                                        <i class="bi bi-image-fill"></i>
                                        <div class="icon-name">bi bi-image-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-credit-card-fill">
                                        <i class="bi bi-credit-card-fill"></i>
                                        <div class="icon-name">bi bi-credit-card-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-cart-fill">
                                        <i class="bi bi-cart-fill"></i>
                                        <div class="icon-name">bi bi-cart-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-bag-fill">
                                        <i class="bi bi-bag-fill"></i>
                                        <div class="icon-name">bi bi-bag-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-calendar-fill">
                                        <i class="bi bi-calendar-fill"></i>
                                        <div class="icon-name">bi bi-calendar-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-clock-fill">
                                        <i class="bi bi-clock-fill"></i>
                                        <div class="icon-name">bi bi-clock-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-globe">
                                        <i class="bi bi-globe"></i>
                                        <div class="icon-name">bi bi-globe</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-shield-check">
                                        <i class="bi bi-shield-check"></i>
                                        <div class="icon-name">bi bi-shield-check</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-lock-fill">
                                        <i class="bi bi-lock-fill"></i>
                                        <div class="icon-name">bi bi-lock-fill</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="bi bi-unlock-fill">
                                        <i class="bi bi-unlock-fill"></i>
                                        <div class="icon-name">bi bi-unlock-fill</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Font Awesome Icons -->
                        <div class="tab-pane fade" id="fontawesome-icons" role="tabpanel"
                            aria-labelledby="fontawesome-icons-tab">
                            <div class="row icon-section">
                                <div class="col-12">
                                    <h5 class="mg-b-20">أيقونات Font Awesome</h5>
                                </div>

                                <!-- Solid Icons -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-home">
                                        <i class="fa fa-home"></i>
                                        <div class="icon-name">fa fa-home</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-user">
                                        <i class="fa fa-user"></i>
                                        <div class="icon-name">fa fa-user</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-cog">
                                        <i class="fa fa-cog"></i>
                                        <div class="icon-name">fa fa-cog</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-check-circle">
                                        <i class="fa fa-check-circle"></i>
                                        <div class="icon-name">fa fa-check-circle</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-times-circle">
                                        <i class="fa fa-times-circle"></i>
                                        <div class="icon-name">fa fa-times-circle</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-exclamation-circle">
                                        <i class="fa fa-exclamation-circle"></i>
                                        <div class="icon-name">fa fa-exclamation-circle</div>
                                    </div>
                                </div>

                                <!-- Communication Icons -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-envelope">
                                        <i class="fa fa-envelope"></i>
                                        <div class="icon-name">fa fa-envelope</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-phone">
                                        <i class="fa fa-phone"></i>
                                        <div class="icon-name">fa fa-phone</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-comment">
                                        <i class="fa fa-comment"></i>
                                        <div class="icon-name">fa fa-comment</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-bell">
                                        <i class="fa fa-bell"></i>
                                        <div class="icon-name">fa fa-bell</div>
                                    </div>
                                </div>

                                <!-- Arrows & Direction -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-arrow-right">
                                        <i class="fa fa-arrow-right"></i>
                                        <div class="icon-name">fa fa-arrow-right</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-arrow-left">
                                        <i class="fa fa-arrow-left"></i>
                                        <div class="icon-name">fa fa-arrow-left</div>
                                    </div>
                                </div>

                                <!-- Social Icons -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fab fa-facebook-f">
                                        <i class="fab fa-facebook-f"></i>
                                        <div class="icon-name">fab fa-facebook-f</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fab fa-twitter">
                                        <i class="fab fa-twitter"></i>
                                        <div class="icon-name">fab fa-twitter</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fab fa-linkedin-in">
                                        <i class="fab fa-linkedin-in"></i>
                                        <div class="icon-name">fab fa-linkedin-in</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fab fa-instagram">
                                        <i class="fab fa-instagram"></i>
                                        <div class="icon-name">fab fa-instagram</div>
                                    </div>
                                </div>

                                <!-- Files & Folders -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-file">
                                        <i class="fa fa-file"></i>
                                        <div class="icon-name">fa fa-file</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-folder">
                                        <i class="fa fa-folder"></i>
                                        <div class="icon-name">fa fa-folder</div>
                                    </div>
                                </div>

                                <!-- Media Controls -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-play-circle">
                                        <i class="fa fa-play-circle"></i>
                                        <div class="icon-name">fa fa-play-circle</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-pause-circle">
                                        <i class="fa fa-pause-circle"></i>
                                        <div class="icon-name">fa fa-pause-circle</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-step-forward">
                                        <i class="fa fa-step-forward"></i>
                                        <div class="icon-name">fa fa-step-forward</div>
                                    </div>
                                </div>

                                <!-- Additional Icons -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-heart">
                                        <i class="fa fa-heart"></i>
                                        <div class="icon-name">fa fa-heart</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-star">
                                        <i class="fa fa-star"></i>
                                        <div class="icon-name">fa fa-star</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-bookmark">
                                        <i class="fa fa-bookmark"></i>
                                        <div class="icon-name">fa fa-bookmark</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-trash">
                                        <i class="fa fa-trash"></i>
                                        <div class="icon-name">fa fa-trash</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-plus-circle">
                                        <i class="fa fa-plus-circle"></i>
                                        <div class="icon-name">fa fa-plus-circle</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-minus-circle">
                                        <i class="fa fa-minus-circle"></i>
                                        <div class="icon-name">fa fa-minus-circle</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-camera">
                                        <i class="fa fa-camera"></i>
                                        <div class="icon-name">fa fa-camera</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-image">
                                        <i class="fa fa-image"></i>
                                        <div class="icon-name">fa fa-image</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-credit-card">
                                        <i class="fa fa-credit-card"></i>
                                        <div class="icon-name">fa fa-credit-card</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-shopping-cart">
                                        <i class="fa fa-shopping-cart"></i>
                                        <div class="icon-name">fa fa-shopping-cart</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-shopping-bag">
                                        <i class="fa fa-shopping-bag"></i>
                                        <div class="icon-name">fa fa-shopping-bag</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-calendar">
                                        <i class="fa fa-calendar"></i>
                                        <div class="icon-name">fa fa-calendar</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-clock">
                                        <i class="fa fa-clock"></i>
                                        <div class="icon-name">fa fa-clock</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-globe">
                                        <i class="fa fa-globe"></i>
                                        <div class="icon-name">fa fa-globe</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-shield-alt">
                                        <i class="fa fa-shield-alt"></i>
                                        <div class="icon-name">fa fa-shield-alt</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-lock">
                                        <i class="fa fa-lock"></i>
                                        <div class="icon-name">fa fa-lock</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-unlock">
                                        <i class="fa fa-unlock"></i>
                                        <div class="icon-name">fa fa-unlock</div>
                                    </div>
                                </div>
                                <!-- Business/Commerce Icons -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-chart-line">
                                        <i class="fa fa-chart-line"></i>
                                        <div class="icon-name">fa fa-chart-line</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-chart-pie">
                                        <i class="fa fa-chart-pie"></i>
                                        <div class="icon-name">fa fa-chart-pie</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-chart-bar">
                                        <i class="fa fa-chart-bar"></i>
                                        <div class="icon-name">fa fa-chart-bar</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-dollar-sign">
                                        <i class="fa fa-dollar-sign"></i>
                                        <div class="icon-name">fa fa-dollar-sign</div>
                                    </div>
                                </div>
                                <!-- Technology Icons -->
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-laptop">
                                        <i class="fa fa-laptop"></i>
                                        <div class="icon-name">fa fa-laptop</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-mobile-alt">
                                        <i class="fa fa-mobile-alt"></i>
                                        <div class="icon-name">fa fa-mobile-alt</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-tablet-alt">
                                        <i class="fa fa-tablet-alt"></i>
                                        <div class="icon-name">fa fa-tablet-alt</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="icon-item" data-icon="fa fa-desktop">
                                        <i class="fa fa-desktop"></i>
                                        <div class="icon-name">fa fa-desktop</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copied-message" id="copied-message">تم نسخ الأيقونة!</div>
@endsection

@section('js')
    <script>
        $(function() {
            // Handle icon click (copy to clipboard)
            $('.icon-item').click(function() {
                var iconName = $(this).data('icon');
                var tempInput = document.createElement('input');
                document.body.appendChild(tempInput);
                tempInput.value = iconName;
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);

                // Show copied message
                $('#copied-message').fadeIn().delay(1500).fadeOut();
            });

            // Handle search
            $('#icon-search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('.icon-item').filter(function() {
                    var matches = $(this).data('icon').toLowerCase().indexOf(value) > -1;
                    $(this).closest('.col-lg-2').toggle(matches);
                });
            });
        });
    </script>
@endsection
