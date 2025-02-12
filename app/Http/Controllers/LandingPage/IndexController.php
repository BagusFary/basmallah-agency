<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Mail\SendReferralCode;
use App\Models\FAQ;
use App\Models\HousingPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
                ->limit(3, ['ask_question', 'answer', 'created_at'])
                ->get(['name'])
                ->pluck('name');
        });




        $houseLists = Cache::remember('index-housing-list', 3600, function () {
            return DB::table('housing_partners')
                ->orderBy('id')
                ->get();
        });

        $query = DB::table('faqs')
            ->orderBy('created_at', 'desc');

        $faqs = $query->cursorPaginate(5);

        // $SEOfaqs = $query->limit(5)->get(['ask_question', 'answer'])->toArray();

        // $SEOfaqs = array_map(function ($data) {
        //     return [
        //         '@type' => 'Question',
        //         'name' => $data->ask_question,
        //         'acceptedAnswer' => [
        //             '@type' => 'Answer',
        //             'text' => $data->answer,
        //         ],
        //     ];
        // }, $faqs->items());
        $housingPartnersTotal = count($housingPartners) ?? 1;

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

    public function sendEmail()
    {
        return new SendReferralCode('Losinto', rand(100000, 999999), 'Wisdom Wagir');
        Mail::to('losinto@gmail.com')->send(new SendReferralCode('Losinto', rand(100000, 999999), 'Wisdom Wagir'));
        return abort(403);
    }
}
