<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\News;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    /**
     * @var News
     */
    protected $news;

    /**
     * NewsController constructor.
     * @param News $news
     */
    public function __construct(News $news)
    {
        $this->news = $news;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $newses = ($this->news->allPublished());
        return view('news.index')->with('newses',$newses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewsRequest $request
     * @return Response
     */
    public function store(NewsRequest $request)
    {
        $slug = str_limit(str_slug($request->title),50)."--author-{$request->user()->username}";

        $news  = News::where('summary',$slug)->first();

        if($news)
        {
            $slug = str_limit(str_slug($request->title),50)."-".time()."--author-{$request->user()->username}";
        }

        $news = $request->user()->news()->create([
            'title' => $request->title,
            'text' => $request->text,
            'summary' => $slug,
            'is_published' => true,
        ]);

        return redirect()->route('news.show',$news->summary)->with('message','News Created');
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return Response
     */
    public function show($slug)
    {
        $news  = News::where('summary',$slug)->first();
        return view('news.show')->withNews($news);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
