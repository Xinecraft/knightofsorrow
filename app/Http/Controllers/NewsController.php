<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\News;
use App\Notification;
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

        /*$news  = News::where('summary',$slug)->first();

        if($news)
        {
            $slug = str_limit(str_slug($request->title),50)."-".time()."--author-{$request->user()->username}";
        }*/

        $news = $request->user()->news()->create([
            'title' => $request->title,
            'text' => $request->text,
            'summary' => $slug,
            'is_published' => true,
            'news_type' => $request->news_type,
        ]);

        // Create notification
        $not = new Notification();
        $not->from($request->user())
            ->withType('NewsCreated')
            ->withSubject('A news is created')
            ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has created a news ".link_to_route('news.show',str_limit($news->title,100),$news->summary))
            ->withStream(true)
            ->regarding($news)
            ->deliver();

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
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $news = $this->news->findOrFail($id);
        return view('news.edit')->withNews($news);
    }

    /**
     * @param $id
     * @param NewsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id,NewsRequest $request)
    {
        $getNews = $this->news->findOrFail($id);

        $slug = str_limit(str_slug($request->title),50)."--author-{$request->user()->username}";

        /*$news  = News::where('summary',$slug)->first();

        if($news)
        {
            $slug = str_limit(str_slug($request->title),50)."-".time()."--author-{$request->user()->username}";
        }*/


        $news = $getNews->update([
            'title' => $request->title,
            'text' => $request->text,
            'summary' => $slug,
            'is_published' => true,
            'news_type' => $request->news_type,
        ]);

        return redirect()->route('news.show',$slug)->with('message','News Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        if(!$request->url()->isSuperAdmin())
        {
            return redirect()->back()->with('error','Not enough permissions');
        }

        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->back()->with('message','News deleted!');
    }
}
