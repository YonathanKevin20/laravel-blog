<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id'];

    public function category() {
    	return $this->belongsTo('App\Models\Category');
    }

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function revision() {
    	return $this->hasMany('App\Models\Revision');
    }

    public function panel_count($status,$id) {
        return $this->where('status',$status)
                ->whereHas('user', function($query) use($id) {
                    $query->where('id',$id);
                })->get();
    }

    public function chart($status) {
        return $this->selectRaw('count(id) as jumlah,date(created_at) as tanggal')
                ->where('status',$status)
                ->groupBy('tanggal')
                ->get();
    }

    public function chart_pertahun($status,$year) {
        return $this->selectRaw('count(id) as jumlah,date(created_at) as tanggal')
            ->where('status',$status)
            ->whereYear('created_at',$year)
            ->groupBy('tanggal')
            ->get();
    }

    public function chart_perbulan($status,$month) {
        return $this->selectRaw('count(id) as jumlah,date(created_at) as tanggal')
            ->where('status',$status)
            ->whereMonth('created_at',$month)
            ->groupBy('tanggal')
            ->get();
    }
}