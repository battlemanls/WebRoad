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


    /*    $(".menu__mobile_none>ul>li").hover(
            function () {
                $(">ul", this).stop().slideDown(400);
            },

            function () {
                $('>ul', this).stop().slideUp(400);
            })*/


    /////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////Выпадающее мобильное меню
    var remont = null;

    $('.menu__mobile_none>ul>li:not(:first-child)>a').removeAttr("href");
    $('.menu__mobile_none>ul>li:nth-child(5)>ul>li:first-child>a').removeAttr("href");
    $('.menu__mobile_none>ul>li:nth-child(3)>ul>li>a').removeAttr("href");

    //////////////////

    /////Блок выпадющего подменю с регионами
    $('.menu__mobile_none>ul>li:nth-child(3)>ul>li').on('click', function () {
        remont = (this.parentElement);
        if ( $(">ul", this).css('display') == 'block' ) {


            $(">ul", this).slideUp(400);
        }else{


            $(">ul", this).stop().slideDown(400);
            $(">a", this).stop();
        }
    });


    //////////////////
    /////Блок выпадющего подменю с ремонтными работами
    $('.menu__mobile_none>ul>li:nth-child(5)>ul>li:first-child').on('click', function () {
        remont = (this.parentElement);
        if ( $(">ul", this).css('display') == 'block' ) {


            $(">ul", this).slideUp(400);
        }else{


            $(">ul", this).stop().slideDown(400);
            $(">a", this).stop();
        }
    });

    //////////////////
    /////Блок выпадющего меню
    $('.menu__mobile_none>ul>li').on('click', function () {
        if ( $(">ul", this).css('display') == 'block' ) {
            $(">ul", this).not(remont).slideUp(400);
            remont = null;
        }else{
            $(">ul", this).stop().slideDown(400);
            $(">a", this).stop();
        }
    });

    /*      $(".wrap_head_menu_mobile>ul>li:nth-child(5)>ul>li:first-child>a").removeAttr("href");

          $(".wrap_head_menu_mobile>ul>li").hover(
              function () {
                  $(">ul", this).stop().slideDown(400);
              },

              function () {
                  $('>ul', this).stop().slideUp(400);
              })



          let nav1 = $('.wrap_head_menu_mobile>ul');
          $(nav1).on('mouseleave', function () {
              $(".wrap_head_menu_mobile>ul>li:nth-child(5)>ul>li:first-child>ul").hide();
          });

          $('.wrap_head_menu_mobile>ul>li:nth-child(5)>ul>li:first-child>').on('click', function () {
              $(".wrap_head_menu_mobile>ul>li:nth-child(5)>ul>li:first-child>ul").slideDown();
          });


  */

    $('.wrap_head_menu>ul>li:not(:first-child)>a').removeAttr("href");

    $(".wrap_head_menu>ul>li:nth-child(3)>ul>li>a").removeAttr("href");
    $(".wrap_head_menu>ul>li:nth-child(5)>ul>li:first-child>a").removeAttr("href");

    $(".wrap_head_menu>ul>li").hover(
        function () {
            $(">ul", this).stop().slideDown(400);
        },

        function () {
            $('>ul', this).stop().slideUp(400);

        });



    let nav = $('.wrap_head_menu>ul');
    $(nav).on('mouseleave', function () {
        $(".wrap_head_menu>ul>li:nth-child(5)>ul>li:first-child>ul").hide();
    });



    $('.wrap_head_menu>ul>li:nth-child(5)>ul>li:first-child>').on('click', function () {
        if ( $(".wrap_head_menu>ul>li:nth-child(5)>ul>li:first-child>ul").css('display') == 'block' ) {
            $(".wrap_head_menu>ul>li:nth-child(5)>ul>li:first-child>ul").slideUp()
        }else {
            $(".wrap_head_menu>ul>li:nth-child(5)>ul>li:first-child>ul").slideDown();
        }
    });

    $('.wrap_head_menu>ul>li:nth-child(3)>ul>li').on('click', function () {
        if ( $(">ul",this).css('display') == 'block' ) {
            $(">ul",this).slideUp();
        }else {

            $(">ul",this).slideDown();
        }
    });


});

