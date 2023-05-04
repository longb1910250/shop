<?php

namespace App\Http\Controllers;

use App\Models\Statistical;
use App\Models\Vistors;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use LDAP\Result;

class StaticticalController extends Controller
{
    //
    public function statistical()
    {
        $this->is_login();
        //  Số truy cập trong tháng trước
        $start_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $end_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $visitor_last_month = Vistors::whereBetween('date_visit', [$start_last_month, $end_last_month])->get();

        $total_last_month = 0;
        foreach ($visitor_last_month as $visitor) {
            $total_last_month += $visitor->access_times;
        }

        // Số truy cập tháng này
        $start_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $visitor_this_month = Vistors::whereBetween('date_visit', [$start_this_month, $now])->get();
        $total_this_month = 0;
        foreach ($visitor_this_month as $visitor) {
            $total_this_month += $visitor->access_times_in_month;
        }

        // Số truy cập trong 1 năm qua
        $one_year = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        $visitor_last_year = Vistors::whereBetween('date_visit', [$one_year, $now])->get();

        $total_last_year = 0;
        foreach ($visitor_last_year as $visitor) {
            $total_last_year += $visitor->access_times;
        }

        // Tổng truy cập
        $all_user_access = Vistors::all();
        $count_all = 0;
        foreach ($all_user_access as $user) {
            $count_all += $user->access_times;
        }

        return view('admin.statistical.statistical')
            ->with('count_all', $count_all)
            ->with('total_last_month', $total_last_month)
            ->with('total_this_month', $total_this_month)
            ->with('total_last_year', $total_last_year);
    }

    public function filter_day(Request $request)
    {
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $get = Statistical::whereBetween('order_date', [$from_date, $to_date])->orderBy('order_date', 'ASC')->get();

        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->qty,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function filter_statistic(Request $request)
    {
        $data = $request->all();
        $past7day = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        $past365day = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        $startthismonth = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $startlastmonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $endlastmonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if ($data['filter_val'] == '7day') {
            $get = Statistical::whereBetween('order_date', [$past7day, $now])->orderBy('order_date', 'ASC')->get();
        } else if ($data['filter_val'] == 'thismonth') {
            $get = Statistical::whereBetween('order_date', [$startthismonth, $now])->orderBy('order_date', 'ASC')->get();
        } else if ($data['filter_val'] == 'lastmonth') {
            $get = Statistical::whereBetween('order_date', [$startlastmonth, $endlastmonth])->orderBy('order_date', 'ASC')->get();
        } else {
            $get = Statistical::whereBetween('order_date', [$past365day, $now])->orderBy('order_date', 'ASC')->get();
        }
        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->qty,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function filter_30_day_auto()
    {
        $sub30day = Carbon::now('Asia/Ho_Chi_Minh')->subDays(30)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = Statistical::whereBetween('order_date', [$sub30day, $now])->orderBy('order_date', 'ASC')->get();


        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->qty,
            );
        }
        echo $data = json_encode($chart_data);
    }
}
