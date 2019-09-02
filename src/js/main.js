'use strict';

function bgImage() {
	
	const dataBg = document.querySelectorAll('[data-bg-wpacw]');
	dataBg.forEach( function(el) {
		var attr = el.getAttribute('data-bg-wpacw')
		if (attr.length) el.style.backgroundImage = 'url('+ attr +')';
	});
	    
}

function ready(fn) {
	if (document.readyState != 'loading') {
		fn();
    } else {
		document.addEventListener('DOMContentLoaded', fn);
	}
}

function completeAjax(fn) {
	const send = XMLHttpRequest.prototype.send
    XMLHttpRequest.prototype.send = function() { 
        this.addEventListener('load', function() {
            fn();
        })
        return send.apply(this, arguments)
    }
}

window.ready( function() {
    bgImage();
});

window.completeAjax( function() {
    bgImage();
});
