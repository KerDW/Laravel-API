<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();

        foreach($rooms as $room){
            $room->users;
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

        $room->fill($request->all());
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
        $room->fill($request->all());
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
