!function(l){var i=l(".wn-loadmore-ajax"),n=i.data("site-url"),s=i.data("current-page"),a=i.data("max-page-num");i.data("total"),i.data("post-pre-page"),i.data("no-more-post");""==s&&(s="1",i.attr("data-current-page",s)),s<a&&l(".wn-loadmore-ajax a").on("click",function(e){var o;e.preventDefault(),s<a&&(s++,i.find("a").attr("href",n+"/page/"+s+"/"),i.attr("data-current-page",s),e=l(this).attr("href"),(o=l('<div class="wn-circle-side-wrap"><div data-loader="wn-circle-side"></div></div>')).appendTo(l(this)),l.get(e,function(e){e=l(".wn-blog-ajax",e);l(".wn-loadmore-ajax").before(e),o.remove(),l(0<"tline-box".length)&&(l(".blog-social-5").find(".more-less").children(".less").hide(),l(".blog-social-5").find(".linkedin, .email").hide(),l(".blog-social-5").find("a.more-less").on("click",function(e){e.preventDefault(),l(this).closest(".blog-social-5").find(".linkedin, .email").slideToggle("400"),l(this).closest(".blog-social-5").find(".more-less").children(".more").slideToggle(400),l(this).closest(".blog-social-5").find(".more-less").children(".less").slideToggle(400)}))}))}),l(window).on("load",function(){l("#pin-content").length&&"function"==typeof masonry&&l("#pin-content").masonry({itemSelector:".pin-box"}).imagesLoaded(function(){l("#pin-content").data("masonry")})}),0<l("body").find(".blog-post").length&&l("body").addClass("blog-pg-w"),l(document).ready(function(){l(".single").find(".post-sharing-3").length&&(l(window).on("scroll",function(){var e=l(window).scrollTop();l(".blog-social-3").toggleClass("active",e>=l(".type-post").offset().top),l(".blog-social-3").toggleClass("deactive",e>=l(".post-sharing").offset().top)}),l(window).trigger("scroll")),l(".blog-social-5").find(".more-less").children(".less").hide(),l(".blog-social-5").find(".linkedin, .email").hide(),l(".blog-social-5").find("a.more-less").on("click",function(e){e.preventDefault(),l(this).closest(".blog-social-5").find(".linkedin, .email").slideToggle("400"),l(this).closest(".blog-social-5").find(".more-less").children(".more").slideToggle(400),l(this).closest(".blog-social-5").find(".more-less").children(".less").slideToggle(400)})})}(jQuery);