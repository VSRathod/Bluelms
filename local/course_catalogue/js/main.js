require(['jquery'], function ($) {

    const searchSubmitFn = function (e) {
        e.preventDefault();
        e.stopPropagation();

        courseCatalogueRouteParams.search = $('#input-catalogue-search').val() || null;
        courseCatalogueRouteParams.page = 1;
        updateRoute();
        
    };
    

    $('#button-catalogue-search').on('click', searchSubmitFn);
    $('#form-catalogue-search').on('submit', searchSubmitFn);
    

    const tagSearchSubmitFn = function (e) {
        e.preventDefault();
        e.stopPropagation();


        courseCatalogueRouteParams.tag = $('#input-tag-search').val() || null;
        courseCatalogueRouteParams.page = 1;
        
        updateRoute();
    };
    

    $('#button-tag-search').on('click', tagSearchSubmitFn);
    $('#form-tag-search').on('submit', tagSearchSubmitFn);

    $('.input-catalogue-filter').on('change', function (e) {

        courseCatalogueRouteParams.page = 1;

        if ($(this).attr('type') == 'radio') {
            courseCatalogueRouteParams[$(this).attr('name')] = $(this).is(':checked') ? $(this).val() :
                null;
            updateRoute();
            return;
        }

        // now for checkbox

        // remove [] from name
        const name = $(this).attr('name').replace('[]', '');

        if (courseCatalogueRouteParams[name] == null || !courseCatalogueRouteParams[name]) {
            courseCatalogueRouteParams[name] = [];
        }

        if ($(this).is(':checked')) {
            courseCatalogueRouteParams[name].push($(this).val());
        } else {
            // find index of value and remove it
            const index = courseCatalogueRouteParams[name].indexOf($(this).val());

            if (index > -1) {
                courseCatalogueRouteParams[name].splice(index, 1);
            }
        }

        updateRoute();
    });

    function updateRoute() {
        // remove empty params
        for (let key in courseCatalogueRouteParams) {
            if (courseCatalogueRouteParams[key] === null) {
                delete courseCatalogueRouteParams[key];
            }
        }

        window.location.href = `?${$.param(courseCatalogueRouteParams)}`;
    }

    // set navigation
    const nav = $('.primary-navigation .navbar-nav .nav-link');

    // remove active class from all
    nav.removeClass('active');

    let currentUrl = window.location.href;

    // remove query string
    currentUrl = currentUrl.split('?')[0];

    // add active class to current page
    nav.filter(function () {
        return $(this).attr('href') == currentUrl;
    }).addClass('active');
});