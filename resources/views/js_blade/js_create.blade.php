<script type="text/javascript">
    let ArrFiles = [];
    let id_dell_file = '';
    let ArrImages = [];
    let id_dell_image = '';

    /////////////////////////////////////////////////////////////////////////////////////////////////////
    // Блок загрузки файлов
    jQuery(document).ready(function($) {
        Dropzone.options.dropzone =
            {
                maxFilesize: 10,
                renameFile: function (file) {
                    return file.name
                },
                acceptedFiles: ".doc, .docx, .txt, .pdf, .rar, .zip, .xlsx, .xlsm .xls",
                addRemoveLinks: true,
                parallelUploads: 1,
                timeout: 200000,
                removedfile: function(file)
                {
                    var name = file.upload.filename;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ url("files/delete") }}',
                        data: {filename: name},
                        success: function (data){
                            id_dell_file = data;
                            dell_files(id_dell_file);
                        },
                        error: function(e) {
                        }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
                },
                success: function (file, response) {
                    add_files(response['id_file']);
                },
                error: function (file, response) {

                    $('.alert-danger:first').html("<ul><li>Ошибка загрузки файла: </li><li>"+response.name+"</li></ul>");
                    $('.alert-danger:first').show();
                    return false;
                }
            };

        //Добавление id файлов
        function add_files(f) {
            ArrFiles.push(f);
            $('#in_files').val(ArrFiles);
        }

        // удаление id файлов
        function dell_files(f) {
            // let n = 0;
            for (let i =0; i<ArrFiles.length; i++){
                if(ArrFiles[i]==f){
                    ArrFiles.splice(i,1)
                }
            }
            $('#in_files').val(ArrFiles);
        }

/////////////////////////////////////////////////////////////////////////////////////////////////////
        // Блок загрузки изображений
        Dropzone.options.dropzoneImg =
            {
                maxFilesize: 10,
                renameFile: function (file) {
                    return file.name
                },
                acceptedFiles: ".jpg, .png, .heic, .HEIC, .JPEG",
                addRemoveLinks: true,
                resizeQuality: 0.7,
                parallelUploads: 1,
                timeout: 200000,
                removedfile: function(file)
                {
                    var name = file.upload.filename;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ url("images/delete") }}',
                        data: {filename: name},
                        success: function (data){
                            id_dell_image = data;
                            dell_images(id_dell_image);
                        },
                        error: function(e) {

                        }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
                },
                success: function (file, response) {
                    add_images(response['id_image']);
                },
                error: function (response) {
                    $('.alert-danger:last').html("<ul><li>Ошибка загрузки изображения: </li><li>"+response.name+"</li></ul>");
                    $('.alert-danger:last').show();
                    return false;
                }
            };

        //Добавление id изображений
        function add_images(f) {
            ArrImages.push(f);
            $('#in_images').val(ArrImages);
        }

        // удаление id изображений
        function dell_images(f) {
            for (let i =0; i<ArrImages.length; i++){
                if(ArrImages[i]==f){
                    ArrImages.splice(i,1)
                }
            }
            $('#in_images').val(ArrImages);
        }


/////////////////////////////////////////////////////////////////////////////////////////////////////
        // Блок удаления ранее загруженых изображений и файлов
        // Удаление файлов
        $('.fdelete').on('submit', function(){
            event.preventDefault();
            let form = this;
            let id = this.id.value
            event.preventDefault();
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{  route('files/delete') }}',
                    data: {'id': id},
                    cache: false,
                    type: 'POST',
                    success: function (dataofconfirm) {
                        form.style.display = 'none';
                        // $('.bcomment').html(dataofconfirm)
                        $('.wrap_comments').html(dataofconfirm.html);
                        $('.block_flash').html(dataofconfirm.message);
                    },
                    error: function (file, response) {
                        return "Ошибка!";
                    },
                }
                // do something with the result}}
            )
        });

        // Удаление изображений
        $('.idelete').on('submit', function(){
            event.preventDefault();
            let form = this;
            let id = this.id.value
            /*  var myform = document.getElementsByClassName("fdelete");*/
            /*   var fd = new FormData(this);
             */
            event.preventDefault();
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{  route('images/delete') }}',
                    data: {'id': id},
                    cache: false,
                    type: 'POST',
                    success: function (dataofconfirm) {
                        form.style.display = 'none';
                        // $('.bcomment').html(dataofconfirm)
                        $('.wrap_comments').html(dataofconfirm.html);
                        $('.block_flash').html(dataofconfirm.message);
                    },
                    error: function (file, response) {
                        return "Ошибка!";
                    },
                }
            )
        });
    });
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

    /////////////////////////////////////////////////////////////////////////////////////////////////////
    // Блок побочных функций
    $(function () {
        $('#id_youtube').on('keyup', function () {
            let url = this.value;
            if(url.indexOf('youtu.be')!=-1){
                url = url.replace("youtu.be/", "www.youtube.com/embed/");
            }
            else {
                url = url.replace("watch?v=", "embed/");
            }
            $('#video_youtube').attr('src', url);
        })

        $('#input_avatar').on('change', function () {
            $('#img_avatar').show();
            $('#img_avatar').attr('src', URL.createObjectURL(this.files[0]));
        })

/*
   if($('#editor-body').length){
            CKEDITOR.replace('editor-body', {
                uiColor: '#c8cbcf',
                width: ['100%'],
                height: ['250px'],
            });
        }
*/
        if($('#editor-body_2').length) {
            CKEDITOR.replace('editor-body_2', {
                uiColor: '#c8cbcf',
                width: ['100%'],
                height: ['500px'],
            });
        }
    })

</script>