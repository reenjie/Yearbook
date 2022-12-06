<?php

namespace App\Http\Controllers;

use App\Models\yearbookprint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class YearbookprintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo Auth::user()->printcount;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $userid = Auth::user()->id;
        yearbookprint::create([
            'userID'=>$userid,
        ]);
        $total = Auth::user()->printcount - 1;
        if($total < 0){
            $total = 0;
        }
        User::where('id',$userid)->update([
            'printcount'=>$total,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\yearbookprint  $yearbookprint
     * @return \Illuminate\Http\Response
     */
    public function show(yearbookprint $yearbookprint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\yearbookprint  $yearbookprint
     * @return \Illuminate\Http\Response
     */
    public function edit(yearbookprint $yearbookprint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\yearbookprint  $yearbookprint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, yearbookprint $yearbookprint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\yearbookprint  $yearbookprint
     * @return \Illuminate\Http\Response
     */
    public function destroy(yearbookprint $yearbookprint)
    {
        //
    }
}
