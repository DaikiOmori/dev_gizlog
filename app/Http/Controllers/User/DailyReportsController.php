<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\DailyReportRequest;
use App\Models\DailyReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

const MAX_PAGE_COUNT = 30;


class DailyReportsController extends Controller
{

    protected $dailyreport;

    public function __construct(DailyReport $dailyreport)
    {
        $this->middleware('auth');
        $this->dailyreport = $dailyreport;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inputs = $request->all();
        if (array_key_exists('search_word', $inputs)) {
            $dailyreports = $this->dailyreport->fetchSearchingReport($inputs)->paginate(MAX_PAGE_COUNT);
        } else {
            $dailyreports = $this->dailyreport->orderby('created_at', 'asc')->paginate(MAX_PAGE_COUNT);
        }
        return view('user.daily_report.index', compact('dailyreports', 'inputs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.daily_report.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DailyReportRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $this->dailyreport->fill($input)->save();
        return redirect()->route('daily_report.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$dailyreport = $this->dailyreport->find($id);
        $dailyreport = $this->dailyreport->find($id);
        //dd($dailyreport);
        $a = compact('dailyreport');
        
        return view('user.daily_report.show', compact('dailyreport'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dailyreport = $this->dailyreport->find($id);
        return view('user.daily_report.edit',compact('dailyreport'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DailyReportRequest $request, $id)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $this->dailyreport->find($id)->fill($input)->save();
        return redirect()->route('daily_report.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $dailyreport = DailyReport::find($id);
      $dailyreport->delete();
      return redirect()->route('daily_report.index');
    }
}