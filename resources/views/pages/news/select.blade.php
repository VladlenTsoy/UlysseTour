@extends('layouts.app')

@section('content')
    <div class="container block-content">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class=" title-block text-center">
                        <span class="title-single">{{$news->title}}</span>
                    </div>
                </div>
                <div class="col-md-8">
                    {!! $news->description !!}
                </div>
                <div class="col-md-4">
                    <p><b>{{$lang->data->lasted}}</b></p>
                    @foreach($new_news as $news)
                        <div class="block-news-more row">
                            <div class="col-4 image"
                                 style="background: var(--greyColor) url({{asset($news->image)}}) center no-repeat;
                                         background-size: cover;"
                            ></div>
                            <div class="col-7">
                                <span class="title">{{$news->title}}</span>
                                <p class="desc-content">
                                    {{$news->min_description}}
                                </p>
                            </div>
                            <div class="col-1 action">
                                <a href="/{{$lang->title}}/news/{{$news->id}}"><img src="{{asset('./images/arrow-right.svg')}}" alt="" width="100%"></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12">
            <hr>
            <div id="disqus_thread"></div>
            <script>

                /**
                 *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                 *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
                /*
                var disqus_config = function () {
                this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                };
                */
                (function() { // DON'T EDIT BELOW THIS LINE
                    var d = document, s = d.createElement('script');
                    s.src = 'https://ulyssetour-com.disqus.com/embed.js';
                    s.setAttribute('data-timestamp', +new Date());
                    (d.head || d.body).appendChild(s);
                })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

        </div>
    </div>
@endsection
