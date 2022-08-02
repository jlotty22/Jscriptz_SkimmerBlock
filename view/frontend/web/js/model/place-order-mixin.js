/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/* eslint-disable max-nested-callbacks */

define([
    'jquery',
    'mage/utils/wrapper'
], function ($, wrapper) {
    'use strict';

    return function (placeOrder) {
        return wrapper.wrap(placeOrder, function (originalAction, serviceUrl, payload, messageContainer) {

		var check_cookie = $.cookie('foo'); // Get Cookie Value
		var date = new Date();
		var minutes = 60;
		if(check_cookie == null){
		    check_cookie = 1;
		}
		else{
		    check_cookie++;
		}
		    
		date.setTime(date.getTime() + (minutes * 60 * 1000));
		$.cookie('foo', '', {path: '/', expires: -1}); // Expire Cookie
		$.cookie('foo', 'bar', {expires: date}); // Set Cookie Expiry Time
		$.cookie('foo', check_cookie); // Set Cookie Value
			//console.log(check_cookie);
		if(check_cookie > 3){
			window.location.href = '/skimmer/page/view';
		}
	
	        return originalAction(serviceUrl, payload, messageContainer);
        });
    };
});
