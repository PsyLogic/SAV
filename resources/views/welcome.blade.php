@extends('layouts.main')
@section('content')
    <div class="row justify-content-center">
        <div class="col-5">
            <div class="card">
                <h5 class="card-header text-center text-uppercase">Smartphone Informations</h5>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="imei" class="col-sm-2">IMEI</label>
                        <input type="text" class="form-control col-sm-6" id="imei" a placeholder="X X X X X X X X X X X X"> 
                        &nbsp;<button type="submit" class="btn btn-primary  col-sm-3">Check</button>
                    </div>
                    <div class="form-group row">
                        <label for="staticModel" class="col-sm-2 col-form-label">Model</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="staticModel" value="email@example.com">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-5">
            <div class="card">
                <h5 class="card-header text-center text-uppercase">Smartphone Pictures</h5>
                <form action="">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="imei" class="col-sm-2">IMEI</label>
                            <input type="text" class="form-control col-sm-6" id="imei" a placeholder="X X X X X X X X X X X X"> 
                            &nbsp;<button type="submit" class="btn btn-primary  col-sm-3">Check</button>
                        </div>
                        <div class="form-group row">
                            <label for="staticModel" class="col-sm-2 col-form-label">Model</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="staticModel" value="email@example.com">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary float-right ">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    $(ducument).ready(function(){



    });
</script>
@stop