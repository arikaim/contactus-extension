$(document).ready(function() {  
    safeCall('contactUsView',function(obj) {
        obj.initRows();
    },true);    
}); 