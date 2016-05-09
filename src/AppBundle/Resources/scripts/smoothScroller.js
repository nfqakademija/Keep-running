$.fn.smoothScroller = function(scrollParams, easing, complete) {
    function smoothScroll(target, scrollParamsInner, easingInner, completeInner) {
        $("html, body").animate({
            scrollTop: $(target).offset().top
        }, scrollParamsInner, easingInner, completeInner);
    }
    
    this.click(function(){
        var href = $(this).attr("href");
        smoothScroll(href, scrollParams, easing, complete);
        return false;
    });
}