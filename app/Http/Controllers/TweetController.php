<?php

namespace App\Http\Controllers;
use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{

    public function createTweet(Request $request){
        $request ->validate([
            'user_id'=> 'required|exists:users,id',
            'tweet_text'=>'required|string',
        ]);

        $tweet = Tweet::create([
            'user_id'=> $request->user_id,
            'tweet_text'=> $request->tweet_text,
        ]);

        return response()->json(['message'=> 'Tweet created successfully','tweet'=>$tweet],200);


    }





}
