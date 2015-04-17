var app = angular.module('PollsApp', ['ngMaterial', 'ngRoute', 'authCtrl', 'questionControllers', 'pollControllers', 'ngAnimate', 'answerControllers']);
app.config(['$routeProvider','$locationProvider',
    function ($routeProvider, $locationProvider) {
        $routeProvider.
            when('/polls', {
                templateUrl: './assets/tpl/poll_lists.html',
                controller: 'PollListCtrl',
                title: "Polls"
            }).
            when('/polls/:pollId', {
                templateUrl: './assets/tpl/question_lists.html',
                controller: 'QuestionListCtrl',
                title: "Questions"
            }).
            when('/polls/:pollId/questions/:questionId', {
                templateUrl: './assets/tpl/answer_lists.html',
                controller: 'AnswerListCtrl',
                title: "Answers"
            }).
            otherwise({
                redirectTo: '/polls'
            });

    }]);

app.run(['$location', '$rootScope', '$route', function($location, $rootScope, $route) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
        $rootScope.pollId = current.params.pollId;
        $rootScope.questionId = current.params.questionId;
    });
    $rootScope.$on("$routeChangeStart", function (event, next, current) {
        $rootScope.authenticated = false;
        Data.get('session').then(function (results) {
            if (results.uid) {
                $rootScope.authenticated = true;
                $rootScope.uid = results.uid;
                $rootScope.username = results.username;
                $rootScope.email = results.email;
            } else {
                var nextUrl = next.$$route.originalPath;
                if (nextUrl == '/login') {
                } else {
                    $location.path("/login");
                }
            }
        });
    });

    $rootScope.reloadRoute = function() {
        $route.reload();
    }
}]);

app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {
    //initially set those objects to null to avoid undefined error
    $scope.login = {};
    $scope.signup = {};
    $scope.doLogin = function (admin) {
        Data.post('login', {
            username: admin.username,
            password: admin.password
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('dashboard');
            }
        });
    };
    $scope.logout = function () {
        Data.get('logout').then(function (results) {
            Data.toast(results);
            $location.path('login');
        });
    }
});

app.directive('focus', function() {
    return function(scope, element) {
        element[0].focus();
    }
});