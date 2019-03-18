<!-- begin::Header -->
@include('layouts.partials.header')
<!-- end::Header -->
   <!-- begin::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- BEGIN: Top Header -->
			@include('layouts.partials.topbar')
			<!-- END: Top Header -->
			
			<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
				<!-- BEGIN: Left Aside -->
				@include('layouts.partials.sidebar')
				<!-- END: Left Aside -->
				<div class="m-grid__item m-grid__item--fluid m-wrapper">

					<!-- BEGIN: Subheader -->
					@yield('breadcrumb')
					<!-- END: Subheader -->
					<div class="m-content">
                        @yield('content')
                    </div>
				</div>
			</div>

			<!-- end:: Body -->
		</div>

		<!-- end:: Page -->

		<!-- begin::Scroll Top -->
		<div id="m_scroll_top" class="m-scroll-top">
			<i class="la la-arrow-up"></i>
		</div>
		<!-- end::Scroll Top -->

		@include('layouts.partials.footer')
	</body>

	<!-- end::Body -->
</html>