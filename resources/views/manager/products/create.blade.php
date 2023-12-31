@extends('layouts.manager')
@section('title', 'Manage Product Create')
@section('manager_product-create')
    <div class="form-box">
        <h2 class="title">Create Product New</h2>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="wrap">
                <div class="box_left">
                    <div class="box_left-top">
                        <div class="form_product-name --same">
                            <label for="exampleFormControlInput1" class="form-label">Tên Sản Phẩm</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1"
                                placeholder="Tên Sản Phẩm" name="nameproduct" required oninput="validateInput()" />
                            <div class="invalid-feedback" id="error-message-name">Không được nhập quá 255 kí tự</div>
                        </div>
                        <div class="form_product-des --same">
                            <label for="content" class="form-label">Mô Tả</label>
                            <textarea class="block" placeholder="Mô tả sản phẩm" id="content" name="description"></textarea>
                        </div>
                        <div class="form_product-price --same">
                            <div class="priceroot">
                                <label for="exampleFormControlInput1" class="form-label">Giá bán</label>
                                <input type="number" class="form-control" id="exampleFormControlInput1"
                                    placeholder="Giá sản phẩm" name="price" min="0" required
                                    oninput="validateInput()" />
                                <div class="invalid-feedback" id="error-message-price">Không được nhập quá 10 số</div>
                                {{-- <div class="invalid-feedback" id="error-message-pricenb">Chỉ được nhập số</div> --}}
                            </div>
                            <div class="pricesale">
                                <label for="exampleFormControlInput1" class="form-label">Giá giảm</label>
                                <input type="number" class="form-control" id="exampleFormControlInput1"
                                    placeholder="Nhập phần trăm giảm" min="0" max="100" value="0"
                                    name="discount" oninput="validateInput()" />
                                <div class="invalid-feedback" id="error-message-discount">Chỉ được nhập trong khoảng 0-100
                                </div>
                                <p class="desc">
                                    Lưu ý: Nhập phần trăm giảm. Ví dụ 30% = 30
                                </p>
                            </div>
                        </div>
                        <div class="form_product-quantity --same">
                            <label for="exampleFormControlInput1" class="form-label">Số lượng</label>
                            <input type="number" class="form-control" id="exampleFormControlInput1"
                                placeholder="Số lượng sản phẩm" min="0" required name="quantity"
                                oninput="validateInput()" />
                            <div class="invalid-feedback" id="error-message-quantity">Không được nhập quá 10 số</div>
                            <p class="desc">
                                Lưu ý: Số lượng được tính bằng kg (kilogram)
                            </p>
                        </div>
                        <div class="form_product-photo --same">
                            <label for="exampleFormControlInput1" class="form-label">Hình sản phẩm</label>
                            <input type="file" class="form-control" id="exampleFormControlInput1" name="photobig" />
                        </div>
                        <div class="form_product-thumnail --same">
                            <label for="exampleFormControlInput1" class="form-label">Hình nhỏ của sản phẩm</label>
                            <input type="file" class="form-control" id="exampleFormControlInput1" name="photomini[]"
                                multiple />
                            <p class="desc">
                                Lưu ý: Mục này dùng để tải hình nhỏ của sản phẩm để hiển thị
                                trong chi tiết sản phẩm, có thể chọn nhiều hình
                            </p>
                        </div>
                    </div>
                </div>
                <div class="box_right">
                    <div class="form_product-status">
                        <h4 class="title">Công bố</h4>
                        <div class="list_status">
                            <label>
                                <input type="radio" name="status" value="publish" checked />
                                <span class="text">Công bố</span>
                            </label>
                            <label>
                                <input type="radio" name="status" value="expected" />
                                <span class="text">Bản thảo</span>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary" id="btnproductsave" onclick="onclicksave()">
                            <i class="fa-solid fa-bookmark"></i>
                            <span>Lưu Thay Đổi</span>
                        </button>
                    </div>
                    <div class="form_product-category">
                        <h4 class="title">Danh Mục Sản Phẩm</h4>
                        <div class="list_category">
                            @foreach ($categories as $category)
                                <label>
                                    <input type="checkbox" name="categories[]" class="form-check-input"
                                        value="{{ $category->id }}" />
                                    <span class="name_category">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="form_product-outstand">
                        <h4 class="title">Sản phẩm nổi bật</h4>
                        <label>
                            <input type="checkbox" name="outstand" class="form-check-input" value="open" />
                            <span class="name_outstand">Bật tính năng</span>
                        </label>
                        <p class="text">
                            Lưu ý: Bật tính năng này sản phẩm sẽ được hiển thị ở mục sản
                            phẩm nổi bật
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        const onclicksave = () => {
            const btn = document.querySelector("#btnproductsave");
            btn.addEventListener('click', () => {
                btn.disabled = true;
            })
        }

        function validateInput() {
            let count = 0;
            // input
            const inputNameProduct = document.querySelector(
                'input[name="nameproduct"]'
            );
            const inputPriceProduct = document.querySelector('input[name="price"]');
            const inputQuantityProduct = document.querySelector(
                'input[name="quantity"]'
            );
            const inputDiscountProduct = document.querySelector(
                'input[name="discount"]'
            );
            // err message
            const errorNameProduct = document.getElementById("error-message-name");
            const errorPriceProduct = document.getElementById("error-message-price");
            // const errorPriceNBProduct = document.getElementById(
            //     "error-message-pricenb"
            // );
            const errorQuantityProduct = document.getElementById(
                "error-message-quantity"
            );
            const errorDiscountProduct = document.getElementById(
                "error-message-discount"
            );
            // input value
            const inputNameValue = inputNameProduct.value;
            const inputPriceValue = inputPriceProduct.value;
            const inputQuantityValue = inputQuantityProduct.value;
            const inputDiscountValue = inputDiscountProduct.value;
            // btnsave
            const btnproductsave = document.querySelector("#btnproductsave");

            inputNameValue.length > 255 ?
                handleBlock(errorNameProduct, inputNameProduct) :
                (handleNone(errorNameProduct, inputNameProduct), count++);

            inputPriceValue.length > 10 ?
                handleBlock(errorPriceProduct, inputPriceProduct) :
                (handleNone(errorPriceProduct, inputPriceProduct), count++);

            inputQuantityValue.length > 10 ?
                handleBlock(errorQuantityProduct, inputQuantityProduct) :
                (handleNone(errorQuantityProduct, inputQuantityProduct), count++);

            parseInt(inputDiscountValue, 10) > 100 ?
                handleBlock(errorDiscountProduct, inputDiscountProduct) :
                (handleNone(errorDiscountProduct, inputDiscountProduct), count++);

            // /[^0-9]/.test(inputPriceValue)
            //     ? handleBlock(errorPriceNBProduct, inputPriceProduct)
            //     : (handleNone(errorPriceNBProduct, inputPriceProduct), count++);
            count == 4 ?
                (btnproductsave.disabled = false) :
                (btnproductsave.disabled = true);
            // console.log(count);
        }

        const handleBlock = (err, inputName) => {
            err.style.display = "block";
            inputName.classList.add("is-invalid");
        };
        const handleNone = (err, inputName) => {
            err.style.display = "none";
            inputName.classList.remove("is-invalid");
        };
        
    </script>
@endsection
