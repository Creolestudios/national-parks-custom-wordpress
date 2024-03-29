(function ($) {
  $(document).ready(function () {
    // Get query string of current url.
    function getQueryString() {
      var queryString = window.location.search;
      var queryParams = new URLSearchParams(queryString);
      return queryParams;
    }

    // Function to clear all query parameters from the URL
    function clearQueryString() {
      if (history.replaceState) {
        history.replaceState({}, document.title, window.location.pathname);
      }
    }
    var queryString = getQueryString();

    $('.diversity-category-detail').on('click', function (e) {
      e.preventDefault();
      var hrefValue = $(this).attr('href');
      window.location.href = hrefValue;
    });

    /**
     * ====================================
     * Start JS for national park mega menu.
     * ====================================
     */

    $(document).on('click', '.seeall-category', function (e) {
      e.preventDefault();
      let cat_id = $(this).data('cat-id');
      let national_park_url = globalScript.national_park_url;
      window.location.href = national_park_url + '?category=' + cat_id;
    });

    var submenulistHeight = $(
      '.megamenu-category-item li:first-child'
    ).height();

    $('.seeall-cat').height(submenulistHeight);

    $('.menu-popup-wrapper').appendTo('.menu-list-item-wrapper .has-subchild');

    // On hover to display country based on continent.
    $('.animal-category').on('mouseover', function () {
      let category_id = $(this).data('term-id');
      $('.animal-category').removeClass('active');
      $(this).addClass('active');

      $('.megamenu-category-item').each(function () {
        let ulterm = $(this).data('term-id');
        if (category_id == ulterm) {
          $('.megamenu-category-item').hide();
          $(this).show();
        }
      });
    });

    /**
     * ==================================
     * End JS for National park mega menu.
     * ==================================
     */

    /**
     * ============================
     * Start JS for blog listing.
     * ============================
     */

    let blog_paged = 2;
    let blog_per_page = 6;

    // If querystring has 'favorites' sort type.
    if (queryString.has('sort')) {
      var action = queryString.get('sort');
      // Perform actions based on the value of 'action'
      if (action === 'favorites') {
        $('.sort_blog_filter').data('value', action);
        $('.sort_blog_filter').children('span').text('Favourites');
        let cat_value = $('.category_blog_filter').attr('data-value');
        let search_value = $('.blog-list-search').val();
        clearQueryString();
        get_blogs_by_filter(action, cat_value, search_value);
      }
    }

    // Initial check to hide the "Read more" button if there are no more blogs.
    let blog_track = $('.akd-blog-listing').data('blog-track');
    if (blog_track <= blog_per_page) {
      $('.blog-list-read-more-btn').hide();
    }

    // Click event on load more button.
    $('.blog-list-read-more-btn').on('click', function (e) {
      e.preventDefault();
      load_more_national_park_blogs();
    });

    // Click on sort filter.
    $('.blog_sort_item').on('click', function () {
      let sort_type = $(this).data('value');
      let cat_value = $('.category_blog_filter').attr('data-value');
      let search_value = $('.blog-list-search').val();
      get_blogs_by_filter(sort_type, cat_value, search_value);
    });

    // Click on category filter.
    $('.blog_category_item').on('click', function () {
      let cat_value = $(this).data('value');
      let sort_type = $('.sort_blog_filter').attr('data-value');
      let search_value = $('.blog-list-search').val();
      get_blogs_by_filter(sort_type, cat_value, search_value);
    });

    // Search on blog listing.
    $('.blog-list-search').on('keyup', function (e) {
      if (e.key === 'Enter') {
        let search_value = $(this).val();
        let sort_type = $('.sort_blog_filter').attr('data-value');
        let cat_value = $('.category_blog_filter').attr('data-value');
        get_blogs_by_filter(sort_type, cat_value, search_value);
      }
    });

    /**
     * Function make an AJAX call to filter blogs.
     *
     * @param {string} sort_type Sorting type
     * @param {string} cat_value Category slug
     *
     * @return {void}
     */
    function get_blogs_by_filter(sort_type, cat_value, search_value) {
      $('.akd-blog-listing').html('');
      $('.blog-list-loader').show();
      $('.blog-list-read-more-btn').hide();

      $.ajax({
        url: globalScript.ajax_url,
        type: 'POST',
        data: {
          action: 'npx_get_blogs_by_filter',
          nonce: globalScript.nonce,
          sort_type: sort_type,
          cat_value: cat_value,
          search_value: search_value,
          blog_per_page: blog_per_page,
        },
        success: function (response) {
          let htmlresponse = response.data.html;
          let totalblogs = response.data.totalblogs;
          $('.akd-blog-listing').attr('data-blog-track', totalblogs);
          if (htmlresponse) {
            $('.akd-blog-listing').html(htmlresponse);
          }
          if (totalblogs > blog_per_page) {
            $('.blog-list-read-more-btn').show();
          }
        },
        complete: function () {
          $('.blog-list-loader').hide();
          blog_paged = 2;
        },
      });
    }

    /**
     * Function make an AJAX call to load more blogs.
     *
     * @return {void}
     */
    function load_more_national_park_blogs() {
      $('.blog-list-read-more-btn').hide();
      $('.blog-list-loader').show();
      let filter_sort_type = $('.sort_blog_filter').attr('data-value');
      let filter_cat_value = $('.category_blog_filter').attr('data-value');

      $.ajax({
        url: globalScript.ajax_url,
        type: 'POST',
        data: {
          action: 'npx_load_more_national_park_blogs',
          nonce: globalScript.nonce,
          blog_paged: blog_paged,
          blog_per_page: blog_per_page,
          filter_sort_type: filter_sort_type,
          filter_cat_value: filter_cat_value,
        },
        success: function (response) {
          let htmlresponse = response.data.html;
          if (htmlresponse) {
            $('.akd-blog-listing').append(htmlresponse);
            blog_paged++;
            // Check if there are more blogs.
            if (
              $('.akd-blog-listing .list').length >=
              $('.akd-blog-listing').attr('data-blog-track')
            ) {
              $('.blog-list-read-more-btn').hide();
            } else {
              $('.blog-list-read-more-btn').show();
            }
          }
        },
        complete: function () {
          $('.blog-list-loader').hide();
        },
      });
    }

    /**
     * ============================
     * End JS for blog listing.
     * ============================
     */

    // For the policy page.
    $('.policy-container .tab-list li a').on('click', function (e) {
      e.preventDefault();
      $('.policy-container .tab-list li').removeClass('active');
      $(this).parent().addClass('active');
      var targetId = $(this).attr('href');
      var $target = $(targetId);
      if ($target.length) {
        $('html, body').animate(
          {
            scrollTop: $target.offset().top,
          },
          100
        );
      }
    });

    // Global search.
    $('#akd-global-search').on('keyup', function (e) {
      if (e.key === 'Enter') {
        let search_term = $(this).val();
        let home_url = globalScript.home_url;
        window.location.href = home_url + '?s=' + search_term;
      }
    });

    /**
     * =============================
     * Start JS for types of animal.
     * =============================
     */

    // let species_per_page = 6;
    // Initial check to hide the "Load more" button if there are no more blogs.
    // let species_track = $(".type-of-cat-item-wrapper").data("species-track");
    // if (species_track <= species_per_page) {
    //   $(".load-more-species").hide();
    // }

    // Click event on load more button.
    // $(".load-more-species").on("click", function (e) {
    //   e.preventDefault();
    //   loadMoreSpeciesOfAnimal();
    // });

    /**
     * Function make an AJAX call to load more species.
     *
     * @return {void}
     */
    function loadMoreSpeciesOfAnimal() {
      $('.load-more-species').hide();
      $('.animal-species-loader').show();
      let species_id = $('.type-of-cat-item-wrapper').attr('data-species_id');
      let species_start_index = parseInt(
        $('.type-of-cat-item-wrapper').attr('data-species-start')
      );

      $.ajax({
        url: globalScript.ajax_url,
        type: 'POST',
        data: {
          action: 'akd_load_more_animal_species',
          nonce: globalScript.nonce,
          species_id: species_id,
          species_start_index: species_start_index,
        },
        success: function (response) {
          let htmlresponse = response.data.html;
          if (htmlresponse) {
            $('.type-of-cat-item-wrapper').append(htmlresponse);
            $('.type-of-cat-item-wrapper').attr(
              'data-species-start',
              species_start_index + 6
            );
            // Check if there are more species.
            if (
              $('.type-of-cat-item-wrapper .type-of-cat-item').length >=
              $('.type-of-cat-item-wrapper').attr('data-species-track')
            ) {
              $('.load-more-species').hide();
            } else {
              $('.load-more-species').show();
            }
          }
        },
        complete: function () {
          $('.animal-species-loader').hide();
        },
      });
    }

    /**
     * ========================================
     * Start JS for national park gallery popup.
     * ========================================
     */

    // Click event on see all button.
    $('.see-all-pictures').on('click', function (e) {
      e.preventDefault();
      $('.animal-gallery-popup-main').show();
      $('.slider-for').slick('refresh');
      $('.slider-nav').slick('refresh');

      // Prevent click inside the popup from closing it.
      e.stopPropagation();
    });

    // Close park gallery popup when clicking anywhere on the document.
    $('.animal-gallery-popup-main .close').on('click', function (e) {
      $('.animal-gallery-popup-main').hide();
    });

    // Slick slider.
    $('.slider-for').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      fade: true,
      // asNavFor: '.slider-nav',
    });

    // $(".slider-nav").slick({
    //   slidesToShow: 6,
    //   slidesToScroll: 1,
    //   asNavFor: ".slider-for",
    //   dots: false,
    //   focusOnSelect: true,
    //   responsive: [
    //     {
    //       breakpoint: 1500,
    //       settings: {
    //         slidesToShow: 4,
    //       },
    //     },
    //     {
    //       breakpoint: 1200,
    //       settings: {
    //         slidesToShow: 3,
    //         centerPadding: "120px",
    //       },
    //     },
    //     {
    //       breakpoint: 991,
    //       settings: {
    //         slidesToShow: 2,
    //         centerPadding: "180px",
    //       },
    //     },
    //     {
    //       breakpoint: 768,
    //       settings: {
    //         slidesToShow: 2,
    //         centerPadding: "0",
    //       },
    //     },
    //     {
    //       breakpoint: 250,
    //       settings: {
    //         slidesToShow: 2,
    //         centerPadding: "80px",
    //       },
    //     },
    //   ],
    // });

    /**
     * ======================================
     * End JS for National park gallery popup.
     * ======================================
     */
  });
})(jQuery);
