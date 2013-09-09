(function($) {
    $.fn.selettoreTabs = function(options) {

        if (!this.length) { return this; }

        var opts = $.extend(true, {}, $.fn.selettoreTabs.defaults, options);
        var currentIndex = null;
        var currentTab = null;
        var selettore = null;
        var self,
            device;

        this.each(function() {

            var $this = $(this);
            var i = 0;

            $.each($this.find('.tab-wrapper'), function(){
                $el = $(this);
                var $slide = $('<div class="tab-slide" data-index="'+ i++ +'" />');
                $slide.append( $el.find('.tab-contents').clone() );
                $this.find('.tabs-container').append($slide);
            });


            $this.find('.tab-wrapper').bind('click', function(event){

                $el = $(this);
                var index = $el.data('index');

                if( currentTab != null ){
                    $('.tab-label', currentTab).removeClass('current');
                }
                $('.tab-label', $el).addClass('current');


                if( device == 'phone' ){
                    currentTab.find('.tab-contents').slideUp('slow', function(){
                        $el.find('.tab-contents').slideDown('slow');
                    });


                }

                $oldContent = $('.tabs-container', $this).find("[data-index='" + currentIndex + "']");

                if( $oldContent.length ){
                    $oldContent.animate({opacity: 0, marginTop: '10%', zIndex:'1'}, 250, function(){
                        $content = $('.tabs-container', $this).find("[data-index='" + index + "']");
                        $content.animate({opacity: 1, marginTop: '0%', zIndex: '9999'}, 250, 'easeInOutExpo');
                        $('.tabs-container', $this).animate({height: $content.height() + 20}, 250);
                    })
                }else{
                    $content = $('.tabs-container', $this).find("[data-index='0']");
                    $content.animate({opacity: 1, marginTop: '0%'}, 250, 'easeInOutExpo');
                    $('.tabs-container', $this).animate({height: $content.height() + 20}, 250);
                }

                currentTab = $el;
                currentIndex = index;


            });

            $(window).resize(function() {

                var width = $(window).width();
                if( width <= 760 && device != 'phone'){
                    device = 'phone';
                    if( currentTab != undefined ){
                        currentTab.trigger('click');
                    }
                }

                if( width > 760  && device != 'tablet'){
                    device = 'tablet';
                    $('.tab-wrapper .tab-contents', $this).hide();
                    if( currentTab != undefined ){
                        currentTab.trigger('click');
                    }
                }
            });

            $('.tab-wrapper:first-child', $this).trigger('click');
            $(window).trigger('resize');

        });
        return this;
    };

    $.fn.selettoreTabs.defaults = {
        color : "#000000"
    };

})(jQuery);


