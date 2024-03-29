(function ($) {
  $(document).ready(function () {
    // Function to clear all query parameters from the URL
    function clearQueryString() {
      if (history.replaceState) {
        history.replaceState({}, document.title, window.location.pathname);
      }
    }

    /**
     * ====================================
     * Start JS for National park listing.
     * ====================================
     */

    let paged = 2;
    let per_page = 12;

    $("#np-country-filter").select2({
      placeholder: "Select a country",
      width: "30%",
    });

    // Event listener for when selection changes to country dropdown.
    $(document).on("change", "#np-country-filter", function () {
      let country_value = $(this).val();
      let category_id = $(".country-category-list.active").attr("data-term-id");
      let search_term = $("#animal-category-search").val();
      let sort_value = $(".sorting-btn").attr("data-sort");
      get_parks_by_continent(
        category_id,
        search_term,
        country_value,
        (country_flag = 0),
        sort_value
      );
    });

    // Initial check to hide the "Read more" button if there are no more parks.
    let park_track = $(".category-listing-card-wrapper").data("park-track");
    if (park_track <= per_page) {
      $(".load-more-country-category").hide();
    }

    // Click event on load more button.
    $(".load-more-country-category").on("click", function (e) {
      e.preventDefault();
      load_more_national_parks();
    });

    // Click on continents.
    $(".country-category-list").on("click", function () {
      clearQueryString();
      let category_id = $(this).data("term-id");
      let search_term = $("#animal-category-search").val();
      $(".country-wrapper").html("");
      $(".country-category-list").removeClass("active");
      $(this).addClass("active");
      get_parks_by_continent(
        category_id,
        search_term,
        (country_value = []),
        (country_flag = 1)
      );
    });

    // Click on sorting button.
    $(".sorting-btn").on("click", function () {
      let sort_value = $(this).attr("data-sort");
      let category_id = $(".country-category-list.active").attr("data-term-id");
      let search_term = $("#animal-category-search").val();
      let country_value = $("#np-country-filter").val();
      get_parks_by_continent(
        category_id,
        search_term,
        country_value,
        (country_flag = 0),
        sort_value
      );
    });

    // Search on national parks.
    $("#animal-category-search").on("keyup", function (e) {
      if (e.key === "Enter") {
        let search_term = $(this).val();
        let category_id = $(".country-category-list.active").attr(
          "data-term-id"
        );
        let country_value = $("#np-country-filter").val();
        get_parks_by_continent(
          category_id,
          search_term,
          country_value,
          (country_flag = 0)
        );
      }
    });

    /**
     * Function make an AJAX call to filter national parks by continent.
     *
     * @param {integer} category_id Category ID
     * @param {string} search_term Search Value
     * @param {string} sort_value Sort Value
     *
     * @return {void}
     */
    function get_parks_by_continent(
      category_id,
      search_term,
      country_value,
      country_flag,
      sort_value
    ) {
      $(".category-listing-card-wrapper").html("");
      $(".country-category-loader").show();
      $(".load-more-country-category").hide();
      $.ajax({
        url: parkListScript.ajax_url,
        type: "POST",
        data: {
          action: "npx_get_parks_by_continent",
          nonce: parkListScript.nonce,
          category_id: category_id,
          per_page: per_page,
          search_term: search_term,
          sort_value: sort_value,
          country_value: country_value,
        },
        success: function (response) {
          let totalAnimals = response.data.total_parks;

          // Append category response.
          $(".category-listing-card-wrapper").html(response.data.html);

          // Append favorite content.
          $(".favorite-farm-animal-wrapper").html(response.data.fav_content);

          // Append country dropdown.
          if (country_flag == 1) {
            $(".country-wrapper").html(response.data.country_dropdown);
            $("#np-country-filter").select2({
              placeholder: "Select a country",
              width: "30%",
            });
          }

          // Manage loadmore.
          $(".category-listing-card-wrapper").attr(
            "data-park-track",
            totalAnimals
          );
          if (totalAnimals <= per_page) {
            $(".load-more-country-category").hide();
          } else {
            $(".load-more-country-category").show();
          }

          // Manage sorting.
          let sorting = $(".sorting-btn").attr("data-sort");
          if (sort_value !== undefined && sorting == "ASC") {
            $(".sorting-btn").attr("data-sort", "DESC");
            $(".sorting-btn").html("SORT Z TO A");
          } else if (sort_value !== undefined && sorting == "DESC") {
            $(".sorting-btn").attr("data-sort", "ASC");
            $(".sorting-btn").html("SORT A TO Z");
          } else {
            $(".sorting-btn").attr("data-sort", "DESC");
            $(".sorting-btn").html("SORT Z TO A");
          }
        },
        complete: function () {
          $(".country-category-loader").hide();
          paged = 2;
        },
      });
    }

    /**
     * Function make an AJAX call to load more National parks.
     *
     * @return {void}
     */
    function load_more_national_parks() {
      $(".load-more-country-category").hide();
      $(".country-category-loader").show();
      let category_id = $(".country-category-list.active").attr("data-term-id");
      let search_term = $("#animal-category-search").val();
      let country_value = $("#np-country-filter").val();
      let sort_value = $(".sorting-btn").attr("data-sort");
      sort_value == "ASC" ? (sort_value = "DESC") : (sort_value = "ASC");

      $.ajax({
        url: parkListScript.ajax_url,
        type: "POST",
        data: {
          action: "npx_load_more_parks_by_continent",
          nonce: parkListScript.nonce,
          category_id: category_id,
          paged: paged,
          per_page: per_page,
          search_term: search_term,
          sort_value: sort_value,
          country_value: country_value,
        },
        success: function (response) {
          let htmlresponse = response.data.html;
          if (htmlresponse) {
            $(".category-listing-card-wrapper").append(htmlresponse);
            paged++;
            // Check if there are more national park.
            if (
              $(".category-listing-card-wrapper .category-listing-card-item")
                .length >=
              $(".category-listing-card-wrapper").attr("data-park-track")
            ) {
              $(".load-more-country-category").hide();
            } else {
              $(".load-more-country-category").show();
            }
          }
        },
        complete: function () {
          $(".country-category-loader").hide();
        },
      });
    }

    /**
     * ====================================
     * End JS for National Park listing.
     * ====================================
     */
  });
})(jQuery);
