<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    @if ($success = Session::get('success'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ $success }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div> --}}
    <script src="https://kit.fontawesome.com/cbeaa37f05.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ URL::asset('css') }}/kien_profile.css">
    





    {{-- Modal --}}
    @include('profile.edit-profile')
    @include('profile.edit-email')
    @include('profile.edit-password')

    <!-- Content -->
    <div class="profile-container top">
        <div class="profile-cover">
            <div class="profile-cover-fix">
                <div class="thumnail">
                    <img src="{{ URL::asset('img') }}/cover.jpg" alt="" class="cover-img">
                </div>
                <button class="fix-cover"><i class="fa-solid fa-camera-retro"></i>Chỉnh sửa ảnh bìa</button>
                <div class="image-cover">
                    <img class="pd-images" src="{{ URL::asset('img') }}/kien.png" alt="">
                    <i class="fa-solid fa-camera-retro"></i>
                </div>
            </div>
        </div>
        <div class="profile-details">
            <div class="profile-detail">
                <div class="pd-left">
                    <div class="pd-row">
                        <div>
                            <h3>{{ $user->userProfile->name ?? $user->name }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="profile-container bottom">
        <div class="profile-cate">
            <div class="cate-col">
                <div class="cate-content">
                    <i class="fa-solid fa-user"></i>
                    Thông tin tài khoản
                </div>
                <div class="cate-content">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Lịch sử đơn hàng
                </div>
                <div class="cate-content">
                    <i class="fa-solid fa-star"></i>
                    Đánh giá và phản hồi
                </div>
                <div class="cate-content">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Đăng xuất
                </div>
            </div>
            <div class="post-col">
                <div class="cate-content">
                    <div class="flex-info">
                        <h3 class="account-page-title">
                            Thông tin cá nhân
                        </h3>
                        <div class="account-info__form">
                            <div class="account-info__field">
                                <div class="account-info__label">
                                    Họ và tên
                                </div>
                                <div class="account-info__value">
                                    {{ $user->userProfile->name ?? $user->name }}
                                </div>
                            </div>
                            <div class="account-info__field">
                                <div class="account-info__label">
                                    Số điện thoại
                                </div>
                                <div class="account-info__value">
                                    {{ $user->userProfile->phone ?? 'Chưa cập nhật' }}
                                </div>
                            </div>
                            <div class="account-info__field">
                                <div class="account-info__label">
                                    Ngày sinh
                                </div>
                                <div class="account-info__value">
                                    {{ $user->userProfile->birth ?? 'Chưa cập nhật' }}
                                </div>
                            </div>
                            <div class="account-info__field">
                                <div class="account-info__label">
                                    Địa chỉ
                                </div>
                                <div class="account-info__value">
                                    {{ $user->userProfile->address ?? 'Chưa cập nhật' }}
                                </div>
                            </div>
                            <div class="account-info__field">
                                <div class="account-info__label">
                                    Thông tin thêm
                                </div>
                                <div class="account-info__value">
                                    {{ $user->userProfile->introduce ?? 'Chưa cập nhật' }}
                                </div>
                            </div>
                            <div class="account-info__field"><button class="btn account-info__btn btn-info ">
                                    Cập nhật
                                </button></div>
                        </div>
                        <h3 class="account-page-title">
                            Thông tin đăng nhập
                        </h3>
                        <div class="account-info__field">
                            <div class="account-info__label">
                                Email
                            </div>
                            <div class="account-info__value">
                                {{ $user->email }}
                            </div>
                        </div>
                        <div class="account-info__field">
                            <div class="account-info__label">
                                Mật khẩu
                            </div>
                            <div class="account-info__value">
                                *********
                            </div>
                        </div>
                        <div class="account-info__field"><button class="btn account-info__btn btn-login">
                                Cập nhật
                            </button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ URL::asset('js') }}/kien_profile.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</x-app-layout>
