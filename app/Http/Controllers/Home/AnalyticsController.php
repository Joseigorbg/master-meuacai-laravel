<?php
namespace App\Http\Controllers\Home;

use App\Models\Analytics;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AnalyticsController extends Controller
{
    public function track()
    {
        if (!Session::has('has_visited') && Auth::check()) {
            $analytics = Analytics::firstOrCreate(
                ['user_id' => Auth::id()],
                ['clicks' => 0, 'accesses' => 0] // Define os valores padrão
            );
            $analytics->increment('accesses');
            Session::put('has_visited', true);
        }
    
        return view('home');
    }
    
    public function incrementClicks()
    {
        if (Auth::check()) {
            $analytics = Analytics::firstOrCreate(
                ['user_id' => Auth::id()],
                ['clicks' => 0, 'accesses' => 0] // Define os valores padrão
            );
            $analytics->increment('clicks');
        }
    
        return response()->json(['success' => true]);
    }
    
}
