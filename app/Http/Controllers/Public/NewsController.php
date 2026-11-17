<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::published()->paginate(9);
        return view('news.index', compact('news'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $relatedNews = News::where('id', '!=', $news->id)
            ->where('status', 'published')
            ->take(3)
            ->get();
        return view('news.show', compact('news', 'relatedNews'));
    }
}