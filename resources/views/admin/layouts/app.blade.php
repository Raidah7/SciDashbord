<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SciDashboard</title>
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logo.png')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{asset('admin/css/styles.min.css')}}" />
<link rel="stylesheet" href="{{asset('admin/css/custom.css')}}"/>
</head>

<body>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    @include('admin.layouts.sidebar')
    <div class="body-wrapper">
      @include('admin.layouts.head')
        <div class="container-fluid">
            @yield('content')
            <div class="py-6 px-6 text-center">
            </div>
        </div>
    </div>
</div>
@include('admin.layouts.foot')
</body>
</html>
