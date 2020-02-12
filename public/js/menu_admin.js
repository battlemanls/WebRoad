
$(function () {

    var menu = $('.menu__mobile_none');
    $('.menu__icon').on('click', function () {
        if($(menu).hasClass('menu__mobile_none')) {
            menu.removeClass('menu__mobile_none');
            menu.toggleClass('menu__mobile');
        }
        else{
            menu.removeClass('menu__mobile');
            menu.toggleClass('menu__mobile_none');
        }
    });



    $('.menu__mobile_none:first-child>ul>li:not(:first-child, :nth-child(4), :nth-child(5), :nth-child(6))>a').removeAttr("href");
    $('.menu__mobile_none>ul>li').on('click', function () {

        if ( $(">ul", this).css('display') == 'block' ) {
            $(">ul", this).slideUp(400);
        }else{
            $(">ul", this).stop().slideDown(400);
            $(">a", this).stop();
        }

    });

    $(".wrap_head_menu>ul>li:nth-child(5)>ul>li:first-child>a").removeAttr("href");

    $(".wrap_head_menu>ul>li").hover(
        function () {
            $(">ul", this).stop().slideDown(400);
        },

        function () {
            $('>ul', this).stop().slideUp(400);
        })



    let nav = $('.wrap_head_menu>ul');
    $(nav).on('mouseleave', function () {
        $(".wrap_head_menu>ul>li:nth-child(5)>ul>li:first-child>ul").hide();
    });

    $('.wrap_head_menu>ul>li:nth-child(5)>ul>li:first-child>').on('click', function () {
        $(".wrap_head_menu>ul>li:nth-child(5)>ul>li:first-child>ul").slideDown();
    });
});
