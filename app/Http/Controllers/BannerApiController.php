<?php

namespace App\Http\Controllers;

use App\Models\Anything;
use App\Models\Banner;
use App\Models\Carrer;
use App\Models\Explore;
use App\Models\Family;
use App\Models\Founder;
use App\Models\GeneralUser;
use App\Models\Horizon;
use App\Models\Partner;
use App\Models\PrivacyPolicy;
use App\Models\Team;
use App\Models\Term;
use App\Models\User;
use App\Models\UserContact;
use App\Models\work;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class BannerApiController extends Controller
{
    /**
     * API: Get banners as JSON
     */
    public function bannerindex()
    {
        $banners = Banner::all()->map(function ($banner) {
            return [
                'id' => $banner->id,
                'title' => $banner->title,
                'description' => strip_tags($banner->description),
                'features' => $banner->features,
                'icons' => collect($banner->icons)->map(fn($icon) => asset('images/' . $icon)),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Banner data fetched successfully',
            'data' => $banners
        ]);
    }
    public function index()
    {
        $teams = Team::all()->map(function ($team) {
            return [
                'id' => $team->id,
                'title' => $team->title,
                'designation' => $team->designation,
                'image' => $team->image ? asset('teams/' . $team->image) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Team data fetched successfully',
            'data' => $teams
        ]);
    }

    public function anythingindex()
    {
        $anythings = Anything::all()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => strip_tags($item->description),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Anything data fetched successfully',
            'data' => $anythings
        ]);
    }

    public function carrerindex()
    {
        $carrers = Carrer::all()->map(function ($item) {
            return [
                'id' => $item->id,
                'numbers' => $item->numbers,
                'tagline' => $item->tagline,
                'title' => $item->title,
                'description' => $item->description,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Carrer data fetched successfully',
            'data' => $carrers
        ]);
    }


    public function familyindex()
    {
        $families = Family::latest()->get()->map(function ($item) {

            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => strip_tags($item->description), // HTML remove
                'image' => $item->image ? asset('images/' . $item->image) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Family data fetched successfully',
            'data' => $families
        ]);
    }

    public function partnerindex()
    {
        $partners = Partner::all()->map(function ($partner) {

            return [
                'id' => $partner->id,
                'image' => $partner->image ? asset('images/' . $partner->image) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Partner data fetched successfully',
            'data' => $partners
        ]);
        }

        public function workindex()
        {
            $works = work::all()->map(function ($work) {
    
                return [
                    'id' => $work->id,
                    'title' => $work->title,
                    'description' => strip_tags($work->description), // HTML remove
                ];
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Work data fetched successfully',
                'data' => $works
            ]);
        }

        public function horizonindex()
        {
            $horizons = Horizon::all()->map(function ($horizons) {
    
                return [
                    'id' => $horizons->id,
                    'title' => $horizons->title,
                    'description' => strip_tags($horizons->description), // HTML remove
                    'image' => $horizons->image ? asset('images/' . $horizons->image) : null,
                ];
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Horizon data fetched successfully',
                'data' => $horizons
            ]);
        }

        public function exploreindex()
        {
            $explore = Explore::all()->map(function ($explore) {
    
                return [
                    'id' => $explore->id,
                    'title' => $explore->title,
                    'description' => strip_tags($explore->description), // HTML remove
                    'image' => $explore->image ? asset('images/' . $explore->image) : null,
                ];
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Explore data fetched successfully',
                'data' => $explore
            ]);
        }


        public function founderindex()
        {
            $founders = Founder::all()->map(function ($founders) {
    
                return [
                    'id' => $founders->id,
                    'title' => $founders->title,
                    'description' => strip_tags($founders->description), // HTML remove
                    'designation' => strip_tags($founders->designation), // HTML remove
                    'image' => $founders->image ? asset('founders/' . $founders->image) : null,
                ];
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Founder data fetched successfully',
                'data' => $founders
            ]);
        }


        public function userContactIndex(){
            $users = User::all()->map(function ($user) {
    
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    
                ];
            });
    
            return response()->json([
                'success' => true,
                'message' => 'User Contact data fetched successfully',
                'data' => $users
            ]);
        }


        public function allUserStore(Request $request){
            $request->validate([
                'name' => 'required',
                'email' => 'required'
            ]);
    
            $user = GeneralUser::create([
                'name' => $request->name,
                'email' => $request->email
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'User Contact created successfully',
                'data' => $user
            ]);
        }



        public function userContactStore(Request $request){
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'message' => 'required'
                
            ]);
    
            $user = UserContact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'User Contact created successfully',
                'data' => $user
            ]);
        }


        public function termindex(){
            $terms = Term::all()->map(function ($term) {
    
                return [
                    'id' => $term->id,
                    'title' => $term->title,
                    'description' => strip_tags($term->description), // HTML remove
                ];
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Term data fetched successfully',
                'data' => $terms
            ]);
        }
           


        public function privacypolicyindex(){
            $privacies = PrivacyPolicy::all()->map(function ($privacy) {
    
                return [
                    'id' => $privacy->id,
                    'title' => $privacy->title,
                    'description' => strip_tags($privacy->description), // HTML remove
                ];
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Privacy data fetched successfully',
                'data' => $privacies
            ]);
        }
    


          
}
