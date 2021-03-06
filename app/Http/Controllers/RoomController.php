<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{

    protected $customPropertiesExcept = [
        "user_count",
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rooms = null;

        if($request->q){

            $rooms = Room::where('name', 'like', '%'.$request->q.'%')->get()->first();

        } else {

            $rooms = Room::where('busy', false)->get();

        }

        return $rooms;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        return $room;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $room = new Room();

        if(Room::where('name', $request->name)){
            return response('Duplicated name', 400);
        }

        $room->fill($request->except($this->customPropertiesExcept));
        $room->created_at = Carbon::now();
        $room->updated_at = Carbon::now();

        $room->save();

        return $room;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $room->fill($request->except($this->customPropertiesExcept));
        $room->updated_at = Carbon::now();
        $room->save();

        return $room;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room->delete();
    }
}
