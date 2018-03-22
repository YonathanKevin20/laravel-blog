<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'editor') {
            $id = Auth::user()->id;
            $published_data = $this->post->panel_count('3',$id);
            $revising_data = $this->post->panel_count('2',$id);
            $waiting_data = $this->post->panel_count('1',$id);
            $pending_data = $this->post->panel_count('0',$id);
        }
        else {
            $revising = $this->post->chart('2');
            $pending = $this->post->chart('0');
            $waiting = $this->post->chart('1');
            $published = $this->post->chart('3');

            $revising_data = $this->chartArray($revising);
            $pending_data = $this->chartArray($pending);
            $waiting_data = $this->chartArray($waiting);
            $published_data = $this->chartArray($published);

            $years = Post::selectRaw('year(created_at) as tahun')
                ->groupBy('tahun')
                ->orderBy('created_at','DESC')
                ->get();
        }

        return view('home',compact('revising_data','pending_data','waiting_data','published_data','years'));
    }

    public function pertahun(Request $request)
    {
        $revising = $this->post->chart_pertahun('2',$request->tahun);
        $pending = $this->post->chart_pertahun('0',$request->tahun);
        $waiting = $this->post->chart_pertahun('1',$request->tahun);
        $published = $this->post->chart_pertahun('3',$request->tahun);

        $revising_data = $this->chartArray($revising);
        $pending_data = $this->chartArray($pending);
        $waiting_data = $this->chartArray($waiting);
        $published_data = $this->chartArray($published);

        return response()->json([$revising_data,$pending_data,$waiting_data,$published_data]);
    }

    public function perbulan(Request $request)
    {
        $revising = $this->post->chart_perbulan('2',$request->bulan);
        $pending = $this->post->chart_perbulan('0',$request->bulan);
        $waiting = $this->post->chart_perbulan('1',$request->bulan);
        $published = $this->post->chart_perbulan('3',$request->bulan);

        $revising_data = $this->chartArray($revising);
        $pending_data = $this->chartArray($pending);
        $waiting_data = $this->chartArray($waiting);
        $published_data = $this->chartArray($published);

        return response()->json([$revising_data,$pending_data,$waiting_data,$published_data]);
    }

    private function chartArray($data)
    {
        if(count($data) > 0) {
            foreach($data as $d) {
                $data_array[] = array($d->tanggal,$d->jumlah);
            }
        }
        else {
            $data_array = 0;
        }
        return $data_array;
    }
}
