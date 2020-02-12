@extends('layouts.my_app')

<link rel="stylesheet" href="{{asset('css/show_article.css')}}">
<script src="{{ asset('js/js_smart_view_images.js') }}" defer></script>
@if(isset($data->title))
    @section('title', $data->title)
@endif

@if(isset($data->meta_description))
@section('description', $data->meta_description)
@endif
@if(isset($data->meta_keywords))
@section('keywords', $data->meta_keywords)
@endif

@section('content')
    <div class="wrap_content">
        <div class="wrap_block">
            <div class="block">
                <div class="type_block">
                <h1>
                    @if(isset($data->title))
                        {!! strip_tags($data->title)!!}
                        @else
                        {{$data->type_roads->name}}-{{$data->regions->name}}
                    @endif
                </h1>
                </div>

                <div class="body_block">
                    @if(isset($data->body))
                        {!!$data->body!!}
                    @endif
                </div>
            </div>
        </div>

        @include('public._read_more')
    </div>

    <!-- Скрипты страницы -->
   <!-- include('js_blade.js_create') -->

@endsection