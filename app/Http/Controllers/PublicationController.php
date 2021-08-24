<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Board;
use App\Http\Resources\BoardResource;
use App\Http\Requests\UpdateBoardRequest;
use App\Recipient;
use App\Worker;
use App\Guest;
use App\Publication;
use Attribute;
use Illuminate\Http\Request;
use SebastianBergmann\CodeUnit\FunctionUnit;

class BoardController extends Controller
{

    /**
     * Create Board
     */
    public function create(Request $request)
    {
        
        try {
            $id = Auth::id();
            $worker= Worker::where(["user_id"=>$id])->first();

            $board = Board::find($request->bord_id);
            
            $guest = Guest::where(["guest_id"=>$worker->id, "board_id"=>$board->id])->first();

            $publication = new Publication;
            $publication->description = $request->description;
            $publication->guest_id = $guest->id;
            $publication->save()
            
            return [
                'message' => 'Publication created successfully',
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
     * Update Board
     */
    public function getByIdBoard($board_id)
    {
        try {
            $board = Board::find($board_id);
            $response = array();
            foreach($board->guests as $guest ){
                $res = [
                    "worker"=>$guest->worker,
                    "publications" => $guest->publications,
                ];
                array_push($response,$res);
            }
            return  $response;
        } catch (\Exception $e) {
            return [
                'message' => $e,
                'type' => 'danger'
            ];
        }
    }

    /**
     * delete Board
     */
    public function delete($publication_id)
    {
        try {
            $id = Auth::id();
            $worker= Worker::where(["user_id"=>$id])->first();

            $publication = Publication::find($publication_id);

            if($publication->guest->guest_id !== $worker->id)
                return [
                    'message' => 'You can´t delete a post of other worker.',
                    'type' => 'warning'
                ];

            $publication->delete();

            return [
                'message' => 'Post deleted successfully.',
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
     * Permissions of the worker in the board
     */
    public function permissions($board_id)
    {
        try {
            $id = Auth::id();
            $worker= Worker::where(["user_id"=>$id])->first();
            $board = Board::find($board_id);

            if (is_null($board))
                return [
                    'message' => 'KudoBoard not exist',
                    'type' => 'warning'
                ];
            
            //* the worker is owner
            $owner_flag = false;
            if($worker->id == $board->owner_id)
                $owner_flag = true;

            //* the worker is guest
            $guest_flag = false;
            if(!is_null(Guest::where(["guest_id"=>$worker->id, "board_id"=>$board->id])->first()))
                $guest_flag = true;
                
            //* the worker is recipient
            $recipient_flag = false;
            if(!is_null(Recipient::where(["recipient_id"=>$worker->id, "board_id"=>$board->id])->first()))
                $recipient_flag = true;

            return [
                'data' => [
                    'is_owner' => $owner_flag,
                    'is_guest' => $guest_flag,
                    'is_recipient' => $recipient_flag,
                ],
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
