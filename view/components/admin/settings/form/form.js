'use strict';

arikaim.component.onLoaded(function() {
    $('#settings_form .checkbox').on('change', function() {
        var settings = contactUsSettings.getSettings();
        options.save('contactus.form.settings',settings);
    });
});