var app = angular.module(
     'app', ['ngSanitize']
 ).directive('ngEnter', function () {
     return function (scope, element, attrs) {
         element.bind('keydown keypress', function (event) {
             if (event.which === 13) {
                 scope.$apply(function () {
                     scope.$eval(attrs.ngEnter);
                 });
                 event.preventDefault();
             }
         });
     };
 }).directive('compileTemplate', function($compile, $parse){
     return {
         link: function(scope, element, attr){
             var parsed = $parse(attr.ngBindHtml);
             function getStringValue() {
                 return (parsed(scope) || '').toString();
             }
 
             // Recompile if the template changes
             scope.$watch(getStringValue, function() {
                 $compile(element, null, -9999)(scope);  // The -9999 makes it skip directives so that we do not recompile ourselves
             });
         }
     }
 });
 