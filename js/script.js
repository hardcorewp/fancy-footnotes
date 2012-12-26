/**
 * @see http://www.paulund.co.uk/smooth-scroll-to-internal-links-with-jquery
 * @see http://stackoverflow.com/a/5830517/102699
 * @see http://stackoverflow.com/a/13106698/102699
 */

jQuery(document).ready(function($) {
	function getCss(element){
		var dom = element.get(0);
		var style;
		var returns = {};
		var prop,val;
		if(window.getComputedStyle){
			var camelize = function(a,b){
				return b.toUpperCase();
			};
			style = window.getComputedStyle(dom, null);
			for(var i = 0, l = style.length; i < l; i++){
				prop = style[i];
				var camel = prop.replace(/\-([a-z])/g, camelize);
				val = style.getPropertyValue(prop);
				returns[camel] = val;
			}
			return returns;
		}
		if(style = dom.currentStyle){
			for(prop in style){
				returns[prop] = style[prop];
			}
			return returns;
		}
		return element.css();
	}
	function highlight(target) {
		var element = target.parents('dt');
		if ( element.length ) {
			element = element.next();
		} else {
			element = target.parents('dd,p,blockquote,li');
		}
		if ( element.length ) {
			var wrapper = $('<'+element.prop('tagName')+'">').css(getCss(element));
			var clone = element.clone().wrapInner(wrapper);
			$("<div/>")
				.html(clone.html())
				.width(element.width())
				.height(element.height())
				.css({
					"position": "absolute",
					"left": element.offset().left,
					"top": element.offset().top,
					"background-color": "yellow",
					"opacity": ".7",
					"z-index": "999999"
				}).appendTo('body').fadeOut(1750).queue(function () {
					$(this).remove();
				});
		}
		return false;
	}
	function getTarget(hash) {
		return $('a.footnote-link[name='+hash.substring(1)+']');
	}
	function moveTo($target) {
		$('body').animate({
			'scrollTop': $target.offset().top - 75
		}, 500, 'swing', function () {
			highlight($target);
		});
	}
	var $target = getTarget(location.hash);
	//alert( target );
	if (1==$target.length) {
		moveTo($target);
	}
	$('a.footnote-link[href*="#"]').live("click",function(e){
		var name = this.hash;
		var $target = getTarget(name);
		location.hash = name;
		moveTo($target);
		return false;
	});

});

