'use strict';

function dataBg() {
	
	const dataBg = document.querySelectorAll('[data-bg-wpacw]');
	dataBg.forEach( function(el) {
		var attr = el.getAttribute('data-bg-wpacw')
		if (attr.length) el.style.backgroundImage = 'url('+ attr +')';
	});
	    
}

// Check if document is on ready state
function ready(fn) {
	if (document.readyState != 'loading') {
		fn();
    } else {
		document.addEventListener('DOMContentLoaded', fn);
	}
}

// Check if XHR is complete
function xhrComplete(fn) {
	const send = XMLHttpRequest.prototype.send
    XMLHttpRequest.prototype.send = function() { 
        this.addEventListener('load', function() {
            fn();
        })
        return send.apply(this, arguments)
    }
}

window.ready( function() {
    dataBg();
});

window.xhrComplete( function() {
    dataBg();
});
