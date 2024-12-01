<?php
namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Stat;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    // Display all campaigns with aggregated revenue
    // public function index()
    // {
    //     $campaigns = Campaign::withSum('stats', 'revenue')->get();

    //     return view('index', compact('campaigns'));
    // }

    // Display the campaigns page
    public function index()
    {
        return view('index'); // The view should initialize DataTables
    }

    // Fetch campaigns data for DataTables
    public function getCampaigns(Request $request)
    {
        
        $query = Campaign::withSum('stats', 'revenue');

        if ($search = $request->input('search.value')) {
            $query->where('utm_campaign', 'like', "%{$search}%");
        }

        $totalData = $query->count();
        $campaigns = $query
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy(
                $request->input("columns.{$request->input('order.0.column')}.data"),
                $request->input('order.0.dir', 'asc')
            )
            ->get();

        

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $campaigns,
        ]);
    }

    // Display stats for a single campaign broken down by date and hour
    public function show(Campaign $campaign)
    {
        $stats = Stat::where('campaign_id', $campaign->id)
                     ->selectRaw('DATE(event_time) as date, HOUR(event_time) as hour, SUM(revenue) as revenue')
                     ->groupBy('date', 'hour')
                     ->get();

        return view('show', compact('campaign', 'stats'));
    }

    // Display stats for a single campaign broken down by utm_term
    public function publishers(Campaign $campaign)
    {
        $stats = Stat::where('campaign_id', $campaign->id)
                     ->selectRaw('utm_term, SUM(revenue) as revenue')
                     ->groupBy('utm_term')
                     ->get();

        return view('publishers', compact('campaign', 'stats'));
    }
}
