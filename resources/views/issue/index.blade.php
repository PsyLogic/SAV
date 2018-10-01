@extends('layouts.main')
@section('title', 'List of Requests')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
    td,th{
        text-align: center;
        font-size:16px;
    }
</style>
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <h5 class="card-header text-center text-uppercase">List of request reparations</h5>
            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">IMEI</th>
                        <th scope="col">Commercial Agent</th>
                        <th scope="col">SAV Agent</th>
                        <th scope="col">Request</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse($issues as $issue)
                        <tr id="row{{ $issue->id }}">
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $issue->imei ?? '999999999999999' }}</td>
                            <td>{{ $issue->commercial->full_name }}</td>
                            <td>{{ $issue->user->name ?? 'Not Assigned' }}</td>
                            <td>{!! $issue->stage() !!}</td>
                            <td>
                                <div class="btn-group">
                                    @if ($issue->stage == 1)
                                        <button type="button" class="btn btn-secondary btn-md btn-fix" data-stage="{{ $issue->stage }}" data-id="{{$issue->id}}" title="Fix"><i class="fas fa-wrench"></i></button>
                                    @endif
                                    @if($issue->stage == 2)
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                           <i class="fas fa-wrench"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item btn-fix" href="#" data-stage="{{ $issue->stage }}" data-id="{{$issue->id}}" title="software" >Software</a>
                                            <a class="dropdown-item btn-fix" href="#" data-stage="{{ $issue->stage }}" data-id="{{$issue->id}}" title="hardware" >Hardware</a>
                                        </div>
                                    @endif
                                    &nbsp;
                                    <a href="{{ route('issues.details',$issue->id) }}" class="btn btn-info btn-md" data-id="{{$issue->id}}" title="Details"><i class="fas fa-info-circle"></i></a>
                                    &nbsp;
                                    @if ($issue->stage == 3)
                                    <a href="{{ route('issues.report',$issue->id) }}" target="_blank" class="btn btn-success btn-md" data-id="{{$issue->id}}" title="Report"><i class="fas fa-print"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><th scope="row" class="text-center text-danger" colspan="6">No data is Available</th></tr>
                        @endforelse
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>

@isset($issue)
@include('issue.stages')
@endisset

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="{{ asset('js/app/issues.js') }}"></script>
@stop