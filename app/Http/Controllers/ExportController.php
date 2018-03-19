<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Models\Post;

class ExportController extends Controller
{
    public function post(Request $request)
    {
    	if(isset($request->search)) {
            $posts = Post::where(function($query) use($request) {
                $query->where('title','like',"%$request->search%")
                    ->orWhere('slug','like',"%$request->search%")
                    ->orWhere('content','like',"%$request->search%")
                    ->orWhereHas('category', function($query) use($request) {
                        $query->where('name','like',"%$request->search%");
                    })
                    ->orWhereHas('user', function($query) use($request) {
                        $query->where('name','like',"%$request->search%");
                    });
                })
                ->latest()
                ->get();
    	}
    	else {
    		$posts = Post::all();
    	}

		$i = 1;
		foreach($posts as $p) {
			$data[] = array($i,$p->title,$p->category->name,$p->user->name,strip_tags(post_status($p->status)),$p->created_at->format('M d, Y \a\t h:i A'));
			$i++;
		}

		return Excel::create('posts-'.date('Y-m-d'), function($excel) use($data) {
			$excel->setTitle('posts-'.date('Y-m-d'));
			$excel->setCreator(config('app.name','blog'))->setCompany(config('app.name','blog'));
			$excel->setDescription('');
			$excel->setKeywords('');
		    $excel->sheet('Sheet1', function($sheet) use($data) {
		    	$sheet->cell('A1','No.');
		    	$sheet->cell('B1','Title');
		    	$sheet->cell('C1','Category');
		    	$sheet->cell('D1','User');
		    	$sheet->cell('E1','Status');
		    	$sheet->cell('F1','Created at');
		    	$sheet->fromArray($data,null,'A2',false,false);
		    });
		})->export('xlsx');
    }
}