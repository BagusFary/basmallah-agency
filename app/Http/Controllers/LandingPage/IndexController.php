<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use App\Models\HousingPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $minutes = fn($num) => $num * 60;

        $heroImage = Cache::remember('index-hero-image', $minutes(60), function () {
            return DB::table('hero_images')
                ->limit(1)
                ->latest('updated_at')
                ->first(['image_url']);
        });

        $heroImage = asset("storage/$heroImage->image_url");

        $housingPartners = Cache::rememberForever('index-housing-partners', function () {
            return DB::table('housing_partners')
                ->limit(5, ['ask_question', 'answer', 'created_at'])
                ->get(['name'])
                ->pluck('name');
        });




        $houseLists = Cache::remember('index-housing-list', 3600, function () {
            return DB::table('housing_partners')
                ->orderBy('id')
                ->get();
        });

        $faqs = DB::table('faqs')
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(5);

        $housingPartnersTotal = count($housingPartners) ?? 1;

        if ($housingPartnersTotal > 3) {
            return 3;
        }

        return view('index', compact('housingPartners', 'housingPartnersTotal', 'houseLists', 'faqs', 'heroImage'));
    }

    public function getHouseLists(Request $request)
    {
        if ($request->has('cursor')) {

            $faqs = DB::table('faqs')
                ->orderBy('created_at', 'desc')
                ->cursorPaginate(5, ['ask_question', 'answer', 'created_at']);

            return response()->json($faqs);
        } else {
            return abort(403);
        }
    }
}
