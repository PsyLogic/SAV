@extends('layouts.main')
@section('title', 'List of Requests')
{{--  @section('breadcrumb')
    @breadcrumb(['title' => 'Issues'])
        List of issues
    @endbreadcrumb    
@endsection  --}}
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
    td,th{
        text-align: center;
        font-size:16px;
        padding: 0.3rem;
    }
    @media print {
        .btn-togg { display: none !important; } 
    }
</style>
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-12">
        <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg m-portlet--bordered">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="fa fa-cogs"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            List of issues
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="row justify-content-center toggle-buttons"></div>
                <table class="table table-striped table-bordered table-hover display compact dt-responsive" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">Created at</th>
                        <th scope="col">Model</th>
                        <th scope="col">IMEI</th>
                        <th scope="col">Owner</th>
                        <th scope="col">Commercial</th>
                        <th scope="col">SAV</th>
                        <th scope="col">Request</th>
                        <th scope="col">Diagnostic</th>
                        <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($issues as $issue)
                        <tr id="row{{ $issue->id }}">
                            {{-- <th scope="row">{{ $loop->iteration }}</th> --}}
                            <td>{{ $issue->delivered_at }}</td>
                            <td scope="row">{{ $issue->client['model'] }}</td>
                            <td>{{ $issue->imei ?? '999999999999999' }}</td>
                            <td class="text-center">
                                <a tabindex="0" class="btn btn-sm text-left float-left btn-togg" role="button" data-toggle="m-tooltip" data-placement="top"  title="{{ $issue->client['tel'] }}"><i class="fas fa-info-circle"></i></a>{{ $issue->client['full_name'] }}
                            </td>
                            <td class="text-center">
                                <a tabindex="0" class="btn btn-sm float-left btn-togg" role="button" data-toggle="m-tooltip" data-placement="top"  title="{{ $issue->commercial->phone }}"><i class="fas fa-info-circle"></i></a>{{ $issue->commercial->full_name }}
                            </td>
                            <td>{{ $issue->user->name ?? 'Not Assigned' }}</td>
                            <td>{!! $issue->stage() !!}</td>
                            <td>{{ $issue->diagnostic ?? '----'}}</td>
                            <td>
                                <div class="btn-group">
                                    @if ($issue->stage == 1)
                                        <button type="button" class="btn btn-metal btn-sm btn-fix" data-stage="{{ $issue->stage }}" data-id="{{$issue->id}}" title="Fix"><i class="fas fa-wrench"></i></button>
                                    @endif
                                    @if($issue->stage == 2)
                                        <button type="button" class="btn btn-metal btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-wrench"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item btn-fix" href="#" data-stage="{{ $issue->stage }}" data-id="{{$issue->id}}" title="software" >Software</a>
                                            <a class="dropdown-item btn-fix" href="#" data-stage="{{ $issue->stage }}" data-id="{{$issue->id}}" title="hardware" >Hardware</a>
                                        </div>
                                    @endif
                                    &nbsp;
                                    <a href="{{ route('issues.details',$issue->id) }}" class="btn btn-primary btn-sm" data-id="{{$issue->id}}" title="Details">&nbsp;<i class="fas fa-info"></i>&nbsp;</a>
                                    &nbsp;
                                    @if ($issue->stage == 3)
                                    <a href="{{ route('issues.report',$issue->id) }}" target="_blank" class="btn btn-warning btn-sm" data-id="{{$issue->id}}" title="Report"><i class="fas fa-print"></i></a>
                                    @endif
                                    @if(auth()->user()->isAdmin)
                                    <a href="#" class="btn btn-danger btn-sm btn-del" data-id="{{$issue->id}}" title="Delete"><i class="fas fa-times"></i></a>
                                        @if ($issue->stage == 3)
                                        <button class="btn btn-info btn-sm correct-issue" data-id="{{$issue->id}}" title="Correct issue Details"><i class="fas fa-undo"></i></button>
                                        @endif
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
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

<script src="{{ asset('js/app/issues.js') }}"></script>
@stop