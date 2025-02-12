@extends('frontends.layouts.master')

@section('title', $news->title)
@section('description', $news->description_seo)
@section('keywords', $news->keyword_seo)
@section('og_title', $news->name)
@section('og_description', $news->description_seo)

@section('content')
    <div id="content" class="blog-wrapper blog-single page-wrapper">
        <div class="row row-large">
            <div class="large-9 col">
                <article id="post-2873"
                    class="post-2873 post type-post status-publish format-standard has-post-thumbnail hentry category-tin-tuc">
                    <div class="article-inner">
                        <header class="entry-header">
                            <div class="entry-header-text entry-header-text-top text-left">
                                <h6 class="entry-category is-xsmall">
                                    <a href="" rel="category tag">Tin tức</a>
                                </h6>
                                <h1 class="entry-title">
                                    {{ $news->title }}
                                </h1>
                                <div class="entry-divider is-divider small"></div>
                            </div>
                        </header>
                        <div class="entry-content single-page">
                            {!! $news->content !!}
                        </div>
                    </div>
                </article>

            </div>
            <div class="post-sidebar large-3 col">
                <div id="secondary" class="widget-area" role="complementary">
                    <aside id="flatsome_recent_posts-2" class="widget flatsome_recent_posts">
                        <span class="widget-title"><span>Bài viết mới</span></span>
                        <div class="is-divider small"></div>
                        <ul>
                            @forelse ($latestNews as $new)
                                <li class="recent-blog-posts-li">
                                    <div class="flex-row recent-blog-posts align-top pt-half pb-half">
                                        <div class="flex-col mr-half">
                                            <div class="badge post-date badge-square">
                                                <div class="badge-inner bg-fill"
                                                    style="
                                        background: url({{ asset('storage/' . $new->image) }});
                                        border: 0;
                                        ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-col flex-grow">
                                            <a href="{{ route('news.list', ['slug' => $new->slug]) }}"
                                                title="{{ $new->title }}">{{ $new->title }}</a>
                                            <span class="post_comments op-7 block is-xsmall"><a
                                                    href="{{ route('news.list', ['slug' => $new->slug]) }}/#respond"></a></span>
                                        </div>
                                    </div>
                                </li>
                            @empty
                            @endforelse

                        </ul>
                    </aside>
                </div>
            </div>
        </div>
    </div>
@endsection
