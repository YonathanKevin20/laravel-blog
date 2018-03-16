<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Models\Post;

class ExportController extends Controller
{
    public function index()
    {
    	/*
    	$posts = Post::all()->toArray();
		return Excel::create('export'.date('Y-m-d'),function($excel) use($posts) {
			$excel->sheet('shit1',function($sheet) use($posts) {
				$sheet->fromArray($posts);
			});
		})->download("xlsx");
		*/
		return Excel::export(new Export);
    }
}