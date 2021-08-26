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

class PublicationController extends Controller
{

    /**
     * Create posts
     */
    public function create(Request $request)
    {

        try {
            $id = Auth::id();
            $worker = Worker::where(["user_id" => $id])->first();

            $board = Board::find($request->board_id);

            $guest = Guest::where(["guest_id" => $worker->id, "board_id" => $board->id])->first();

            $today = strtotime(date("d-m-Y H:i:00", time()));

            if (!is_null($board->start_date)) {
                if (strtotime($board->start_date) > $today)
                    return [
                        'message' => "Still can't be posted. Start: ".$board->start_date,
                        'type' => 'warning'
                    ];
            }
            if (!is_null($board->end_date)) {
                if (strtotime($board->end_date) < $today)
                    return [
                        'message' => "Can't longer be posted. Ended: ". $board->end_date,
                        'type' => 'warning'
                    ];
            }

            $publication = new Publication;
            $publication->description = $request->description;
            $publication->guest_id = $guest->id;
            $publication->save();

            return [
                'message' => 'Post created successfully',
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
     * Edit post
     */
    public function update(Request $request)
    {
        try {
            $id = Auth::id();
            $worker = Worker::where(["user_id" => $id])->first();

            $publication = Publication::find($request->publication_id);

            if ($worker->id !== $publication->guest->worker->id)
                return [
                    'message' => 'This post is not your.',
                    'type' => 'warning'
                ];

            $publication->description = $request->description;
            $publication->save();

            return [
                'message' => 'Post edited successfully',
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
     * Get all posts of a board
     */
    public function getByIdBoard($board_id)
    {
        try {
            $board = Board::find($board_id);
            $response = array();
            foreach ($board->guests as $guest) {
                foreach ($guest->publications as $post) {
                    $res = [
                        "guest_id" => $guest->id,
                        "worker_id" => $guest->worker->id,
                        "worker_name" => $guest->worker->user->name,
                        "post" => $post,
                    ];
                    array_push($response, $res);
                }
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
     * delete post
     */
    public function delete($publication_id)
    {
        try {
            $id = Auth::id();
            $worker = Worker::where(["user_id" => $id])->first();

            $publication = Publication::find($publication_id);

            if ($publication->guest->guest_id !== $worker->id)
                return [
                    'message' => 'This post is not your.',
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
}
