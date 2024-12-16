@extends('frontends.layouts.master')

@section('content')
<div id="content" class="blog-wrapper blog-archive page-wrapper">
    <header class="archive-page-header">
        <div class="row">
            <div class="large-12 text-center col">
                <h1 class="page-title is-large uppercase">
                    <span>Tin tức</span>
                </h1>
            </div>
        </div>
    </header>

    <div class="row row-large">
        <div class="large-9 col">
            <div id="row-1845589467" class="row large-columns-3 medium-columns- small-columns-1 row-masonry"
                data-packery-options='{"itemSelector": ".col", "gutter": 0, "presentageWidth" : true}'>
                @forelse ($news as $new )
                <div class="col post-item">
                    <div class="col-inner">
                        <a href="{{ route('news.list', ['slug' => $new->slug]) }}"
                            class="plain">
                            <div class="box box-text-bottom box-blog-post has-hover">
                                <div class="box-image">
                                    <div class="image-cover" style="padding-top: 56%">
                                        <img width="300" height="225"
                                            src="data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%20300%20225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3C%2Fsvg%3E"
                                            data-src="{{ asset('storage/'.$new->image) }}"
                                            class="lazy-load attachment-medium size-medium wp-post-image"
                                            alt="{{ $new->title_seo }}" decoding="async" srcset=""
                                            data-srcset="{{ asset('storage/'.$new->image) }} 300w, {{ asset('storage/'.$new->image) }} 768w, {{ asset('storage/'.$new->image) }} 600w, {{ asset('storage/'.$new->image) }} 800w"
                                            sizes="auto, (max-width: 300px) 100vw, 300px" />
                                    </div>
                                </div>
                                <div class="box-text text-left">
                                    <div class="box-text-inner blog-post-inner">
                                        <h5 class="post-title is-large">
                                            {{ $new->title }}
                                        </h5>
                                        <div class="is-divider"></div>
                                        <p class="from_the_blog_excerpt">
                                            {{ Str::limit(html_entity_decode(strip_tags($new->content)), 70, '...') }}
                                        </p>

                                    </div>
                                </div>
                                <div class="badge absolute top post-date badge-square">
                                    <div class="badge-inner">
                                        <span class="post-date-day">21</span><br />
                                        <span class="post-date-month is-xsmall">Th7</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @empty

                @endforelse


            </div>
            @if ($news->hasPages())
                <ul class="page-numbers nav-pagination links text-center">
                    @if ($news->onFirstPage())
                        <li>
                            <span class="page-number disabled" aria-disabled="true"><i class="icon-angle-left"></i></span>
                        </li>
                    @else
                        <li>
                            <a class="page-number prev" href="{{ $news->previousPageUrl() }}"><i
                                    class="icon-angle-left"></i></a>
                        </li>
                    @endif


                    @foreach ($news->onEachSide(1)->elements() as $element)

                        @if (is_string($element))
                            <li>
                                <span class="page-number dots">{{ $element }}</span>
                            </li>
                        @endif


                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $news->currentPage())
                                    <li>
                                        <span aria-current="page" class="page-number current">{{ $page }}</span>
                                    </li>
                                @else
                                    <li>
                                        <a class="page-number" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach


                    @if ($news->hasMorePages())
                        <li>
                            <a class="page-number next" href="{{ $news->nextPageUrl() }}"><i class="icon-angle-right"></i></a>
                        </li>
                    @else
                        <li>
                            <span class="page-number disabled" aria-disabled="true"><i class="icon-angle-right"></i></span>
                        </li>
                    @endif
                </ul>
            @endif

        </div>
        <div class="post-sidebar large-3 col">
            <div id="secondary" class="widget-area" role="complementary">
                <aside id="flatsome_recent_posts-2" class="widget flatsome_recent_posts">
                    <span class="widget-title"><span>Bài viết mới</span></span>
                    <div class="is-divider small"></div>
                    <ul>
                        @forelse ($latestNews as $new )
                            <li class="recent-blog-posts-li">
                                <div class="flex-row recent-blog-posts align-top pt-half pb-half">
                                    <div class="flex-col mr-half">
                                        <div class="badge post-date badge-square">
                                            <div class="badge-inner bg-fill" style="
                                        background: url({{ asset('storage/'.$new->image) }});
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
<style>
    .from_the_blog_excerpt {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* Giới hạn tối đa 2 dòng */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        /* Thêm "..." khi vượt quá */
        line-height: 1.6em;
        /* Chiều cao dòng (tùy chỉnh theo thiết kế) */
        max-height: 3.2em;
        /* 2 dòng x line-height */
        word-wrap: break-word;
        /* Tự động xuống dòng nếu cần */
    }
</style>
@endsection
