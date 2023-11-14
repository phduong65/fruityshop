@extends('layouts.manager')
@section('manager_setting')
    <style>
        .darkMode1 {
            background: #343541;
        }

        .darkMode2 {
            color: #ffffff;
        }

        .darkMode3 {
            background: #444654;
        }
    </style>
    <div class="manager_content">
        <div class="manager_content-product">
            <div class="textbox">
                <h2>Setting</h2>
            </div>
            <form id="uploadForm-logo" action="{{route('logo.update')}}" class="form-setting" method="POST" enctype="multipart/form-data" >
                @csrf
                @method('GET')
                <div class="form-child-setting">
                    <h3>Logo</h3>
                    <div class="logo-total">
                        <div class="logo-cover">
                            <img class="anhHienThi" src="{{URL::asset('img')}}/" alt="">
                        </div>

                        <div class="change-img">
                            <label for="logo">
                                <i id="changeImageBtn" class="fa-regular fa-image"></i>
                            </label>
                            <input class="input-logo" name="logo" type="file" id="logo" style="display: none;"
                                accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="form-child-setting">
                    <h3>Theme</h3>
                    <select name="" id="theme-select">
                        <option value="sys">System</option>
                        <option value="dark">Dark</option>
                        <option value="light">Light</option>
                    </select>
                </div>
                <div class="form-child-setting">
                    <h3>Language</h3>
                    <select name="" id="language-select">
                        <option value="en">English</option>
                        <option value="vi">Vietnamese</option>
                        <option value="es">Español</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary save-setting">Lưu</button>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("input.input-logo").change(function() {
                console.log("mới thay");
                var file = this.files[0];
                var url = URL.createObjectURL(file);
                $(this)
                    .closest(".logo-total")
                    .find(".anhHienThi")
                    .attr("src", url);
            });
        });
    </script>
@endsection
