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
    // window.print();
</script>
</html>
