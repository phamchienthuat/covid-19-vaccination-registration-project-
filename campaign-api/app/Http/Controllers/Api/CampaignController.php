<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaigns;
use App\Models\CampaignTickets;
use App\Models\Organizers;
use App\Models\Citizen;
use App\Models\Registrations;
use App\Models\SessionRegistrations;
use Carbon\Carbon;

class CampaignController extends Controller
{
    function index(){
        $camp = Campaigns::where('date','>=',Carbon::now())->orderBy('date','asc')->with('organizer')->get();
        return (['campaigns'=>$camp]);
    }

    function detail(Request $request){
        $orgSlug = Organizers::where('slug',$request->orgSlug)->first();
        if(!$orgSlug){
            return response()->json(['message' => "Organizer not found"],404);
        }
        else
        {
            $campSlug = Campaigns::where('slug',$request->campSlug)->with('areas','areas.places','areas.places.sessions','tickets')->get();
            if($campSlug->count() < 1){
                return response()->json(['message' => "Campaign not found"],404);
            }
            else
            {
                return $campSlug;
            }
        }
    }
    function showRegis(Request $request){
        $citizen = Citizen::where('login_token',$request->token)->first();
        if(!$citizen){
            return response()->json(['message' => "User not logged in"],401);
        }
        else
        {
            $registration = Registrations::where('citizen_id',$citizen->id)->get();
            return ([
                'registrations' => $registration->map(function($regis){
                    return ([
                        'campaign' => $regis->ticket->campaign,
                        'session_ids' => $regis->sessions()->get()->pluck('id')
                    ]);
                })
            ]);
        }
    }
    function doRegis(Request $request){
        $campaign = Campaigns::where('slug',$request->campSlug)->first();
        $ticket = CampaignTickets::where('id',$request->ticket_id)->first();
        $citizen = Citizen::where('login_token',$request->token)->first();
        if(!$citizen){
            return response()->json(['message' => "User not logged in"],401);
        }
        $registration = Registrations::where('citizen_id',$citizen->id)->whereIn('ticket_id',
        CampaignTickets::where('campaign_id',$campaign->id)->get()->pluck('id'))->first();
        if($registration){
            return response()->json(['message' => "User already registered"],401);
        }
        if(!$ticket->available){
            return response()->json(['message' => "Ticket is no longer available"],401);
        }
        else
        {
            $regis = new Registrations();
            $regis->ticket_id = $ticket->id;
            $regis->citizen_id = $citizen->id;
            $regis->registration_time = Carbon::now();
            $regis->save();
            if($request->session_ids){
                foreach($request->session_ids as $ses){
                    $sesRegis = new SessionRegistrations();
                    $sesRegis->session_id = $ses;
                    $sesRegis->registration_id = $regis->id;
                    $sesRegis->save();
                }
            }
            return response()->json(['message' => "Registration successful"]);
        }
    }

}
