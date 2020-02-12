<link rel="stylesheet" href="{{asset('css/_read_more.css')}}">

<div class="wrap_more_block">
    <div class="type_block">ЧИТАЙТЕ ТАКОЖ</div>
<div class="wrap_articles_nth">

@if(isset($articles_more))
    @foreach($articles_more as $d)
            <a  href="{{route('articles.show', $d->id)}}">
        <div class="articles_nth">
            @if(isset($d->img_avatar))
                <div class="img_news">
                    <img src="{{asset("/storage/uploads/images/". date_create($d->created_at)->Format('Y_m') .
                 "/". "avatar/". "small/".$d->img_avatar)}}">
                </div>
            @else
                <div class="img_news">
                    <img src="{{asset("icon/default/latest-news.jpg")}}">
                </div>
            @endif
                <div class="view_date">{{$d->created_at}}</div>
            <div class="title"><span>{{$d->title}}</span></div>
        </div>
            </a>
    @endforeach
@endif
</div>
</div>