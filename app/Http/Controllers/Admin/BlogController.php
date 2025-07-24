<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseBlogController;
use Illuminate\Http\Request;

class BlogController extends BaseBlogController
{
    public function autoNews(Request $request)
    {
        return $this->getBlogData(
            $request,
            1,                          // type_id for Auto News
            'Admin.Blog.blog_list',     // Blade view
            'autoNews',                 // Route name
            'Auto News'                 // Title name
        );
    }


    public function reviews(Request $request)
    {
        return $this->getBlogData(
            $request,
            2,
            'Admin.Blog.blog_list',
            'reviews',
            'Reviews'
        );
    }

    public function toolsAndAdvice(Request $request)
    {
        return $this->getBlogData(
            $request,
            3,
            'Admin.Blog.blog_list',
            'toolsAndAdvice',
            'Tools and Advice'
        );
    }

    public function carBuyingAdvice(Request $request)
    {
        return $this->getBlogData(
            $request,
            4,
            'Admin.Blog.blog_list',
            'carBuyingAdvice',
            'Car Buying Advice'
        );
    }

    public function carTips(Request $request)
    {
        return $this->getBlogData(
            $request,
            5,
            'Admin.Blog.blog_list',
            'carTips',
            'Car Tips'
        );
    }

    public function news(Request $request)
    {
        return $this->getBlogData(
            $request,
            8,
            'Admin.Blog.blog_list',
            'news',
            'News'
        );
    }

    public function innovation(Request $request)
    {
        return $this->getBlogData(
            $request,
            9,
            'Admin.Blog.blog_list',
            'innovation',
            'Innovation'
        );
    }

    public function opinion(Request $request)
    {
        return $this->getBlogData(
            $request,
            10,
            'Admin.Blog.blog_list',
            'opinion',
            'Opinion'
        );
    }

    public function financial(Request $request)
    {
        return $this->getBlogData(
            $request,
            11,
            'Admin.Blog.blog_list',
            'financial',
            'Financial'
        );
    }
}
