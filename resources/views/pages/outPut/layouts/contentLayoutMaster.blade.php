<?php
    /**
     * Created by PhpStorm.
     * User: shaun
     * Date: 2020/5/22
     * Time: 11:14
     */
?>
    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title></title>
    @if($pdf)
        <link rel="stylesheet" href="{{ public_path('css/pages/output.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/pages/output.css') }}">
    @endif
</head>
<body>
<div class='dist'></div>
<div class="book" id="app">
    @yield('page')
</div>

</body>
@yield('script')
<script type='text/javascript'>
    window.print();
</script>
{{--<script--}}
{{--    src="https://code.jquery.com/jquery-3.5.1.min.js"--}}
{{--    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="--}}
{{--    crossorigin="anonymous"></script>--}}
</html>
