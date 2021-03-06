<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Contact;
use App\Models\Article;
use App\Models\Service;

class SiteController extends Controller
{
    public function index($url = "")
    {
        $pages = Page::oldest("position")->get();
        $articles = Article::latest();

        $result=[
          'contact'=>Contact::first(),
          'services'=> Service::latest()->get(),
          'pages'=>$pages,
          'articles'=>$articles->take(3)->get(),

        ];

        switch ($url) {
            case(""):
                $view ="home";
                $page = $pages->where("route", "");
                break;
            case("uslugi"):
                $view ="services";
                $page = $pages->where("route", "uslugi");
                break;
            case("novosti"):
                $view = "articles";
                $page = $pages->where("route", "novosti");
                $result+=[
                    "articles_paginate"=>$articles->paginate(9),
                ];
                break;
            case("o-nas"):
                $view = "about";
                $page = $pages->where("route", "o-nas");

                break;
            case("kontakty"):
                $view = "contacts";
                $page = $pages->where("route", "kontakty");

        }

        $result+=[
            'view'=>$view,
            'page'=>$page->first(),
        ];



        return view($view, $result);
    }
}
