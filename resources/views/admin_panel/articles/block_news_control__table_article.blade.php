@if(isset($data))
    <div class="block_flash"></div>

    @foreach($data as $d)





        <div class="pages_nth">
        <div>{{$d->title}}</div>
        <div class="date_add">{{$d->created_at}}</div>
        <div class="type">{{$d->type_articlesss->name}}</div>
        <div class="date_public">@if(isset($d->date_advice))
                {{$d->date_advice}}
            @else
                {{$d->created_at}}
            @endif
        </div>
        <div class="visible">@if(isset($d->status))
                @if($d->status==true)
                    Да
                @else
                    Нет
                @endif
            @endif
        </div>
    </div>
    <div class="control_page">
        <a href="{{route('articles.show',[$d->id])}}"><button class="save"><span>Открыть</span></button></a>
        <a href="{{route('admin_panel.articles.edit',[$d->id])}}"><button class="edit"><span>Редактировать</span></button></a>
        <a title="{{$d->id}}" class="add_article" href="#"><button class="delete"><span>Додати на головну</span></button></a>
    </div>




    @endforeach
    {{$data->links()}}
@endif