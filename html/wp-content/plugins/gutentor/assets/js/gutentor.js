(function( $ ) {
    const gutentorDocument = $(document),
    progressBar            = $('.gutentor-single-item'),
    progressBar_element    = $('.gutentor-element-progressbar'),
    counter                = $('.gutentor-counter'),
    counter_element        = $('.gutentor-counter-element'),
    gutentorWindow         = $(window);


    gutentorDocument.ready(function() {
        if ( typeof WOW !== 'undefined') {
            new WOW().init();
        }
    });

    /* video popup */
    $('.gutentor-video-popup-holder').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false,
    });

    //Accordion
    gutentorDocument.on('click','.gutentor-accordion-heading',function(e) {

        // $(this).siblings().addClass('gutentor-accordion-body--open');
        // e.preventDefault();

        var $this = $(this),
        accordion_content = $this.closest('.gutentor-accordion-wrap'),
        accordion_item = $this.closest('.gutentor-single-item'),
        accordion_details = accordion_item.find('.gutentor-accordion-body'),
        accordion_all_items = accordion_content.siblings('.gutentor-accordion-wrap'),
        accordion_icon = accordion_content.find('.gutentor-accordion-icon');

        accordion_all_items.each(function () {
            $(this).find('.gutentor-accordion-body').slideUp();
            $(this).find('.gutentor-accordion-heading').removeClass('active');
        });

        if( accordion_details.is(":visible")){
            accordion_details.slideUp().removeClass('gutentor-active-body');
            $this.removeClass('active');

        }
        else{
            accordion_details.slideDown().addClass('gutentor-active-body');
            $this.addClass('active');

        }
        e.preventDefault();
    });

    //Counter
    gutentorDocument.on('click','.gutentor-countup-wrap',function() {
        $(this).addClass('gutentor-countup-open');

    });
    gutentorDocument.on('click','.gutentor-countup-box-close',function() {
        $('.gutentor-countup-box').addClass('hide-input');
        $(this).hide();
    });
    gutentorDocument.on('click','.gutentor-countup',function() {
        $('.gutentor-countup-box').removeClass('hide-input');
    });

    //Circlar Progress Bar
    if ( progressBar.length ) {
        progressBar.waypoint(function() {
            $('.gutentor-progressbar-circular').each(function() {
                let thisProgressBar = $(this),
                barColor = thisProgressBar.data('barcolor'),
                trackColor = thisProgressBar.data('trackcolor'),
                scaleColor = thisProgressBar.data('scalecolor'),
                size = thisProgressBar.data('size'),
                lineCap = thisProgressBar.data('linecap'),
                animate = thisProgressBar.data('animate'),
                lineWidth = thisProgressBar.data('linewidth');
                thisProgressBar.easyPieChart({
                    barColor: barColor,
                    trackColor:trackColor,
                    scaleColor: scaleColor,
                    size: size,
                    lineCap: lineCap,
                    animate: animate,
                    lineWidth:lineWidth,
                });
            });
        }, {
            offset: '100%'
        });

    }

    $('.gutentor-porgress-bar-item .progressbar').css("width",
        function() {
            return $(this).attr("data-width") + "%";
        });


    //Circlar Progress Bar
    if ( progressBar_element.length ) {
        progressBar_element.waypoint(function() {
            $('.gutentor-element-progressbar-circular').each(function() {
                let thisProgressBar = $(this),
                    barColor = thisProgressBar.data('barcolor'),
                    trackColor = thisProgressBar.data('trackcolor'),
                    scaleColor = thisProgressBar.data('scalecolor'),
                    size = thisProgressBar.data('size'),
                    lineCap = thisProgressBar.data('linecap'),
                    animate = thisProgressBar.data('animate'),
                    lineWidth = thisProgressBar.data('linewidth');


                console.log(lineWidth);
                thisProgressBar.easyPieChart({
                    barColor: barColor,
                    trackColor:trackColor,
                    scaleColor: scaleColor,
                    size: size,
                    lineCap: lineCap,
                    animate: animate,
                    lineWidth:lineWidth,
                });
            });
        }, {
            offset: '100%'
        });
    }

    $('.gutentor-element-progressbar-box .gutentor-element-progressbar-horizontal').css("width",
        function() {
            return $(this).attr("data-width") + "%";
        });


    function gutentor_counter_box(){
        $('.gutentor-counter').find('.gutentor-single-item-number').each(function () {

            let countup_this = $(this),
            startValue = parseInt( countup_this.data('start') ),
            endValue = parseInt ( countup_this.data('end') ),
            duration = parseInt(countup_this.data('duration') ),
            queueCountAnimation = new CountUp(this, startValue, endValue, 0, duration);

            queueCountAnimation.start();
        });
    }
    function gutentor_counter_element(){
        $('.gutentor-counter-element').find('.gutentor-counter-number').each(function () {

            let countup_this = $(this),
                startValue = parseInt( countup_this.data('start') ),
                endValue = parseInt ( countup_this.data('end') ),
                duration = parseInt(countup_this.data('duration') ),
                queueCountAnimation = new CountUp(this, startValue, endValue, 0, duration);
            queueCountAnimation.start();
        });
    }


    // https://github.com/imakewebthings/waypoints
    if ( counter.length ){
       let waypoint = new Waypoint({
            element: $('.gutentor-counter'),
            handler: function(direction) {
              if (direction === 'down') {
                gutentor_counter_box();
                this.destroy()
              }
            },
            offset: '50%',
       });
    }

    if ( counter_element.length ){
        let waypoint = new Waypoint({
            element: $('.gutentor-counter-element'),
            handler: function(direction) {
                if (direction === 'down') {
                    gutentor_counter_element();
                    this.destroy()
                }
            },
            offset: '50%',
        });
    }

    // initialize date picker in count down block
    $.fn.trigger2 = function(eventName) {
        return this.each(function() {
            let el = $(this).get(0);
            triggerNativeEvent(el, eventName);
        });
    };

    function triggerNativeEvent(el, eventName) {
        if (el.fireEvent) { // < IE9
            (el.fireEvent('on' + eventName));
        } else {
            let evt = document.createEvent('Events');
            evt.initEvent(eventName, true, false);
            el.dispatchEvent(evt);
        }
    }

    function count_down( gutentor_this) {

        // Set the date we're counting down to
        let gutentor_event_date = gutentor_this.data('eventdate');
        if (gutentor_event_date === undefined || gutentor_event_date === null) {
            gutentor_this.html("<span>Please set validate Date and time for countdown </span>");
            return false;
        }
        let  expired_text = gutentor_this.data('expiredtext'),
        gutentor_day = gutentor_this.find('.day'),
        gutentor_hour = gutentor_this.find('.hour'),
        gutentor_min = gutentor_this.find('.min'),
        gutentor_sec = gutentor_this.find('.sec'),
        gutentor_date_time = gutentor_event_date.split('T');
        if ( gutentor_date_time.length !== 2 ){
            return false;
        }
        let date_collection = gutentor_date_time[0],
        time_collection  = gutentor_date_time[1],
        date_explode   = date_collection.split('-');

        if ( date_explode.length  !== 3 ){
            return false;
        }

        let time_explode  = time_collection.split(':');
        if ( time_explode.length !== 3 ){
            return false;
        }

        let gutentor_year_value = parseInt( date_explode[0] ),
        gutentor_month_value = parseInt( date_explode[1] ) -1,
        gutentor_day_value = parseInt( date_explode[2] ),
        gutentor_hour_value = parseInt( time_explode[0] ),
        gutentor_minutes_value = parseInt( time_explode[1] ),
        gutentor_second_value = parseInt( time_explode[2] ),
        countDownDate =  new Date( gutentor_year_value, gutentor_month_value, gutentor_day_value, gutentor_hour_value, gutentor_minutes_value,gutentor_second_value, 0 ).getTime();


        // Update the count down every 1 second
        let x = setInterval(function() {

            // Get todays date and time
            let now = new Date().getTime();

            // Find the distance between now an the count down date
            let distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            let days    = Math.floor(distance / (1000 * 60 * 60 * 24));
            let hours   = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element
            gutentor_day.html( days );
            gutentor_hour.html( hours );
            gutentor_min.html( minutes );
            gutentor_sec.html( seconds );
            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);

                gutentor_this.html("<span>"+ expired_text +"</span>");
            }
        }, 1000);

    }

    // Gutentor Countdown
    $('.gutentor-countdown-wrapper').each(function () {
        count_down( $(this));
    });

    //  Gutentor Image Slider
    gutentorDocument.ready(function() {
     if(typeof $.fn.slick !== 'undefined'){

         let thisSlider = $('.gutentor-slider-wrapper'),
         sliderDots         = thisSlider.data('dots'),
         sliderDotsTablet   = thisSlider.data('dots-tablet'),
         sliderDotsMobile   = thisSlider.data('dots-mobile'),
         sliderArrows       = thisSlider.data('arrows'),
         sliderArrowsTablet = thisSlider.data('arrows-tablet'),
         sliderArrowsMobile = thisSlider.data('arrows-mobile'),
         sliderInfinite     = thisSlider.data('infinite'),
         nextArrow          = thisSlider.data('nextarrow'),
         prevArrow          = thisSlider.data('prevarrow'),
         autoPlay           = thisSlider.data('autoplay'),
         autoPlaySpeed      = thisSlider.data('autoplayspeed'),
         fade               = thisSlider.data('fade'),
         slideSpeed         = thisSlider.data('speed');


         thisSlider.slick({
             dots          : sliderDots,
             arrows        : sliderArrows,
             infinite      : sliderInfinite,
             speed         : slideSpeed,
             slidesToShow  : 1,
             nextArrow     : '<span class="slick-next"><i class="'+nextArrow+'"></i></span>',
             prevArrow     : '<span class="slick-prev"><i class="'+prevArrow+'"></i></span>',
             autoplay      : autoPlay,
             autoplaySpeed : autoPlaySpeed,
             fade          : fade,
             responsive: [{
              breakpoint: 1024,
              settings: {
                slidesToShow   : 1,
                dots           : sliderDotsTablet,
                arrows         : sliderArrowsTablet,
            }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow   : 1,
            dots           : sliderDotsMobile,
            arrows         : sliderArrowsMobile,
          }}]
         });

         $('.gutentor-carousel-row').each(function() {
            carouselRun($(this))
        });
         $('.gutentor-image-carousel-row').each(function() {
            carouselRun($(this))
        });
     }

     //Gutentor Gallery Box
        let galleryWrapper = $('.gutentor-gallery-wrapper');
        galleryWrapper.each(function () {
                let masonryBoxes = $(this);
            if (masonryBoxes.hasClass('enable-masonry')) {
                container = masonryBoxes.find('.full-width-row');

                container.imagesLoaded(function () {
                    masonryBoxes.fadeIn('slow');
                    container.masonry({
                        itemSelector: '.gutentor-gallery-item',
                    });
                });

            }
            masonryBoxes.find('.image-gallery').magnificPopup({
                type: 'image',
                closeBtnInside: false,
                gallery: {
                    enabled: true
                },
                fixedContentPos: false
            });
        });
    });

    function carouselRun(thisCarousel) {
        carouselDots          = thisCarousel.data('dots'),
        carouselDotsTablet    = thisCarousel.data('dots-tablet'),
        carouselDotsMobile    = thisCarousel.data('dots-mobile'),
        carouselArrows        = thisCarousel.data('arrows'),
        carouselArrowsTablet  = thisCarousel.data('arrows-tablet'),
        carouselArrowsMobile  = thisCarousel.data('arrows-mobile'),
        carouselInfinite      = thisCarousel.data('infinite'),
        carouselNextArrow     = thisCarousel.data('nextarrow'),
        carouselPrevArrow     = thisCarousel.data('prevarrow'),
        carouselAutoPlay      = thisCarousel.data('autoplay'),
        carouselAutoPlaySpeed = thisCarousel.data('autoplayspeed'),
        carouselFade          = thisCarousel.data('fade'),
        carouselCenterMode    = thisCarousel.data('mode-center'),
        carouselModePadding   = thisCarousel.data('mode-center-padding'),
        slideToShow           = thisCarousel.data('slidetoshow'),
        slideToShowDesktop    = thisCarousel.data('slideitemdesktop'),
        slideToShowTablet     = thisCarousel.data('slideitemtablet'),
        slideToShowMobile     = thisCarousel.data('slideitemmobile'),
        slideToScrollDesktop  = thisCarousel.data('slidescroll-desktop'),
        slideToScrollTablet   = thisCarousel.data('slidescroll-tablet'),
        slideToScrollMobile   = thisCarousel.data('slidescroll-mobile'),
        slideSpeed            = thisCarousel.data('speed'),
        slideToScroll         = thisCarousel.data('slidetoscroll');

        thisCarousel.slick({
            dots           : carouselDots,
            arrows         : carouselArrows,
            infinite       : carouselInfinite,
            speed          : slideSpeed,
            slidesToShow   : slideToShowDesktop,
            slidesToScroll : slideToScrollDesktop,
            nextArrow      : '<span class="slick-next"><i class="'+carouselNextArrow+'"></i></span>',
            prevArrow      : '<span class="slick-prev"><i class="'+carouselPrevArrow+'"></i></span>',
            autoplay       : carouselAutoPlay,
            autoplaySpeed  : carouselAutoPlaySpeed,
            centerMode     : carouselCenterMode,
            centerPadding  : carouselModePadding+'px',
            responsive: [

            {
              breakpoint: 1024,
              settings: {
                slidesToShow   : slideToShowTablet,
                slidesToScroll : slideToScrollTablet,
                dots           : carouselDotsTablet,
                arrows         : carouselArrowsTablet,
            }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow   : slideToShowMobile,
            slidesToScroll : slideToScrollMobile,
            dots           : carouselDotsMobile,
            arrows         : carouselArrowsMobile,
        }
    }
    ]
});
    }

    /*Tabs*/
    function gutentorTabs() {
        gutentorDocument.on('click','.gutentor-tabs-list',function(){
            let thisTabInside  = $(this),
            gutentorSingleItemIndex = thisTabInside.data('index'),
            gutentorTabs = thisTabInside.closest('.gutentor-tabs'),
            gutentorTabsContentWrap = gutentorTabs.next('.gutentor-tabs-content-wrap'),
            gutentorTabsSingleContent = gutentorTabsContentWrap.find('.'+gutentorSingleItemIndex);

            gutentorTabsSingleContent.siblings().removeClass('gutentor-tab-content-active');
            thisTabInside.siblings().removeClass('gutentor-tab-active');

            gutentorTabsSingleContent.addClass('gutentor-tab-content-active');
            thisTabInside.addClass('gutentor-tab-active');
        });
    }
    gutentorTabs();

    //show more block
    function gutentorShowMoreBlock(className) {
        gutentorDocument.on('click',className,function(e){
            e.preventDefault();
            let thisShowMore  = $(this);
            let showMoreParent = thisShowMore.parent();
            if(className === '.gutentor-show-more-button') {
                showMoreParent.closest('.gutentor-single-item-content').addClass('show-more-content');
            }
            else{
                showMoreParent.closest('.gutentor-single-item-content').removeClass('show-more-content');
            }
        });
    }
    gutentorShowMoreBlock('.gutentor-show-more-button');
    gutentorShowMoreBlock('.gutentor-show-less-action-button');


    $(window).load(function(){
        //Gutentor filter Box
        let buttonFilters = {},
            buttonFilter = {},
            qsRegex = {},
            currentFilter;

        $('.gutentor-filter-item-wrap').isotope({
            itemSelector: '.gutentor-gallery-item',
            layoutMode: 'fitRows',
            filter: function() {
                let $this = $(this);
                let searchResult = currentFilter && qsRegex[currentFilter] ? $this.text().match( qsRegex[currentFilter] ) : true;
                let buttonResult = currentFilter && buttonFilter[currentFilter] ? $this.is( buttonFilter[currentFilter] ) : true;
                return searchResult && buttonResult;
            },
        });
        $('.gutentor-filter-group').on( 'click', '.gutentor-filter-btn', function() {
            $(this).siblings().removeClass('gutentor-filter-btn-active');
            $( this ).addClass('gutentor-filter-btn-active');

            let masonryBoxes = $( this ).closest('.gutentor-filter-wrapper');
            currentFilter = masonryBoxes.attr('data-filter-number');
            let $this = $(this);
            // get group key
            let $buttonGroup = $this.parents('.gutentor-filter-group');
            let filterGroup = $buttonGroup.attr('data-filter-group');

            // set filter for group
            if( buttonFilters[currentFilter] === undefined ){
                buttonFilters[currentFilter] = {};
            }
            buttonFilters[currentFilter][ filterGroup ] = $this.attr('data-filter');
            // combine filters
            if( buttonFilter[currentFilter] === undefined ){
                buttonFilter[currentFilter] = {};
            }
            buttonFilter[currentFilter] = concatValues( buttonFilters[currentFilter] );
            // Isotope arrange
            let this_grid_wrapper = $(this).closest('.gutentor-filter-container').next('.gutentor-filter-item-wrap');
            this_grid_wrapper.isotope();
        });
        // use value of search field to filter
        $('.gutentor-search-filter').keyup( debounce( function() {
            let masonryBoxes = $( this ).closest('.gutentor-filter-wrapper');
            currentFilter = masonryBoxes.attr('data-filter-number');
            qsRegex[currentFilter] = new RegExp( $(this).val(), 'gi' );
            let this_grid_wrapper = $(this).closest('.gutentor-filter-container').next('.gutentor-filter-item-wrap');

            this_grid_wrapper.isotope();
        }) );

        // flatten object by concatting values
        function concatValues( obj ) {
            let value = '';
            for ( let prop in obj ) {
                value += obj[ prop ];
            }
            return value;
        }

        // debounce so filtering doesn't happen every millisecond
        function debounce( fn, threshold ) {
            let timeout;
            threshold = threshold || 100;
            return function debounced() {
                clearTimeout( timeout );
                let args = arguments;
                let _this = this;
                function delayed() {
                    fn.apply( _this, args );
                }
                timeout = setTimeout( delayed, threshold );
            };
        }

        gutentorDocument.find('.gutentor-filter-wrapper').each(function (i, item) {
            let thisFilterWrap = $(this);
            thisFilterWrap.attr('data-filter-number',i);
            thisFilterWrap.find('.image-gallery').magnificPopup({
                type: 'image',
                closeBtnInside: false,
                gallery: {
                    enabled: true
                },
                fixedContentPos: false
            });
            let container = thisFilterWrap.find('.gutentor-filter-item-wrap');

            if (thisFilterWrap.hasClass('enable-masonry')) {
                container.isotope({ layoutMode: 'masonry' })
            }
        });

    });
})( jQuery );