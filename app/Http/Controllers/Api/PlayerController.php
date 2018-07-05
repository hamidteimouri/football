<?php

namespace App\Http\Controllers\Api;

use App\Team;
use App\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Player as PlayerResource;
use Exception;

class PlayerController extends Controller
{
    protected $status_success = 200;
    protected $status_error = 404;
    protected $paginate = 20;
    protected $bad_request = 400;

    public function index()
    {
        try {
            $players = Player::latest()->paginate($this->paginate);
            $players = PlayerResource::collection($players);
            return $players;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function show(Player $player)
    {
        try {
            $player = new PlayerResource($player);
            return $player;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function store()
    {
        $request = request()->all();
        //Validate
        $validate = validator($request, [
            'first_name' => 'required|max:128',
            'last_name' => 'required|max:128',
            'team_id' => 'required|max:128',
        ], [], [
            'first_name' => "Name",
            'last_name' => "Family",
            'team_id' => "Team",
        ]);
        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], $this->bad_request);
        }

        // add new team
        try {

            $team = Team::find($request['team_id']);

            if ($team) {
                $obj = new Player();
                $obj->first_name = $request['first_name'];
                $obj->team_id = $team->id;
                $obj->last_name = $request['last_name'];
                $obj->save();

                $response = response()->json([
                    'New player successfully added...'
                ], $this->status_success);

            } else {
                $response = response()->json([
                    'Team not found'
                ], $this->status_error);
            }


            return $response;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function update(Player $player)
    {
        //Validate
        $validate = validator(request()->all(), [
            'first_name' => 'required|max:128',
            'last_name' => 'required|max:128',
            'team_id' => 'required|max:128',
        ], [], [
            'first_name' => "Name",
            'last_name' => "Family",
            'team_id' => "Team",
        ]);
        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], $this->bad_request);
        }

        try {
            $team = Team::find(request('team_id'));

            // check team...
            if ($team) {
                $player->update([
                    'first_name' => request('first_name'),
                    'last_name' => request('last_name'),
                    'team_id' => $team->id,
                ]);
                $response = response()->json([
                    'The player successfully updated'
                ], $this->status_success);
            } else {
                $response = response()->json([
                    'Team not found , please select ke valid team.'
                ], $this->status_success);
            }
            return $response;
        } catch (Exception $ex) {
            return $ex;
        }


    }
}
   