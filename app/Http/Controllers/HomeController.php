<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $revising = Post::selectRaw('count(id) as jumlah,date(created_at) as tanggal')
            ->where('status','2')
            ->groupBy('tanggal')
            ->get();
        $pending = Post::selectRaw('count(id) as jumlah,date(created_at) as tanggal')
            ->where('status','0')
            ->groupBy('tanggal')
            ->get();
        $waiting = Post::selectRaw('count(id) as jumlah,date(created_at) as tanggal')
            ->where('status','1')
            ->groupBy('tanggal')
            ->get();
        $published = Post::selectRaw('count(id) as jumlah,date(created_at) as tanggal')
            ->where('status','3')
            ->groupBy('tanggal')
            ->get();

        $revising_data = $this->chartArray($revising);
        $pending_data = $this->chartArray($pending);
        $waiting_data = $this->chartArray($waiting);
        $published_data = $this->chartArray($published);

        $years = Post::selectRaw('year(created_at) as tahun')
            ->groupBy('tahun')
            ->orderBy('created_at','DESC')
            ->get();

        return view('home',compact('revising_data','pending_data','waiting_data','published_data','years'));
    }

    public function pertahun(Request $request)
    {
        $revising = Post::selectRaw('count(id) as jumlah,date(created_at) as tanggal')
            ->where('status','2')
            ->whereYear('created_at',$request->tahun)
            ->groupBy('tanggal')
            ->get();
        $pending = Post::selectRaw('count(id) as jumlah,date(created_at) as tanggal')
            ->where('status','0')
            ->whereYear('created_at',$request->tahun)
            ->groupBy('tanggal')
            ->get();
        $waiting = Post::selectRaw('count(id) as jumlah,date(created_at) as tanggal')
            ->where('status','1')
            ->whereYear('created_at',$request->tahun)
            ->groupBy('tanggal')
            ->get();
        $published = Post::selectRaw('count(id) as jumlah,date(created_at) as tanggal')
            ->where('status','3')
            ->whereYear('created_at',$request->tahun)
            ->groupBy('tanggal')
            ->get();

        $revising_data = $this->chartArray($revising);
        $pending_data = $this->chartArray($pending);
        $waiting_data = $this->chartArray($waiting);
        $published_data = $this->chartArray($published);

        return response()->json([$revising_data,$pending_data,$waiting_data,$published_data]);
    }

    public function perbulan(Request $request)
    {
        $revising = Post::selectRaw('count(id) as jumlah,date(created_at) as tanggal')
            ->where('status','2')
            ->whereMonth('created_at',$request->bulan)
            ->groupBy('tanggal')
            ->get();
        $pending = Post::selectRaw('count(id) as jumlah,date(created_at) as tanggal')
            ->where('status','0')
            ->whereMonth('created_at',$request->bulan)
            ->groupBy('tanggal')
            ->get();
        $waiting = Post::selectRaw('count(id) as jumlah,date(created_at) as tanggal')
            ->where('status','1')
            ->whereMonth('created_at',$request->bulan)
            ->groupBy('tanggal')
            ->get();
        $published = Post::selectRaw('count(id) as jumlah,date(created_at) as tanggal')
            ->where('status','3')
            ->whereMonth('created_at',$request->bulan)
            ->groupBy('tanggal')
            ->get();

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
