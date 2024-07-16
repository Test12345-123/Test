<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\LogActivity;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $todaySold = $this->getTodaySoldItemsCount();

        $yesterdaySold = $this->getYesterdaySoldItemsCount();

        $difference = $todaySold - $yesterdaySold;

        $thisMonthSold = $this->getThisMonthSoldItemsCount();

        $lastMonthSold = $this->getLastMonthSoldItemsCount();

        $differenceLastMonth = $thisMonthSold - $lastMonthSold;

        $todayRevenue = $this->getTodayRevenue();

        $yesterdayRevenue = $this->getYesterdayRevenue();
        
        $revenueDifferenceToday = $todayRevenue - $yesterdayRevenue;

        $thisMonthRevenue = $this->getThisMonthRevenue();

        $lastMonthRevenue = $this->getLastMonthRevenue();

        $revenueDifferenceThisMonth = $thisMonthRevenue - $lastMonthRevenue;

        $todayOrders = $this->getTodayOrders();

        $yesterdayOrders = $this->getYesterdayOrders();

        $orderDifferenceToday = $todayOrders - $yesterdayOrders;

        $thisMonthOrders = $this->getThisMonthOrders();

        $lastMonthOrders = $this->getLastMonthOrders();

        $orderDifferenceThisMonth = $thisMonthOrders - $lastMonthOrders;

        $logActivities = LogActivity::orderBy('created_at', 'desc')->take(6)->get();

        return view('pages.index', [
            'todaySold' => $todaySold,
            'difference' => $difference,
            'thisMonthSold' => $thisMonthSold,
            'differenceLastMonth' => $differenceLastMonth,
            'todayRevenue' => $todayRevenue,
            'revenueDifferenceToday' => $revenueDifferenceToday,
            'thisMonthRevenue' => $thisMonthRevenue,
            'revenueDifferenceThisMonth' => $revenueDifferenceThisMonth,
            'todayOrders' => $todayOrders,
            'orderDifferenceToday' => $orderDifferenceToday,
            'thisMonthOrders' => $thisMonthOrders,
            'orderDifferenceThisMonth' => $orderDifferenceThisMonth,
            'logActivities' => $logActivities,
        ]);
    }

    public function getTodaySoldItemsCount()
    {
        $today = Carbon::now()->toDateString();
        $todayOrders = Order::whereDate('created_at', $today)->get();
        $totalQty = $this->calculateTotalQty($todayOrders);
        return $totalQty;
    }

    public function getYesterdaySoldItemsCount()
    {
        $yesterday = Carbon::yesterday('Asia/Jakarta')->toDateString();
        $yesterdayOrders = Order::whereDate('created_at', $yesterday)->get();
        $totalQty = $this->calculateTotalQty($yesterdayOrders);
        return $totalQty;
    }

    public function getThisMonthSoldItemsCount()
    {
        $firstDayOfMonth = now()->startOfMonth();
        $thisMonthOrders = Order::where('created_at', '>=', $firstDayOfMonth)->get();
        $totalQty = $this->calculateTotalQty($thisMonthOrders);
        return $totalQty;
    }

    public function getLastMonthSoldItemsCount()
    {
        $firstDayOfLastMonth = now()->startOfMonth()->subMonth();
        $lastDayOfLastMonth = now()->startOfMonth()->subDay();
        $lastMonthOrders = Order::whereBetween('created_at', [$firstDayOfLastMonth, $lastDayOfLastMonth])->get();
        $totalQty = $this->calculateTotalQty($lastMonthOrders);
        return $totalQty;
    }

    public function getTodayRevenue()
    {
        $today = Carbon::now()->toDateString();
        $todayRevenue = Order::whereDate('created_at', [$today])->sum('total');

        return $todayRevenue;
    }

    public function getYesterdayRevenue()
    {
        $yesterday = Carbon::yesterday()->toDateString();
        $yesterdayRevenue = Order::whereDate('created_at', [$yesterday])->sum('total');

        return $yesterdayRevenue;
    }

    public function getThisMonthRevenue()
    {
        $firstDayOfMonth = now()->startOfMonth();
        $thisMonthRevenue = Order::where('created_at', '>=', [$firstDayOfMonth])->sum('total');
        
        return $thisMonthRevenue;
    }

    public function getLastMonthRevenue()
    {
        $firstDayOfLastMonth = now()->startOfMonth()->subMonth();
        $lastDayOfLastMonth = now()->startOfMonth()->subDay();
        $lastMonthRevenue = Order::whereBetween('created_at', [$firstDayOfLastMonth, $lastDayOfLastMonth])->sum('total');
        
        return $lastMonthRevenue;
    }

    public function getTodayOrders()
    {
        $today = Carbon::now()->toDateString();
        $todayOrders = Order::whereDate('created_at', $today)->count();

        return $todayOrders;
    }

    public function getYesterdayOrders()
    {
        $yesterday = Carbon::yesterday()->toDateString();
        $yesterdayOrders = Order::whereDate('created_at', [$yesterday])->count();

        return $yesterdayOrders;
    }

    public function getThisMonthOrders()
    {
        $firstDayOfMonth = now()->startOfMonth();
        $thisMonthOrders = Order::where('created_at', '>=', [$firstDayOfMonth])->count();
        
        return $thisMonthOrders;
    }

    public function getLastMonthOrders()
    {
        $firstDayOfLastMonth = now()->startOfMonth()->subMonth();
        $lastDayOfLastMonth = now()->startOfMonth()->subDay();
        $lastMonthOrders = Order::whereBetween('created_at', [$firstDayOfLastMonth, $lastDayOfLastMonth])->count();
        
        return $lastMonthOrders;
    }

    protected function calculateTotalQty($orders)
    {
        $totalQty = 0;

        foreach ($orders as $order) {
            $details = DB::table('detail_orders')
                ->where('id_order', $order->id)
                ->get();

            foreach ($details as $detail) {
                $totalQty += $detail->qty;
            }
        }

        return $totalQty;
    }
    
    
}
