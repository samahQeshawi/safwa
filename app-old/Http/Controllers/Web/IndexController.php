<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function show(Request $request)
    {
        // $lang_id = session()->has('langID') ? session()->get('langID') : 1;
        // $data = DB::table('posts')
        //     ->join('posts_descs', 'posts.id', '=', 'posts_descs.post_id')
        //     ->where('posts.post_type', '=', 'F' )
        //     ->where('posts.publish', '=' , '1')
        //     ->where('posts_descs.lang_id', $lang_id )
        //     ->select('posts.*', 'posts_descs.title' , 'posts_descs.content')
        //     ->orderBy('id' , 'desc')
        //     ->get();

        // dd($data);
        // return view('web._index' , [
        //     'page_title' => trans('website.home') ,
        //     'page_description' => trans('website.home') ,
        //     'page_keywords' => trans('website.web_title') ,
        // ]);
        return view('web.index' , [
            'page_title' => trans('web.home') ,
            'page_description' => trans('web.home') ,
            'page_keywords' => trans('web.web_title') ,
        ]);

    }

}
