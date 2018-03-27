<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use DataTables;

class SubscriberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>['store']]);
        $this->middleware('leader',['except'=>['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('subscriber.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|unique:subscribers',
        ]);

        Subscriber::create([
            'email'=>$request->email,
            'status'=>'on'
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subscriber = Subscriber::findOrFail($id);

        return view('subscriber.edit',compact('subscriber'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'required|string|email',
        ]);

        $subscriber = Subscriber::findOrFail($id);
        $subscriber->update([
            'email'=>$request->email,
            'status'=>($request->status == 'on') ? 'on' : 'off'
        ]);

        return redirect()->route('subscriber.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subscriber::findOrFail($id)->delete();

        return redirect()->route('subscriber.index');
    }

    public function getsubscriber()
    {
        $subscribers = Subscriber::all();

        return DataTables::of($subscribers)
            ->addIndexColumn()
            ->toJson();
    }
}
