<?php

namespace App\Http\Controllers;

use App\Click;
use App\Http\Requests\SearchNewsletterClicks;
use App\Newsletter;
use App\Statistic;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function yearNewsletter($id){
        $slug = 'newsletters';
        \Session::forget('search_od');
        \Session::forget('search_do');
        $start_date = date('Y-m-d', strtotime('-1 year'));
        $end_date = Carbon::now();
        $newsletter = Newsletter::find($id);
        $statistics = Statistic::getLastYearNewsletter($id, $start_date, $end_date);
        $clicks =  Statistic::prepareLastYearNewsletter($statistics, $end_date->month);
        $sum = Click::where('newsletter_id', $newsletter->id)->whereBetween('created_at', [$start_date, $end_date])->count();
        $average = round($sum/12);
        $search = false; $month = $end_date->month;
        return view('admin.statistics.yearNewsletter', compact('clicks', 'newsletter', 'sum', 'average', 'search', 'start_date', 'end_date', 'month', 'slug'));
    }

    public function lastYearNewsletter($id){
        $slug = 'newsletters';
        \Session::forget('search_od');
        \Session::forget('search_do');
        $start_date = date('Y-m-d', strtotime('-2 year'));
        $end_date = date('Y-m-d', strtotime('-1 year'));
        $newsletter = Newsletter::find($id);
        $statistics = Statistic::getLastYearNewsletter($id, $start_date, $end_date);
        $clicks =  Statistic::prepareLastYearNewsletter($statistics, date("m",strtotime($end_date)));
        $sum = Click::where('newsletter_id', $newsletter->id)->whereBetween('created_at', [$start_date, $end_date])->count();
        $average = round($sum/12);
        $search = false; $month = date("m",strtotime($end_date));
        return view('admin.statistics.lastYearNewsletter', compact('clicks', 'newsletter', 'sum', 'average', 'search', 'start_date', 'end_date', 'month', 'slug'));
    }

    public function monthNewsletter($id){
        $slug = 'newsletters';
        \Session::forget('search_od');
        \Session::forget('search_do');
        $start_date = date('Y-m-d', strtotime('-1 month'));
        $end_date = Carbon::now();
        $start_date = Carbon::parse($start_date);

        $newsletter = Newsletter::find($id);
        $month = $start_date->month; $day = date('d');
        $statistics = Statistic::getLastMonthNewsletter($id, $start_date, $end_date);
        $clicks =  Statistic::prepareLastMonthNewsletter($statistics, $month, $day);
        $sum = Click::where('newsletter_id', $newsletter->id)->whereBetween('created_at', [$start_date, $end_date])->count();
        $days = Statistic::getDays($start_date->month);
        $average = round($sum/$days);
        $search = false;
        return view('admin.statistics.monthNewsletter', compact('clicks', 'newsletter', 'sum', 'average', 'days', 'search', 'start_date', 'end_date', 'day', 'slug'));
    }

    public function lastMonthNewsletter($id){
        $slug = 'newsletters';
        \Session::forget('search_od');
        \Session::forget('search_do');
        $start_date = date('Y-m-d', strtotime('-2 month'));
        $end_date = date('Y-m-d', strtotime('-1 month'));
        $start_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($end_date);
        $newsletter = Newsletter::find($id);
        $month = $start_date->month;
        $day = date('d');
        $statistics = Statistic::getLastMonthNewsletter($id, $start_date, $end_date);
        $clicks =  Statistic::prepareLastMonthNewsletter($statistics, $month, $day);
        $sum = Click::where('newsletter_id', $newsletter->id)->whereBetween('created_at', [$start_date, $end_date])->count();
        $days = Statistic::getDays($start_date->month);
        $average = round($sum/$days);
        $search = false;
        return view('admin.statistics.lastMonthNewsletter', compact('clicks', 'newsletter', 'sum', 'average', 'days', 'search', 'start_date', 'end_date', 'day', 'slug'));
    }

    public function dayNewsletter($id){
        $slug = 'newsletters';
        \Session::forget('search_od');
        \Session::forget('search_do');
        $start_date = date('Y-m-d H:m:s', strtotime('-1 day'));
        $end_date = Carbon::now();
        $start_date = Carbon::parse($start_date);
        $newsletter = Newsletter::find($id);
        $hour = $end_date->hour;
        $statistics = Statistic::getLastDayNewsletter($id, $start_date, $end_date);
        $clicks =  Statistic::prepareLastDayNewsletter($statistics, $hour);
        $sum = Click::where('newsletter_id', $newsletter->id)->whereBetween('created_at', [$start_date, $end_date])->count();
        $average = round($sum/24);
        $search = false;
        return view('admin.statistics.dayNewsletter', compact('clicks', 'newsletter', 'sum', 'average', 'search', 'start_date', 'end_date', 'hour', 'slug'));
    }

    public function lastDayNewsletter($id){
        $slug = 'newsletters';
        \Session::forget('search_od');
        \Session::forget('search_do');
        $start_date = date('Y-m-d H:m:s', strtotime('-2 day'));
        $end_date = date('Y-m-d H:m:s', strtotime('-1 day'));
        $start_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($end_date);
        $newsletter = Newsletter::find($id);
        $hour = $end_date->hour;
        $statistics = Statistic::getLastDayNewsletter($id, $start_date, $end_date);
        $clicks =  Statistic::prepareLastDayNewsletter($statistics, $hour);
        $sum = Click::where('newsletter_id', $newsletter->id)->whereBetween('created_at', [$start_date, $end_date])->count();
        $average = round($sum/24);
        $search = false;
        return view('admin.statistics.lastDayNewsletter', compact('clicks', 'newsletter', 'sum', 'average', 'search', 'start_date', 'end_date', 'hour', 'slug'));
    }

    public function searchNewsletter(SearchNewsletterClicks $request){
        $slug = 'newsletters';
        $start_date = $request->input('od');
        $end_date = $request->input('do');
        if(($start_date == '')){
            return redirect()->back()->with('error', 'Pogre�an opseg datuma!');
        }
        if(($end_date == '')){
            $end_date = Carbon::now();
        }
        $start_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($end_date);

        \Session::put('search_od', $start_date);
        \Session::put('search_do', $end_date);

        $newsletter = Newsletter::find($request->input('newsletter'));
        $difference = $start_date->diffInDays($end_date);
        $year = $end_date->year;
        $month = $end_date->month;
        $day = $end_date->day;
        $hour = $end_date->hour;
        if($difference < 1){
            $differenceInHours = $start_date->diffInHours($end_date); $differenceInHours++;
            $statistics = Statistic::getLastDayNewsletter($newsletter->id, $start_date, $end_date);
            $clicks =  Statistic::prepareSearchDayNewsletter($statistics, 'h', $start_date, $end_date);
            $sum = Click::where('newsletter_id', $newsletter->id)->whereBetween('created_at', [$start_date, $end_date])->count();

            $average = round($sum/$differenceInHours);
            $search = true;
            return view('admin.statistics.lastDaySearchNewsletter', compact('clicks', 'newsletter', 'sum', 'average', 'search', 'start_date', 'end_date', 'slug', 'year', 'month', 'day', 'hour'));
        }elseif($difference < 30){
            $differenceInDays = $start_date->diffInDays($end_date); $differenceInDays++;
            $month = $start_date->month;
            $statistics = Statistic::getLastMonthNewsletter($newsletter->id, $start_date, $end_date);
            $clicks =  Statistic::prepareSearchMonthNewsletter($statistics, 'd', $start_date, $end_date, $month);
            $sum = Click::where('newsletter_id', $newsletter->id)->whereBetween('created_at', [$start_date, $end_date])->count();

            $days = Statistic::getDays($month);
            $average = round($sum/$differenceInDays);
            $search = true;
            return view('admin.statistics.lastMonthSearchNewsletter', compact('clicks', 'newsletter', 'sum', 'average', 'days', 'search', 'start_date', 'end_date', 'slug', 'year', 'month', 'day', 'hour'));
        }elseif($difference < 365){
            $differenceInMonths = $start_date->diffInMonths($end_date); $differenceInMonths++;
            $statistics = Statistic::getLastYearNewsletter($newsletter->id, $start_date, $end_date);
            $clicks =  Statistic::prepareSearchYearNewsletter($statistics, $start_date, $end_date);
            $sum = Click::where('newsletter_id', $newsletter->id)->whereBetween('created_at', [$start_date, $end_date])->count();

            $average = round($sum/$differenceInMonths);
            $search = true;
            return view('admin.statistics.lastYearSearchNewsletter', compact('clicks', 'newsletter', 'sum', 'average', 'search', 'start_date', 'end_date', 'slug', 'year', 'month', 'day', 'hour'));
        }else{
            $differenceInYears = $start_date->diffInMonths($end_date); $differenceInYears++;
            $statistics = Statistic::getMoreYearNewsletter($newsletter->id, $start_date, $end_date);
            $clicks =  Statistic::prepareMoreYearNewsletter($statistics, $start_date, $end_date);
            $sum = Click::where('newsletter_id', $newsletter->id)->whereBetween('created_at', [$start_date, $end_date])->count();

            $average = round($sum/$differenceInYears);
            $search = true;
            return view('admin.statistics.lastMoreSearchNewsletter', compact('clicks', 'newsletter', 'sum', 'average', 'search', 'start_date', 'end_date', 'slug', 'year', 'month', 'day', 'hour'));
        }
    }

    public function searchSubscribers(Request $request){
        $slug = 'newsletters';
        $subscribers = Click::getNewsletterSubscriberClicks($request->input('newsletter'), $request->input('start'), $request->input('end'));
        $newsletter = Newsletter::find($request->input('newsletter'));
        return view('admin.statistics.newsletterSubscribers', compact('subscribers', 'newsletter'));
    }

    public function remove(){
        \Session::forget('search_od');
        \Session::forget('search_do');
        return redirect('admin/statistics/year');
    }

    public function removeNews($id){
        \Session::forget('search_od');
        \Session::forget('search_do');
        return redirect('admin/statistics/'.$id.'/yearNewsletter');
    }
}
