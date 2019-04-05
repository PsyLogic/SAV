<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Commercial;
use Illuminate\Http\Request;
use App\Http\Services\IssueService;
use App\Http\Requests\Issue\StoreIssueRequest;
use App\Http\Requests\Issue\UpdateIssueRequest;
use App\Http\Requests\Issue\FinalUpdateIssueRequest;
use App\Http\Requests\Issue\FetchClientRequest;
use App\Http\Requests\Issue\UpdateClientRequest;

class IssueController extends Controller
{
    protected $issue_service;

    public function __construct(IssueService $issue_service)
    {
        $this->middleware('auth');
        $this->issue_service = $issue_service;
    }

    /**
     * Display a listing of the issues.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('issue.index', $this->issue_service->home());
    }

    /**
     * Return list of issues with ajax
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request){
        return $this->issue_service->getList($request);
    }

    /**
     * Show the form for creating a new issue.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('issue.create',['commercials' => Commercial::all()]);
    }

    /**
     * Store a newly created issue     
     *
     * @param StoreIssueRequest $request
     * @return void
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIssueRequest $request)
    {
        return $this->issue_service->add($request);
    }

    /**
     * Display the specified issue.
     *
     * @param Issue $issue
     * @return \Illuminate\Http\Response
     */
     public function show(Issue $issue)
    {
        return view('issue.details',compact('issue'));
    }

    /**
     * update issue to 2nd stage
     *
     * @param UpdateIssueRequest $request
     * @param Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIssueRequest $request, Issue $issue)
    {
        return $this->issue_service->update($request, $issue);
    }

    /**
     * Update the issue to 3rd stage (final stage).
     *
     * @param FinalUpdateIssueRequest $request
     * @param Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function finalUpdate(FinalUpdateIssueRequest $request, Issue $issue)
    {
        return $this->issue_service->finalUpdate($request,$issue);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Issue $issue)
    {
        return $request->ajax() ? response()->json($issue->delete()) : abort(403);;
    }

    /**
     * Get Images of given Issue.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function images(Request $request)
    {
        return $this->issue_service->getImages($request);
    }

    /**
     * return Report of the request issue
     *
     * @param Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function report(Issue $issue){
        return view('issue.report', compact('issue'));
    }

    public function getClientInfo(FetchClientRequest $request){
        return $this->issue_service->getClientBy($request);
    }

    public function setClientInfo(UpdateClientRequest $request, $imei){
        return $this->issue_service->updateClientInfo($request, $imei);
    }
}
