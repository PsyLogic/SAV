@extends('layouts.main')
@section('title','Dashboard')
@section('css')
<style>
    .bg-warning{
        background-color: #f17354!important;
    }
    .bg-warning2{
        background-color: #f48468!important;
    }
    .bg-warning3{
        background-color: #f9a48f!important;
    }
    .text-bold{
        font-weight: bold;
    }
    .bg-purple{
        background: linear-gradient(to right, #653fa7, #5b57be, #4d6cd2, #3a81e4, #2196f3);
    }
    .bg-blue{
        background: linear-gradient(to left, #653fa7, #5b57be, #4d6cd2, #3a81e4, #2196f3);
    }
</style>
@endsection
@section('content')
<h1 class="text-center text-uppercase">Dashboard</h1>
<!-- Charts For Softawre & Hardware Issues -->
<div class="row ">
    <div class="col-sm-12 col-lg-4 mt-5">
        <div class="card">
            <div class="card-header bg-warning text-white text-center text-bold">
                Diagnostic in Percent
            </div>
            <div class="card-body">
                <canvas id="pieChartSH"></canvas>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4 mt-5">
        <div class="card">
            <div class="card-header bg-warning2 text-white text-center text-bold">
                Total of each Diagnostic
            </div>
            <div class="card-body">
                <canvas id="barChartSH" style="width:100%;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4 mt-5">
        <div class="card">
            <div class="card-header bg-warning3 text-white text-center text-bold">
                Statistics Summary 
            </div>
            <div class="card-body">
                <div class="row ">
                    <div class="col-lg-6 mt-4 mb-4">
                        <div class="d-flex border">
                            <div class="bg-primary text-light p-4">
                                <div class="d-flex align-items-center h-100">
                                    <i class="fas fa-3x fa-fw fa-ticket-alt"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 bg-white p-4">
                                <p class="text-uppercase m--font-primary mb-0">Requests</p>
                                <h3 class="font-weight-bold mb-0" id="request"></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4 mb-4">
                        <div class="d-flex border">
                            <div class="bg-danger text-light p-4">
                                <div class="d-flex align-items-center h-100">
                                    <i class="fa fa-3x fa-fw fa-briefcase-medical"></i>
                                    <!-- <i class="fa fa-3x fa-fw fa-eye-slash"></i> -->
                                </div>
                            </div>
                            <div class="flex-grow-1 bg-white p-4">
                                <p class="text-uppercase m--font-primary mb-0">Opened</p>
                                <h3 class="font-weight-bold mb-0" id="opened"></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="d-flex border">
                            <div class="bg-warning text-light p-4">
                                <div class="d-flex align-items-center h-100">
                                    <i class="fa fa-3x fa-fw fa-cog fa-spin"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 bg-white p-4">
                                <p class="text-uppercase m--font-primary mb-0">In Process</p>
                                <h3 class="font-weight-bold mb-0" id="process"></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="d-flex border">
                            <div class="bg-success text-light p-4">
                                <div class="d-flex align-items-center h-100">
                                    <i class="fa fa-3x fa-fw fa-thumbs-up"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 bg-white p-4">
                                <p class="text-uppercase m--font-primary mb-0">Fixed</p>
                                <h3 class="font-weight-bold mb-0" id="closed"></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts For Models -->
<div class="row mt-5">
    <div class="col-xs-12 col-lg-4">
        <div class="card">
            <div class="card-header bg-purple text-white text-center text-bold">
                Pie chart for each Model in Percent
            </div>
            <div class="card-body">
                <canvas id="pieChartModel"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-lg-4">
        <div class="card">
            <div class="card-header bg-blue text-white text-center text-bold">
                Total broken Smartphones by Model
            </div>
            <div class="card-body">
                <canvas id="barChartModel"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-lg-4">
        <div class="card">
            <div class="card-header bg-blue text-white text-bold text-left">
                Count of <i>Problems</i> by <i>Model</i>
                <select name="models" id="pmodels" class="float-right col-4" style="border-radius:5px;">
                    <option value="none">Select Model</option>
                </select>
            </div>
            <div class="card-body">
                <canvas id="barChartPModel"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script src="{{asset('js/app/dashboard.js')}}"></script>
@stop
