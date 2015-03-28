var app = angular.module('PollsApp', ['ngMaterial', 'ngRoute', 'questionControllers', 'pollControllers']);
app.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider.
            when('/questions/:pollId', {
                templateUrl: './assets/tpl/question_lists.html',
                controller: 'QuestionListCtrl',
                title: "Questions",
                section: "Polls"
            }).
            when('/polls', {
                templateUrl: './assets/tpl/poll_lists.html',
                controller: 'PollListCtrl',
                title: "Polls",
                section: "Polls"
            }).
            otherwise({
                redirectTo: '/questions'
            });
    }]);

app.run(['$location', '$rootScope', function($location, $rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
        $rootScope.section = current.$$route.section;
    });
}]);