@extends('layouts.main')
@section('title','Timeline of Request')
@section('css')
<link rel="stylesheet" href="{{ asset('css/app/issue_details.css')}}">
<link rel="stylesheet" href="{{ asset('css/popup.css')}}">
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-10">
        <div class="main-timeline">
            {{-- Stage 1 --}}
            <div class="timeline">
                <span class="timeline-icon"></span>
                <span class="year">{{ $issue->french_format($issue->delivered_at) }}</span>
                <div class="timeline-content">
                    <span class="icon far fa-envelope"></span> 
                    <h3 class="title">Issue Delivered</h3>
                    <p class="description">
                        <div class="card" >
                                <div class="card-header text-center text-uppercase bg-info text-white">
                                    More Information
                                </div>
                                <div class="card-body">
                                    <b>Issue Delivered From: </b> <span class="">{{$issue->commercial->full_name}}</span>
                                </div>
                        </div>
                    </p>
                </div>
            </div>
            {{-- End Stage 1 --}}

            {{-- Stage 2 --}}
            @if($issue->stage > 1)
            <div class="timeline">
                <span class="timeline-icon"></span>
                <span class="year">{{$issue->french_format($issue->received_at)}}</span>
                <div class="timeline-content">
                    <span class="icon far fa-envelope-open"></span>
                    <h3 class="title">Issue Received</h3>
                    <p class="description">
                        Issue received and verified also init pictures are token <br>
                        <div class="card" >
                            <div class="card-header text-center text-uppercase bg-danger text-white">
                                More Information
                            </div>
                            <div class="card-body">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>Responsable</th>
                                            <td><span class="badge-pill  ">{{$issue->user->name}}</span></td>
                                        </tr>
                                            <th>IMEI</th>
                                            <td><span class="badge-pill  ">{{ $issue->imei }}</span></td>
                                        </tr>
                                            <th>Pictures</th>
                                            <td><button class="btn btn-sm btn-danger info" data-status="before" data-id="{{ $issue->id }}">show</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </p>
                </div>
            </div>
            @endif
            {{-- End Stage 2 --}}

            {{-- Stage 3 --}}
            @if($issue->stage == 3)
            <div class="timeline">
                <span class="timeline-icon"></span>
                <span class="year">{{$issue->french_format($issue->closed_at)}}</span>
                <div class="timeline-content">
                        <span class="icon fas fa-wrench"></span> 
                    <h3 class="title">Issue Resolved</h3>
                    <p class="description">
                        Issue resolved and final pictures are token also the phone is returned back <br>
                        {{-- IMEI : <span class="badge-pill success">123456789123456</span><br>
                        Main Issue : <span class="badge-pill success">The Camera was broken</span><br>
                        Solution: <span class="badge-pill success">Replaced by new one</span><br>
                        Fees: <span class="badge-pill success">0 DH</span><br>
                        Pictures : <button class="btn btn-sm success" >show</button><br> --}}
                        <div class="card" >
                            <div class="card-header text-center text-uppercase bg-success text-white">
                                More Information
                            </div>
                            <div class="card-body">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>IMEI</th>
                                            <td><span class="badge-pill ">{{ $issue->imei }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Main Issue</th>
                                            <td>
                                                <span class="badge-pill ">{{ $issue->diagnostic }}</span><br>
                                            </td>
                                        </tr>
                                        @if(count($issue->problems))
                                        <tr>
                                            <th>Problems found</th>
                                            <td>
                                                @foreach($issue->problems as $problem)
                                                <span class="badge-pill ">{{ $problem->content }}</span><br>
                                                @endforeach
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>Solution</th>
                                            <td>
                                                @foreach ($issue->solutions as $soution)
                                                <span class="badge-pill ">{{ $soution->content }}</span><br>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Pictures</th>
                                            <td><button class="btn btn-sm btn-success info" data-status='after' data-id="{{ $issue->id }}">show</button></td>
                                        </tr>
                                        <tr>
                                            <th>Fees</th>
                                            <td><span class="badge-pill ">{{ $issue->charges }} DH</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </p>
                </div>
            </div>
            @endif
            {{-- End Stage 3 --}}
            
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="images-modal" tabindex="-1" role="dialog" aria-labelledby="images-modal" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="images-modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="popup-gallery">
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="{{ asset('js/popup.js')}}"></script>
<script src="{{ asset('js/app/issue_details.js') }}"></script>
@stop