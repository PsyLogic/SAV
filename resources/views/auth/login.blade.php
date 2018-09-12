@include('layouts.partials.header')
<style>
    html{
        padding: 0;
        margin: 0;
    }
    
    body{
        background: rgb(25,181,254);
        background: linear-gradient(180deg, rgba(25,181,254,1) 1%, rgba(255,255,255,1) 100%);
    }

    .container{
        width: 100%;
        min-height: 100vh;
        align-items: center;
        margin: auto;
    }
    .login{
        background-color: #fff;
        padding: 25px;
        width: 350px;
        min-height: 400px;
        font-size: 14px;
        border-radius: 7px;
    }
    .logo{
        padding: 15px;
        text-align: center;
    }

    label{
        font-weight: bold;
    }
    .form-group{
        padding-bottom: 20px;
    }
</style>
<div class="row justify-content-center container">
    <div class="login">
        <div class="row">
            <div class="col-12 logo">
                <img src="{{ asset('images/logo_stg_telecom.png') }} " alt="STG TELECOM">
            </div>
            <div class="col-12">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" placeholder="Your username" required autofocus>
                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Your secret password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group text-center" >
                        <button type="submit" class="btn btn-info btn-lg">Authenticate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('layouts.partials.footer')