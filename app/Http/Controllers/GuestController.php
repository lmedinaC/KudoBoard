<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Board;
use App\Http\Resources\GuestResource;
use App\Http\Requests\CreateGuestRequest;
use App\Recipient;
use App\Worker;
use App\Guest;
use App\Publication;
use Attribute;
use Illuminate\Http\Request;
use SebastianBergmann\CodeUnit\FunctionUnit;

class GuestController extends Controller
{
    /**
     * Get guests of Board
     */
    public function getInBoard($board_id)
    {
        $board = Board::find($board_id);
        if (is_null($board))
            return [
                'message' => 'Board not exist.',
                'type' => 'warning'
            ];
        $guests = GuestResource::collection($board->guests);
        return $guests;
    }

    /**
     * Create guest in Board
     */
    public function createInBoard(CreateGuestRequest $request)
    {

        try {

            $board = Board::find($request->board_id);
            if (is_null($board))
                return [
                    'message' => 'Board not exist.',
                    'type' => 'warning'
                ];

            $guest_exist = Guest::where(['board_id' => $board->id, 'guest_id' => $request->guest_id])->first();
            if (!is_null($guest_exist))
                return [
                    'message' => 'Guest alredy exist.',
                    'type' => 'warning'
                ];

            $guest = new Guest;
            $guest->guest_id = $request->guest_id;
            $board->guests()->save($guest);

            return [
                'message' => 'Guest created successfully',
                'type' => 'success'
            ];
        } catch (\Exception $e) {
            return [
                'message' => $e,
                'type' => 'danger'
            ];
        }
    }

    /**
     * delete guest in Board
     */
    public function delete($guest_id)
    {
        try {
            $id = Auth::id();
            $worker = Worker::where(["user_id" => $id])->first();

            $guest = Guest::find($guest_id);

            if ($worker->id == $guest->guest_id)
                return [
                    'message' => "The owner can't be removed",
                    'type' => 'warning'
                ];

            $guest->delete();
            return [
                'message' => 'Guest deleted successfully',
                'type' => 'success'
            ];
        } catch (\Exception $e) {
            return [
                'message' => $e,
                'type' => 'danger'
            ];
        }
    }
}
