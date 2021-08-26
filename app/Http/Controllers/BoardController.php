<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Board;
use App\Http\Resources\BoardResource;
use App\Http\Requests\UpdateBoardRequest;
use App\Recipient;
use App\Worker;
use App\Guest;
use Attribute;
use Illuminate\Http\Request;
use SebastianBergmann\CodeUnit\FunctionUnit;

class BoardController extends Controller
{

    /**
     * All Boards Getter with custom Data
     */
    public function getAll()
    {
        $boards = BoardResource::collection(Board::all());
        return $boards;
    }

    /**
     * All Boards Getter with custom Data
     */
    public function getRecipients()
    {
        $id = Auth::id();
        $worker= Worker::where(["user_id"=>$id])->first();

        $boards = Board::whereHas('recipients', function ($query) use ($worker) {
            return $query->where('recipient_id', '=', $worker->id);
        })->get();

        $boardsRecipients = BoardResource::collection($boards);
        return $boardsRecipients;
    }

    /**
     *Show a bord with custom data
     */
    public function show($board_id)
    {
        try {
            $board = new BoardResource(Board::find($board_id));
            if (is_null($board))
                return [
                    'message' => 'KudoBoard not exist',
                    'type' => 'warning'
                ];

            return $board;
        } catch (\Exception $e) {
            return [
                'message' => $e,
                'type' => 'danger'
            ];
        }
    }

    /**
     * Create Board
     */
    public function create(Request $request)
    {
        
        try {
            $id = Auth::id();
            $worker= Worker::where(["user_id"=>$id])->first();
            $board = new Board;
            $board->description = $request->description;
            $board->worker()->associate($worker);
            $board->save();
            
            $guest = new Guest;
            $guest->guest_id = $worker->id;
            $guest->board_id = $board->id;
            $guest->save();

            $req_workers = $request->workers;
            //* create a board;
            
            foreach ($req_workers as $worker_id) {

                $workerRec = Worker::find($worker_id);
                $recipient = new Recipient;
                $recipient->recipient_id = $workerRec->id;
                $recipient->board_id = $board->id;
                $recipient->save();
            }
            return [
                'message' => 'KudoBoard create successfully',
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
    public function update($board_id, UpdateBoardRequest $request)
    {
        try {
            $board = Board::find($board_id);
            if (is_null($board))
                return [
                    'message' => 'KudoBoard not exist',
                    'type' => 'warning'
                ];
            
            /**
             * edit board
             */
            $board->description = $request->description;
            $board->start_date = $request->start_date;
            $board->end_date = $request->end_date;
            $board->num_max_guest = $request->num_max_guest;
            $board->save();

            /**
             * delete recipients
             */
            $recipients_delete= $board->recipients;
            foreach($recipients_delete as $w){
                $w->delete();
            }

            /**
             * create new recipients
             */

            $req_workers = $request->workers;

            foreach ($req_workers as $worker_id) {

                $workerRec = Worker::find($worker_id);
                $recipient = new Recipient;
                $recipient->recipient_id = $workerRec->id;
                $recipient->board_id = $board->id;
                $recipient->save();
            }


            return [
                'message' => 'KudoBoard update successfully',
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
     * delete Board
     */
    public function delete($board_id)
    {
        try {
            $board = Board::find($board_id);
            if (is_null($board))
                return [
                    'message' => 'KudoBoard not exist',
                    'type' => 'warning'
                ];

            $board->delete();

            return [
                'message' => 'KudoBoard deleted successfully',
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
