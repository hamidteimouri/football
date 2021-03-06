<?php

namespace App\Http\Controllers\Api;

use App\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Team as TeamResource;
use Exception;

class TeamController extends Controller
{
    protected $status_success = 200;
    protected $status_error = 404;
    protected $paginate = 20;
    protected $bad_request = 400;

    public function index()
    {
        try {
            $teams = Team::latest()->paginate($this->paginate);
            $teams = TeamResource::collection($teams);
            return $teams;
        } catch (Exception $exception) {
            dd('Error: ' . $exception->getMessage(), ' | file: ' . $exception->getFile() . ' | line: ' . $exception->getLine());
        }
    }

    public function show(Team $team)
    {
        try {
            $team = new TeamResource($team);
            return $team;
        } catch (Exception $exception) {
            dd('Error: ' . $exception->getMessage(), ' | file: ' . $exception->getFile() . ' | line: ' . $exception->getLine());
        }
    }

    public function store()
    {
        try {
            $request = request()->all();
            # Validate
            $validate = validator($request, [
                'name' => 'required|max:128',
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'errors' => $validate->errors()
                ], $this->bad_request);
            }

            # add new team
            $obj = new Team;
            $obj->name = $request['name'];
            $obj->save();
            return response()->json([
                'Successfully added...'
            ], $this->status_success);
        } catch (Exception $exception) {
            dd('Error: ' . $exception->getMessage(), ' | file: ' . $exception->getFile() . ' | line: ' . $exception->getLine());
        }
    }

    public function update(Team $team)
    {
        try {
            //Validate
            $validate = validator(request()->all(), [
                'name' => 'required|max:128',
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'errors' => $validate->errors()
                ], $this->bad_request);
            }
            $team->update([
                'name' => request('name')
            ]);
            return response()->json([
                'Successfully updated'
            ], $this->status_success);
        } catch (Exception $exception) {
            dd('Error: ' . $exception->getMessage(), ' | file: ' . $exception->getFile() . ' | line: ' . $exception->getLine());
        }
    }
}
