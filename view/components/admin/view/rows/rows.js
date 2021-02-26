'use strict';

arikaim.component.onLoaded(function() {
    safeCall('contactUsView',function(obj) {
        obj.initRows();
    },true);    
}); 