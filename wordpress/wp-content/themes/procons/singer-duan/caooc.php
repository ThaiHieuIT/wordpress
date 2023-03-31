<?php

/**
 * Template name: cao oc
 */

get_header();
?>
<style>
    .bg-banner-caooc {
        background-image: url(https://procons.com.vn/wp-content/uploads/2022/10/banner1-scaled.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        background-position-y: -400px;
        height: 510px;
        width: 100%;
        position: relative;
        padding: 0;
    }

    .overlay {
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: #0009804D;
    }

    .sesscion-link {
        background-color: #282a56;
        margin-bottom: 20px;
    }

    .sesscion-link ul {
        line-height: 52px;
        margin: 0;
    }

    .sesscion-link ul li {
        display: inline-block;
        margin-right: 20px;
    }

    .sesscion-link ul li a {
        font-size: 13px;
        font-weight: 500;
        font-family: "Bai Jamjuree", sans-serif;
        text-decoration: none;
        color: #fff;
    }

    .sesscion-link ul li:hover a {
        color: #ffa600;
    }

    /* item dự án */
    .box-item-duan {
        margin: 10px 0;
        border: 1px solid #ccc;
    }

    .box-item-duan .col-4 {
        padding: 0;
    }

    .box-item-duan p {
        font-size: 15px;
        font-weight: 400;
        color: #000;
    }

    .box-title-link {
        margin: 20px 0;
    }

    .title-link {
        font-size: 25px;
        font-family: "Bai Jamjuree", sans-serif;
        font-weight: 600;
        color: #0170B9 !important;
        text-decoration: none;
    }

    .box-item-duan .xemchitiet {
        color: #ffcc3f;
        transition: all 1s;
    }

    .box-item-duan .xemchitiet:hover {
        color: #ffa600;
        font-size: 20px;
    }
</style>
<div class="banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 bg-banner-caooc">
                <div class="overlay"></div>
                <div class="title-banner">
                    <h1>CAO ỐC, VĂN PHÒNG</h1>
                    <p><a href="http://localhost/wordpress/">Home</a> >> Dự Án >> Cao ốc, Văn phòng</p>
                </div>
            </div>
            <div class="col-12 sesscion-link">
                <div class="container">
                    <div class="row">
                        <ul>
                            <li class="link-singer">
                                <a class="link-singer" href="http://localhost/wordpress/du-an/khu-dan-cu/">KHU DÂN CƯ</a>
                            </li>
                            <li class="link-singer">
                                <a class="link-singer" href="http://localhost/wordpress/du-an/cao-oc-van-phong/">CAO ỐC, VĂN PHÒNG</a>

                            </li>
                            <li class="link-singer">
                                <a class="link-singer" href="http://localhost/wordpress/du-an/biet-thu-nha-pho/">BIỆT THỰ, NHÀ PHỐ</a>

                            </li>
                            <li class="link-singer">
                                <a class="link-singer" href="http://localhost/wordpress/du-an/ha-tang/">HẠ TẦNG</a>

                            </li>
                            <li class="link-singer">
                                <a class="link-singer" href="http://localhost/wordpress/du-an/cong-nghiep/">CÔNG NGHIỆP</a>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 box-item-duan">
            <div class="row">
                <div class="col-4">
                    <img src="https://procons.com.vn/wp-content/uploads/2022/10/vanphong5.jpg" alt="">
                </div>

                <div class="col-8">
                    <div class="box-title-link">
                        <a class="title-link" href="">CẢI TẠO VĂN PHÒNG SABECO</a>

                    </div>
                    <p>
                        Quy mô: Diện tích 3500m2, gồm 22 căn nhà liên kề. <br>
                        Vị trí: Đồng Nai. <br>
                        Phạm vi công việc: Thiết kế, thi công hạ tầng, nhà mẫu.
                    </p>
                    <a class="xemchitiet" href="">Xem Chi Tiết -></a>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
get_footer();
