    @include('layouts.partials.header')
    <!-- begin::Body -->
	<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3" id="m_login" style="background-image: url({{ asset('v2/assets/app/media/img//bg/bg-2.jpg')}});">
				<div class="m-grid__item m-grid__item--fluid m-login__wrapper">
					<div class="m-login__container">
						<div class="m-login__logo">
							<a href="#">
								<img src="{{ asset('images/logo_stg_telecom_white.png') }}">
							</a>
						</div>
						<div class="m-login__signin">
							<div class="m-login__head">
								<h3 class="m-login__title">Sign In</h3>
							</div>
							<form class="m-login__form m-form" method="POST" action="{{ route('login') }}">
								@csrf
								<div class="form-group m-form__group">
									<input class="form-control m-input {{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" placeholder="Your username" required autofocus>
									@if ($errors->has('username'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('username') }}</strong>
										</span>
									@endif
								</div>
								<div class="form-group m-form__group">
									<input id="password" class="form-control m-input m-login__form-input--last {{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" placeholder="Your secret password" required>
									@if ($errors->has('password'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
									@endif
								</div>
								<div class="row m-login__form-sub">
									<div class="col m--align-left m-login__form-left">
										<label class="m-checkbox  m-checkbox--light">
											<input type="checkbox" name="remember"> Remember me
											<span></span>
										</label>
									</div>
								</div>
								<div class="m-login__form-action">
									<button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">Sign In</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		@include('layouts.partials.header')
		<!--begin::Page Scripts -->
		{{--  <script src="../../../assets/snippets/custom/pages/user/login.js" type="text/javascript"></script>  --}}
		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>