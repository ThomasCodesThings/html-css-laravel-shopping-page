<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Option;
use App\Models\Vote;
use Illuminate\Http\Request;

//inspirovane prikladom jednoducheho manazera uloh
class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $polls = Poll::orderBy('date_from')->get();
        return view('pages.polls.index', compact('polls',$polls));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.polls.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $polls = Poll::orderBy('date_from')->get();
        if($request->date_to < $request->date_from){
            return view('pages.polls.index', compact('polls',$polls));
        }
        foreach(Poll::all() as $poll){
            if(($request->date_from >= $poll->date_from && $request->date_from <= $poll->date_to) || ($request->date_to >= $poll->date_from && $request->date_to <= $poll->date_to)){
                return view('pages.polls.index', compact('polls',$polls));
            }
        }
        Poll::create(['date_from' => $request->date_from, 'date_to' => $request->date_to, 'question' => $request->question]);
        $polls = Poll::orderBy('date_from')->get();
        return view('pages.polls.index', compact('polls',$polls));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function show(Poll $poll)
    {
        $votes = Vote::where('poll_id', $poll->id)->get();
        if($votes){
            $results = [];
            foreach($votes as $vote){
                if(isset($results[$vote->opion])){
                        $results[$vote->option] = $results[$vote->option] + 1;
                }else{
                        $results[$vote->option] = 1;
                }
            }
            return view('pages.polls.show', ['results' => $results]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function edit(Poll $poll)
    {
        return view('pages.polls.edit', compact('poll',$poll));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poll $poll)
    {
        $poll->update(['date_from' => $request->date_from, 'date_to' => $request->date_to, 'question' => $request->question]);
        return redirect('polls');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poll $poll)
    {
        Poll::where('id', $poll->id)->delete();
        return redirect()->back();
    }

}
