<?php

namespace App\Http\Controllers;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;  // ← add this

class TweetController extends Controller
{

    // old function to create a tweet
    // public function createTweet(Request $request){
    // $data = $request->validate([
    //     'content' => 'required|string',
    //     'userId'  => 'required|exists:users,id',
    // ]);

    // $tweet = Tweet::create([
    //     'tweet_text' => $data['content'],
    //     'user_id'    => $data['userId'],
    // ]);

    // return response()->json([
    //     'success' => true,
    //     'tweet'   => $tweet,
    // ]);


    // }

    public function createTweet(Request $request)
    {
        try {
            // 1) Validate input
            $data = $request->validate([
                'content' => 'required|string',
                'userId'  => 'required|exists:user,id',
            ]);

            // 2) Create the tweet
            $tweet = Tweet::create([
                'tweet_text' => $data['content'],
                'user_id'    => $data['userId'],
            ]);

            // 3) Return success
            return response()->json([
                'success' => true,
                'tweet'   => $tweet,
            ], 201);

        } catch (ValidationException $e) {
            // Validation failed → return 422 + errors
            return response()->json([
                'success' => false,
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            // Log the full exception for your debug
            Log::error('Error creating tweet: '.$e->getMessage(), [
                'exception' => $e,
                'payload'   => $request->all(),
            ]);

            // Return the exception message (and optionally stack trace) to client
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                //'trace'   => $e->getTraceAsString(), // uncomment if you need the trace
            ], 500);
        }
    }


public function getTimeline(Request $request)
    {
        // Eager-load the user relation
        $tweets = Tweet::with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($t) {
                return [
                    'content' => $t->tweet_text,
                    'name'    => $t->user->name,
                    'date'    => $t->created_at->format('Y-m-d H:i'),
                ];
            });

        return response()->json($tweets);
    }



}
