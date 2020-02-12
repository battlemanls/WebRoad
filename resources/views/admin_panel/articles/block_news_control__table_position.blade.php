
@if(isset($block_news))
    @foreach($block_news as $b)


        @if(isset($b->date_advice_end) && strtotime($b->date_advice_end) < strtotime(date("Y-m-d"))
        || isset($b->date_advice) && strtotime($b->date_advice) > strtotime(date("Y-m-d"))
        || $b->status==0

        )
        <div class="pages_nth" style="background: red">
        <div><b>Новина схована (дата приховування/опублікування або статус публікаціїї)</b></div>
        @else
            <div class="pages_nth">
        @endif
            <div >{{$b->title}}</div>


        <div class="date_public">@if(isset($b->date_advice))
                {{$b->date_advice}}
            @else
                {{$b->created_at}}
            @endif
        </div>
        <div class="position">
            <select class="select_position" name="type_search">
                @if(isset($b->block_newsss->index_position))
                    <option selected value="{{$b->block_newsss->index_position}}">Обрано: {{$b->block_newsss->index_position}}</option>
                @else
                    <option selected value='0'>0</option>
                @endif
                <option value='{"id_article":"{{$b->id}}","index_val":"1"}'>1</option>
                <option value='{"id_article":"{{$b->id}}","index_val":"2"}'>2</option>
                <option value='{"id_article":"{{$b->id}}","index_val":"3"}'>3</option>
                <option value='{"id_article":"{{$b->id}}","index_val":"4"}'>4</option>
                <option value='{"id_article":"{{$b->id}}","index_val":"5"}'>5</option>
                <option value='{"id_article":"{{$b->id}}","index_val":"6"}'>6</option>
                <option value='{"id_article":"{{$b->id}}","index_val":"7"}'>7</option>
                <option value='{"id_article":"{{$b->id}}","index_val":"8"}'>8</option>
            </select>

            </div>
        </div>

    <div class="control_page">
        <a href="{{route('articles.show',[$b->id])}}"><button class="save"><span>Открыть</span></button></a>
        <a href="{{route('admin_panel.articles.edit',[$b->id])}}"><button class="edit"><span>Редактировать</span></button></a>
        <form method = 'post' action="{{ route('admin_panel.blocknews.delete', $b->id ) }}" >
            @csrf
            {{method_field('DELETE')}}
            <button type="submit" class="delete"><span>Вилучити</span></button>
        </form>
    </div>





    @endforeach
    {{$block_news->links()}}
@endif