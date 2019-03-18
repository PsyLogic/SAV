<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>SAV - @yield('title')</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
            google: {"families":["Montserrat:500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>

		<!--end::Web font -->

		<link href="{{ asset('v2/vendors/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('v2/vendors/vendors/line-awesome/css/line-awesome.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('v2/vendors/vendors/flaticon/css/flaticon.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('v2/vendors/vendors/metronic/css/styles.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('v2/vendors/vendors/fontawesome5/css/all.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('v2/assets/app/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
        <link href="//cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css" rel="stylesheet" />
		<style>
			input,select,.btn-light{
				border-color: #bdbdbd !important;
			}
			.m-portlet__head-label {
				width: max-content;
			}
			.m-page--wide .m-header, .m-page--fluid .m-header {
				background-color: #2d2e3e;
			}
		</style>
		
		@yield('css')
		<link rel="shortcut icon" href="{{ asset('favicon.png') }}"  type="image/x-icon" />
	</head>

	<!-- end::Head -->