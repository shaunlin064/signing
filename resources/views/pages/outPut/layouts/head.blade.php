<?php
    /**
     * Created by PhpStorm.
     * User: shaun
     * Date: 2020/5/26
     * Time: 12:05
     */
?>
<div class='header'>
    <div class='logo'>
        <div class='img-container'>
            @if($pdf)
                <img src='{{public_path("images/logo/js_logo.png")}}' alt=''>
            @else
                <img src='{{asset("images/logo/js_logo.png")}}' alt=''>
            @endif
        </div>
    </div>
    <div class='form-title text-center'>
        <h1 class='title'>{{$config['name']}}</h1>
        <p class='date text-right'>申請日期：{{date('Y/m/d', strtotime($signing['created_at']))}}</p>
    </div>
</div>
