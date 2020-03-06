// myModule.js
(function(angular, $, _) {
    // declare your module
    angular.module('myAngularModule', []);

    angular.module('crmMailing').directive('crmRemoveClass', function() {
        return {
            link: function (scope, element, attrs, crmUiIdCtrl) {
                $(element).removeClass('crm-section');
            }
        };
    });
})(angular, CRM.$, CRM._);