@extends('layouts.admin')

<link rel="stylesheet" href="{{asset('css/admin_panel/create.css')}}">

@section('content')
    <div class="wrap_content">
        @if(isset($data->title))
            <h2>Редагування публікації</h2>
        @else
            <h2>Добавление публікації</h2>
        @endif

        <div class="wrap_block">
            <form id='my_form' name="my_form" action="{{route('admin_panel.stan_dorig.store')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div>
                    <label>Назва:</label>
                    <div>
                        @if($errors->get('title')!=null)
                            <label class="alert-danger_mini">{{$errors->get('title')[0]}}</label>
                        @endif
                    @if(isset($data->title))
                        <input required  maxlength="191" placeholder="Назва метеріалу" name = 'title' value="{{$data->title}}">
                        @else
                        <input required  maxlength="191" placeholder="Назва метеріалу" name = 'title'>
                    @endif
                    </div>
                </div>

                <div>
                    <label>Обложка: (.jpg, .png .heic) </label>
                    <div>
                        @if(isset($data->img_avatar))
                            <div> <img id="img_avatar" src="{{asset("/storage/uploads/images/". date_create($data->created_at)->Format('Y_m')
                            . "/". "avatar/". "big/".$data->img_avatar)}}" title="{{$data->img_avatar}}"></div>
                            <input  accept=".jpg, .jpeg, .png, .heic" id="input_avatar" type="file" name="img_avatar" value="{{$data->img_avatar}}">
                        @else
                            <div> <img id="img_avatar" src="" hidden></div>
                            <input  accept=".jpg, .jpeg, .png, .heic" id="input_avatar" type="file" name="img_avatar">
                        @endif
                    </div>
                </div>

                <div>
                    <label>URL: </label>
                    <div>
                        @if(isset($data->url))
                            <input placeholder="https://zp.ukravtodor.gov.ua/primer" type="text" name="url" value="{{$data->url}}">
                        @else
                            <input placeholder="https://zp.ukravtodor.gov.ua/primer" type="text" name="url">
                        @endif
                    </div>
                </div>

            <!-- Скрытые поля -->
                @if(isset($data))
                    <input name="edit" value="edit" hidden>
                    <input name="id" value="{{$data->id}}" hidden>
                    @endif
            </form>

            <div>
                <label>Допуск до перегляду:</label>
                <div class="status">
                    <div>Прихований <span>(перегляд можливий тількі через панель адміністратора)</span></div>
                    @if(isset($data->status)&&$data->status==0)
                        <input form="my_form" class="in_check" name="status" type="checkbox" checked>
                    @else
                        <input  form="my_form" class="in_check" name="status" type="checkbox">
                    @endif
                </div>
            </div>

            <div class="block_submit">
                <button form="my_form" class="button_submit" type="submit">ок</button>
            </div>
        </div>
    </div>

   <!-- Скрипты страницы -->
   @include('js_blade.js_create')

@endsection