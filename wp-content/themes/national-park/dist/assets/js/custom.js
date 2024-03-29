(function ($) {
  $(document).ready(function () {
    // for start js
    jQuery('#stars li')
      .on('mouseover', function () {
        var onStar = parseInt(jQuery(this).data('value'), 10); // The star currently mouse on

        // Now highlight all the stars that's not after the current hovered star
        jQuery(this)
          .parent()
          .children('li.star')
          .each(function (e) {
            if (e < onStar) {
              jQuery(this).addClass('hover');
            } else {
              jQuery(this).removeClass('hover');
            }
          });
      })
      .on('mouseout', function () {
        jQuery(this)
          .parent()
          .children('li.star')
          .each(function (e) {
            jQuery(this).removeClass('hover');
          });
      });

    $('#stars li').on('click', function () {
      var onStar = parseInt($(this).data('value'), 10); // The star currently selected
      var stars = $(this).parent().children('li.star');

      for (i = 0; i < stars.length; i++) {
        $(stars[i]).removeClass('selected');
      }

      for (i = 0; i < onStar; i++) {
        $(stars[i]).addClass('selected');
      }

      // JUST RESPONSE (Not needed)
      var ratingValue = parseInt(
        $('#stars li.selected').last().data('value'),
        10
      );
      var msg = 0;
      if (ratingValue) {
        msg = ratingValue;
      }
      responseMessage(msg);
    });

    function responseMessage(msg) {
      $('.success-box').fadeIn(200);
      $('.success-box').html('<span>' + msg + '</span>');
    }

    // select
    var itemValue;

    const selectValue = document.querySelectorAll('#reason option');

    $('.select-dropdown__button').on('click', function () {
      $(this).toggleClass('active');
      $(this).next().toggleClass('active');
    });

    $('.mobile-hamburger-menu .menu-icon').on('click', function () {
      $('.menu-icon').toggleClass('open');
      $('.mobile-menu').toggleClass('open');
      $('body').toggleClass('fixed');
    });

    $('.mobile-menu ul li').on('click', function () {
      $(this).addClass('active').siblings().removeClass('active');
    });

    $('.mobile-menu ul li').each(function (i, elem) {
      if ($(this).find('ul').length > 0) {
        $(this).children('label').append('<i></i>');
      } else {
        $(this).addClass('no-ul');
      }
    });

    $('.select-dropdown__list .select-dropdown__list-item').on(
      'click',
      function () {
        itemValue = $(this).data('value');
        $(this)
          .parent('.select-dropdown__list')
          .prev()
          .children('span')
          .text($(this).text())
          .parent()
          .attr('data-value', itemValue);
        // $(".select-dropdown__button span")
        //   .text($(this).text())
        //   .parent()
        //   .attr("data-value", itemValue);
        $(this).parent('.select-dropdown__list').prev().toggleClass('active');
        $(this).parent('.select-dropdown__list').toggleClass('active');

        selectValue.forEach((ele) => {
          // console.log("itemValue", ele, itemValue, ele.attributes.value.value);
          if (itemValue === ele.attributes.value.value) {
            ele.setAttribute('selected', 'selected');
          }
        });
      }
    );

    jQuery('.home-banner-slider, .did-you-know-slider').slick({
      arrows: true,
      centerPadding: '0px',
      dots: false,
      slidesToShow: 1,
      infinite: false,
    });

    jQuery('.animal-detail-banner-slider').slick({
      arrows: false,
      centerPadding: '0px',
      dots: true,
      slidesToShow: 1,
      infinite: false,
    });

    jQuery('.explore-wild-life-slider').slick({
      arrows: true,
      centerPadding: '250px',
      dots: false,
      slidesToShow: 3,
      centerMode: true,
      responsive: [
        {
          breakpoint: 1500,
          settings: {
            centerPadding: '80px',
          },
        },
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 2,
            centerPadding: '120px',
          },
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 1,
            centerPadding: '180px',
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            centerPadding: '0',
          },
        },
        {
          breakpoint: 250,
          settings: {
            slidesToShow: 1,
            centerPadding: '80px',
          },
        },
      ],
    });

    jQuery('.home .explore-the-diversity-card-wrapper').slick({
      arrows: true,
      dots: false,
      slidesToShow: 4,
      infinite: false,
      responsive: [
        {
          breakpoint: 1500,
        },
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 3,
          },
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 650,
          settings: {
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 250,
          settings: {
            slidesToShow: 1,
          },
        },
      ],
    });

    jQuery('.explore-the-diversity .explore-the-diversity-card-wrapper').slick({
      arrows: true,
      dots: false,
      slidesToShow: 4,
      infinite: false,
      responsive: [
        {
          breakpoint: 1500,
        },
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 3,
          },
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 650,
          settings: {
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 250,
          settings: {
            slidesToShow: 1,
          },
        },
      ],
    });

    jQuery('.home .explore-the-diversity-card-wrapper').slick({
      arrows: true,
      dots: false,
      slidesToShow: 4,
      infinite: false,
      responsive: [
        {
          breakpoint: 1500,
        },
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 3,
          },
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 650,
          settings: {
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 250,
          settings: {
            slidesToShow: 1,
          },
        },
      ],
    });

    jQuery('.explore-wild-life-slider').slick({
      arrows: true,
      centerPadding: '250px',
      dots: false,
      slidesToShow: 3,
      centerMode: true,
      responsive: [
        {
          breakpoint: 1500,
          settings: {
            centerPadding: '80px',
          },
        },
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 2,
            centerPadding: '120px',
          },
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 1,
            centerPadding: '180px',
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            centerPadding: '0',
          },
        },
        {
          breakpoint: 250,
          settings: {
            slidesToShow: 1,
            centerPadding: '80px',
          },
        },
      ],
    });

    jQuery('.see-all-picture-item-wrapper').slick({
      arrows: true,
      dots: false,
      slidesToShow: 3,
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 400,
          settings: {
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 250,
          settings: {
            slidesToShow: 1,
          },
        },
      ],
    });

    jQuery('.hightlight-slider-wrapper').slick({
      arrows: true,
      dots: true,
      slidesToShow: 1,
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            dots: false,
          },
        },
        {
          breakpoint: 400,
          settings: {
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 250,
          settings: {
            slidesToShow: 1,
          },
        },
      ],
    });

    jQuery('.stay-place-slider-wrapper').slick({
      arrows: true,
      dots: false,
      // slidesToShow: 1,
      // infinite: true,
      slidesToScroll: 1,
      variableWidth: true,
      // centerMode: true,
      // centerPadding: '200px',
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            variableWidth: false,
          },
        },
        // {
        //   breakpoint: 250,
        //   settings: {
        //     slidesToShow: 1,
        //     variableWidth: false,
        //   },
        // },
      ],
    });

    jQuery('.national-slider-area').slick({
      arrows: true,
      dots: false,
      slidesToShow: 1,
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 400,
          settings: {
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 250,
          settings: {
            slidesToShow: 1,
          },
        },
      ],
    });

    jQuery('.image-popup-vertical-fit').magnificPopup({
      type: 'image',
      mainClass: 'mfp-with-zoom',
      gallery: {
        enabled: true,
      },

      zoom: {
        enabled: true,

        duration: 300, // duration of the effect, in milliseconds
        easing: 'ease-in-out', // CSS transition easing function

        opener: function (openerElement) {
          return openerElement.is('img')
            ? openerElement
            : openerElement.find('img');
        },
      },
    });

    jQuery('.modal-popup').each(function () {
      jQuery(this).on('click', function () {
        jQuery('.modal').show();
        jQuery('body').css('overflow', 'hidden');
        if (jQuery(this).is('img')) {
          const imgSrc = jQuery(this).attr('src');
          jQuery('.modal .modal-content').attr('src', imgSrc);
        } else if (jQuery(this).is('div')) {
          var bg_img = jQuery(this)
            .css('background-image')
            .replace(/^url\(['"](.+)['"]\)/, '$1');
          jQuery('.modal .modal-content').attr('src', bg_img);
        }
      });
    });

    jQuery('.modal-popup').each(function () {
      jQuery(this).on('click', function () {
        jQuery('.modal').show();
        jQuery('body').css('overflow', 'hidden');
        var imgSrc;
        if (jQuery(this).find('img').length > 0) {
          imgSrc = jQuery(this).find('img').attr('src');
        } else if (jQuery(this).is('div')) {
          var bg_img = jQuery(this)
            .css('background-image')
            .replace(/^url\(['"](.+)['"]\)/, '$1');
          imgSrc = bg_img;
        }
        jQuery('.modal .modal-content').attr('src', imgSrc);
      });
    });

    jQuery('.see-all-picture-wrapper .image-popup-vertical-fit').magnificPopup({
      type: 'image',
      mainClass: 'mfp-with-zoom',
      gallery: {
        enabled: true,
      },
      zoom: {
        enabled: true,
        duration: 300,
        easing: 'ease-in-out',
        opener: function (openerElement) {
          // Update this part to target the div with background image
          return openerElement.is('div')
            ? openerElement
            : openerElement.find('div');
        },
      },
    });

    jQuery('.modal .close').on('click', function () {
      jQuery('.modal').hide();
      jQuery('body').css('overflow', 'auto');
    });

    // set width to all slider item on load initially according to parent width on load

    const tabs = document.getElementsByClassName('highlighttab');

    let widtharray = [];

    Array.from(tabs).forEach((item, index) => {
      console.log('item', item);
      widtharray.push(item?.children[0]?.clientWidth);
      console.log(
        'item.children[0].clientWidth',
        item?.children[0]?.clientWidth
      );
    });

    Array.from(tabs).forEach((item, index) => {
      let newWidth = Math.max(...widtharray);

      let sliderWrap = item.children[0];

      let sliderList = Array.from(sliderWrap.childNodes).find(
        (e) => e.nodeName === 'DIV'
      );

      // sliderList.style.width = `${newWidth}px`;
    });

    // var tab_name;
    // var tab_content_attr;

    // let tab_ele = document.querySelectorAll('.tab-contents .tab-content')

    // $('.tab-list li').on('click', function(){
    //   $(this).addClass('active').siblings().removeClass('active');
    //   console.log("value", $(this).children('label').attr('data-value'));
    //   tab_name = $(this).children('label').attr('data-value');
    // })

    // console.log("tab_ele", tab_ele);

    // tab_ele.forEach(ele => {
    //   tab_content_attr = $(ele).attr('data-value')
    //   console.log("ele", tab_content_attr);
    //   tab_name === tab_content_attr ? $(ele).addClass('active') : $(ele).removeClass('active');
    // })

    // for faqs
    $('.faqs .faq').on('click', function () {
      $(this).toggleClass('active').siblings().removeClass('active');
    });

    var windowWidth = window.innerWidth;

    if (windowWidth < 992) {
      $('.policy-inner .add-banner').insertAfter($('.banner-inner-page'));
    }

    if (windowWidth < 1200) {
      $('.see-all-picture-wrapper').removeClass('picture-gallery');
    }
  });
})(jQuery);
