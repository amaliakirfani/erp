<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> ERP | @yield('title')</title>

    @include("layouts.global_css")
    @include('layouts.components.loader')
    @stack('css')
</head>

<body>
<div id="app">
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header">
                <div class="d-flex justify-content-between">
                    <div class="logo">
                        <a href="index.html"><img src="/assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                    </div>
                    <div class="toggler">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
            @include("layouts.sidebar")
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            @if(session('error') || session('success'))
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-{{ session('error') ? 'danger' : 'success' }} alert-dismissible fade show"
                             role="alert">
                            @if (session('error'))
                                <strong>Error!</strong> {!! session('error') !!}
                            @elseif (session('success'))
                                <strong>Berhasil!</strong> {!! session('success') !!}
                            @endif
{{--                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--                                <span aria-hidden="true">&times;</span>--}}
{{--                            </button>--}}
                        </div>
                    </div>
                </div>
            @endif
            <h3>@yield("page-heading")</h3>
        </div>
        <div class="page-content">
            @yield("content")
        </div>

        <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p>2021 &copy; Mazer</p>
                </div>
                <div class="float-end">
                    <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                            href="http://ahmadsaugi.com">A. Saugi</a></p>
                </div>
            </div>
        </footer>
    </div>
</div>

@include("layouts.global_js")
@stack("js")
</body>

</html>
