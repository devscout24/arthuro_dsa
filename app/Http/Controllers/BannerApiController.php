<?php

namespace App\Http\Controllers;

use App\Models\Already;
use App\Models\Anything;
use App\Models\Banner;
use App\Models\Building;
use App\Models\Carrer;
use App\Models\CarrerUp;
use App\Models\ContactDynamic;
use App\Models\Exception;
use App\Models\Explore;
use App\Models\Family;
use App\Models\FooterDown;
use App\Models\Founder;
use App\Models\Future;
use App\Models\GeneralUser;
use App\Models\Here;
use App\Models\Horizon;
use App\Models\Information;
use App\Models\Misson;
use App\Models\Navbar;
use App\Models\Negotiable;
use App\Models\Partner;
use App\Models\PrivacyPolicy;
use App\Models\SocialSetting;
use App\Models\SystemSetting;
use App\Models\Team;
use App\Models\TeamParagraph;
use App\Models\Term;
use App\Models\User;
use App\Models\UserContact;
use App\Models\work;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class BannerApiController extends Controller
{
    private function stripTagsOrNull(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $text = trim(strip_tags((string) $value));

        return $text === '' ? null : $text;
    }

    private function normalizeToArray(mixed $value): array
    {
        if ($value instanceof Collection) {
            return $value->values()->all();
        }

        if (is_array($value)) {
            return array_values($value);
        }

        if ($value === null) {
            return [];
        }

        if (is_string($value)) {
            $value = trim($value);
            if ($value === '') {
                return [];
            }

            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return is_array($decoded) ? array_values($decoded) : [];
            }

            if (str_contains($value, ',')) {
                return array_values(array_filter(array_map('trim', explode(',', $value)), fn($part) => $part !== ''));
            }

            return [$value];
        }

        return [$value];
    }

    private function assetList(mixed $value, string $prefix): array
    {
        $items = $this->normalizeToArray($value);

        return collect($items)
            ->filter(fn($item) => $item !== null && trim((string) $item) !== '')
            ->map(fn($item) => asset(trim($prefix, '/') . '/' . ltrim(trim((string) $item), '/')))
            ->values()
            ->all();
    }

    private function assetFileOrUrl(?string $value, string $prefix): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim($value);
        if ($value === '') {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        $value = ltrim($value, '/');
        $prefix = trim($prefix, '/');

        if ($prefix !== '' && str_starts_with($value, $prefix . '/')) {
            return asset($value);
        }

        return asset(($prefix !== '' ? $prefix . '/' : '') . $value);
    }

    /**
     * API: Get banners as JSON
     */
    public function bannerindex()
    {
        $banners = Banner::all()->map(function ($banner) {
            $rawIcons = $banner->getRawOriginal('icons');
            $rawImages = $banner->getRawOriginal('image');
            $rawFeatures = $banner->getRawOriginal('features');

            return [
                'id' => $banner->id,
                'title' => $banner->title,
                'comming_soon' => $banner->comming_soon,
                'tagline' => $banner->tagline,
                'button' => $banner->button,
                'career' => $banner->career,
                'description' => $this->stripTagsOrNull($banner->description),
                'image' => $this->assetList($banner->image ?? $rawImages, 'images'),
                'features' => $this->normalizeToArray($banner->features ?? $rawFeatures),
                'icons' => $this->assetList($banner->icons ?? $rawIcons, 'images'),
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
                'tagline' => $item->tagline,
                'description' => $this->stripTagsOrNull($item->description),
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
                'question' => $item->question,
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
                'description' => $this->stripTagsOrNull($item->description),
                'image' => $item->image ? asset('images/' . $item->image) : null,
                'button' => $item->button,
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
                'title' => $partner->title,
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
                'description' => $this->stripTagsOrNull($work->description),
                'tag_header' => $work->tag_header,
                'tag_footer' => $work->tag_footer,
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
        $horizons = Horizon::all()->map(function ($horizon) {
            return [
                'id' => $horizon->id,
                'title' => $horizon->title,
                'tagline' => $horizon->tagline,
                'description' => $this->stripTagsOrNull($horizon->description),
                'image' => $horizon->image ? asset('images/' . $horizon->image) : null,
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
        $explores = Explore::all()->map(function ($explore) {
            return [
                'id' => $explore->id,
                'title' => $explore->title,
                'tagline' => $explore->tagline,
                'description' => $this->stripTagsOrNull($explore->description),
                'image' => $explore->image ? asset('images/' . $explore->image) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Explore data fetched successfully',
            'data' => $explores
        ]);
    }


    public function founderindex()
    {
        $founders = Founder::all()->map(function ($founder) {
            return [
                'id' => $founder->id,
                'title' => $founder->title,
                'description' => $this->stripTagsOrNull($founder->description),
                'designation' => $this->stripTagsOrNull($founder->designation),
                'image' => $founder->image ? asset('founders/' . $founder->image) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Founder data fetched successfully',
            'data' => $founders
        ]);
    }


    public function userContactIndex()
    {
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


    public function allUserStore(Request $request)
    {
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



    public function userContactStore(Request $request)
    {
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


    public function termindex()
    {
        $terms = Term::all()->map(function ($term) {

            return [
                'id' => $term->id,
                'title' => $term->title,
                'description' => $this->stripTagsOrNull($term->description),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Term data fetched successfully',
            'data' => $terms
        ]);
    }



    public function privacypolicyindex()
    {
        $privacies = PrivacyPolicy::all()->map(function ($privacy) {

            return [
                'id' => $privacy->id,
                'title' => $privacy->title,
                'description' => $this->stripTagsOrNull($privacy->description),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Privacy data fetched successfully',
            'data' => $privacies
        ]);
    }


    public function missionindex()
    {
        $missions = Misson::all()->map(function ($mission) {

            return [
                'id' => $mission->id,
                'title' => $mission->title,
                'description' => $this->stripTagsOrNull($mission->description),

            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Mission data fetched successfully',
            'data' => $missions
        ]);
    }


    public function careerUp(Request $request)
    {

        $careerUp = CarrerUp::all()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Career Up data fetched successfully',
            'data' => $careerUp
        ]);
    }


    public function hereIndex()
    {
        $heres = Here::all()->map(function ($here) {
            return [
                'id' => $here->id,
                'title' => $here->title,
                'description' => $this->stripTagsOrNull($here->description),
                'button' => $here->button,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Here data fetched successfully',
            'data' => $heres
        ]);
    }


    public function futureindex()
    {
        $futures = Future::all()->map(function ($future) {
            return [
                'id' => $future->id,
                'title' => $future->title,
                'description' => $this->stripTagsOrNull($future->description),
                'button' => $future->button,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Future data fetched successfully',
            'data' => $futures
        ]);
    }

    public function alreadyindex()
    {
        $alreadys = Already::all()->map(function ($already) {
            return [
                'id' => $already->id,
                'title' => $already->title,
                'description' => $this->stripTagsOrNull($already->description),
                'tag_header' => $already->tag_header,
                'tag_body' => $already->tag_body,
                'tag_number' => $already->tag_number,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Already data fetched successfully',
            'data' => $alreadys
        ]);
    }

    public function negotiableindex()
    {
        $negotiables = Negotiable::all()->map(function ($negotiable) {
            return [
                'id' => $negotiable->id,
                'title' => $negotiable->title,
                'description' => $this->stripTagsOrNull($negotiable->description),
                'tagline' => $negotiable->tagline,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Negotiable data fetched successfully',
            'data' => $negotiables
        ]);
    }


    public  function teamparagraphindex()
    {
        try {
            if (!Schema::hasTable('team_paragraphs')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Team Paragraph table not found. Run migrations first.',
                    'data' => []
                ]);
            }

            $teamParagraphs = TeamParagraph::all()->map(function ($teamParagraph) {
                return [
                    'id' => $teamParagraph->id,
                    'title' => $teamParagraph->title,
                    'description' => $this->stripTagsOrNull($teamParagraph->description),
                    'tagline' => $teamParagraph->tagline,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Team Paragraph data fetched successfully',
                'data' => $teamParagraphs
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Team Paragraph data fetch failed.',
                'data' => []
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Team Paragraph data fetch failed.',
                'data' => []
            ]);
        }
    }

    public function navbarindex()
    {
        $navbars = Navbar::all()->map(function ($navbar) {
            return [
                'id' => $navbar->id,
                'logo' => $this->assetFileOrUrl($navbar->logo, 'images'),
                'home' => $navbar->home,
                'for' => $navbar->for,
                'story' => $navbar->story,
                'waitlist' => $navbar->waitlist,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Navbar data fetched successfully',
            'data' => $navbars
        ]);
    }

    public function buildingindex()
    {
        $buildings = Building::all()->map(function ($building) {
            return [
                'id' => $building->id,
                'title' => $building->title,
                'description' => $this->stripTagsOrNull($building->description),
                'tagline' => $building->tagline,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Building data fetched successfully',
            'data' => $buildings
        ]);
    }

    public function exceptionindex()
    {
        $exceptions = Exception::all()->map(function ($exception) {
            return [
                'id' => $exception->id,
                'title' => $exception->title,
                'description' => $this->stripTagsOrNull($exception->description),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Exception data fetched successfully',
            'data' => $exceptions
        ]);
    }


    public function socialMediaindex()
    {
        $socialMedias = SocialSetting::all()->map(function ($socialMedia) {
            return [
                'id' => $socialMedia->id,
                'instagram_icon' => $this->assetFileOrUrl($socialMedia->instagram_icon, 'uploads/social-icons'),
                'instagram_link' => $socialMedia->instagram_link,
                'linkedin_icon' => $this->assetFileOrUrl($socialMedia->linkedin_icon, 'uploads/social-icons'),
                'linkedin_link' => $socialMedia->linkedin_link,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Social Media data fetched successfully',
            'data' => $socialMedias
        ]);
    }

    public function systemSettingindex()
    {
        $systemSettings = SystemSetting::all()->map(function ($systemSetting) {
            return [
                'id' => $systemSetting->id,
                'system_title' => $systemSetting->system_title,
                'company_name' => $systemSetting->company_name,
                'copyright_text' => $systemSetting->copyright_text,
                'logo' => $this->assetFileOrUrl($systemSetting->logo, 'uploads/system-settings-images'),
                'mini_logo' => $this->assetFileOrUrl($systemSetting->mini_logo, 'uploads/system-settings-images'),
                'favicon' => $this->assetFileOrUrl($systemSetting->favicon, 'uploads/system-settings-images'),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'System Setting data fetched successfully',
            'data' => $systemSettings
        ]);
    }


    public function contactDynamicindex()
    {
        $contactDynamics = ContactDynamic::all()->map(function ($contactDynamic) {
            return [
                'id' => $contactDynamic->id,
                'title' => $contactDynamic->title,
                'description' => $this->stripTagsOrNull($contactDynamic->description),
                'name_label' => $contactDynamic->name_label,
                'name_placeholder' => $contactDynamic->name_placeholder,
                'email_label' => $contactDynamic->email_label,
                'email_placeholder' => $contactDynamic->email_placeholder,
                'phone_label' => $contactDynamic->phone_label,
                'phone_placeholder' => $contactDynamic->phone_placeholder,
                'message_label' => $contactDynamic->message_label,
                'message_placeholder' => $contactDynamic->message_placeholder,
                'button' => $contactDynamic->button,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Contact Dynamic data fetched successfully',
            'data' => $contactDynamics
        ]);
    }

    public function informationindex()
    {
        $informations = Information::all()->map(function ($information) {
            return [
                'id' => $information->id,
                'title' => $information->title,
                'description' => $this->stripTagsOrNull($information->description),
                'email_label' => $information->email_label,
                'email_icon' => $information->email_icon,
                'email' => $information->email,
                'tagline' => $information->tagline,
                'linkedin' => $information->linkedin,
                'linkedin_icon' => $information->linkedin_icon,
                'instagram' => $information->instagram,
                'instagram_icon' => $information->instagram_icon,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Information data fetched successfully',
            'data' => $informations
        ]);
    }

    public function footerDownindex()
    {
        $footerDowns = FooterDown::all()->map(function ($footerDown) {
            return [
                'id' => $footerDown->id,
                'privacy' => $footerDown->privacy,
                'terms' => $footerDown->terms,
                'contact' => $footerDown->contact,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Footer Down data fetched successfully',
            'data' => $footerDowns
        ]);
    }



}
