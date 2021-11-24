<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="{{ URL::to('/')}}">
		<meta charset="utf-8" />
		<title>Arabic Learning</title>
		<meta name="description" content="Metronic admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="https://keenthemes.com/metronic" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendors Styles(used by this page)-->
		<link href="{{ asset('public/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="{{ asset('public/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('public/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('public/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="{{ asset('public/css/themes/layout/header/base/light.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('public/css/themes/layout/header/menu/light.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('public/css/themes/layout/brand/dark.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('public/css/themes/layout/aside/dark.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		@yield('page_css')
	    <script>
	        var APP_URL = {!! json_encode(url('/')) !!}
	    </script>
	    <style type="text/css">
	    	.addmoreanswer, .removethisanswer { font-size: 22px; font-weight: bold; cursor: pointer; }
	    </style>
	</head>