<script>
    $(function () {
        $('body').on('click', '.add_article', function(){
            var id_article = $(this).attr('title');
            //  var type_comment = $('.type_comment').html();
            event.preventDefault();
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('admin_panel.blocknews.add') }}',
                    data: {id_article: id_article},
                    cache: false,
                    type: 'POST',
                    success: function (dataofconfirm) {
                        if(dataofconfirm.html!=null)
                            $('.wrap_page_nth[title = "t_a"]').html(dataofconfirm.html);
                        if(dataofconfirm.html2!=null)
                            $('.wrap_page_nth[title = "t_p"]').html(dataofconfirm.html2);
                    },
                    error: function (dataofconfirm) {
                        //$('.block_flash').html(dataofconfirm.message);
                        $('.alert-danger:last').html("<ul><li>Ошибка добавления</li></ul>");
                        $('.alert-danger:last').show();
                    }
                }
            )
        });

        $('body').on('change', '.select_position', function(){
            var id_article = $(this).children("option:selected").val();
            var myobj = JSON.parse(id_article);
            //  var type_comment = $('.type_comment').html();
            event.preventDefault();
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('admin_panel.blocknews.edit') }}',
                    data: {id_article: myobj.id_article, index_position: myobj.index_val},
                    cache: false,
                    type: 'POST',
                    success: function (dataofconfirm) {
                        //   $('.wrap_comments').html(dataofconfirm.html);
                        //    $('.block_flash').html(dataofconfirm.message);
                    },
                    error: function (dataofconfirm) {
                        // $('.block_flash').html(dataofconfirm.message);
                        $('.alert-danger:first').html("<ul><li>Ошибка изменения позиции: </li></ul>");
                        $('.alert-danger:first').show();
                    }
                }
                // do something with the result}}
            )
        });
    })

    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>