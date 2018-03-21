<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use PDF;
use App\Models\Post;

class ExportController extends Controller
{
    public function post_excel(Request $request)
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
    		$posts = Post::latest()->get();
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

    public function post_pdf(Request $request)
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
            $posts = Post::latest()->get();
        }

        //return view('export.postpdf',compact('posts'));
        $pdf = PDF::loadView('export.postpdf',compact('posts'));
        return $pdf->stream('laporan.pdf');
    }

    public function post_word(Request $request)
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
            $posts = Post::latest()->get();
        }

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $sectionStyle = array(
            'orientation'=>'portrait');
        $section = $phpWord->addSection($sectionStyle);
        foreach($posts as $p) {
            $section->addText($p->title);
            $section->addText('by '.$p->user->name);
            $section->addText($p->created_at->format('M d, Y \a\t h:i A'));
            $section->addText('Category: '.$p->category->name);
            //$section->addImage(asset('storage',substr($p->image,6)),array('width'=>400));
            $section->addText(strip_tags($p->content));
            $section->addPageBreak();
        }
        $footer = $section->addFooter();
        $footer->addPreserveText('Page {PAGE} of {NUMPAGES}',null,array('align'=>'center'));
        $phpWord->save('laporan.docx', 'Word2007', true);
        /*try {
            $objWriter->save(storage_path('laporan.docx'));
        } catch (Exception $e) {}
        return response()->download(storage_path('laporan.docx'));*/
    }
}