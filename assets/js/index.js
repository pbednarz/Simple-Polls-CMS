var app = angular.module('PollsApp', ['ngMaterial', 'toaster', 'ngRoute', 'questionControllers', 'pollControllers', 'ngAnimate', 'answerControllers']);

app.config(['$routeProvider', '$locationProvider',
    function ($routeProvider, $locationProvider) {
        $routeProvider.
            when('/login', {
                title: 'Login',
                templateUrl: './assets/tpl/login.html',
                controller: 'authCtrl'
            })
            .when('/logout', {
                title: 'Login',
                templateUrl: './assets/tpl/login.html',
                controller: 'authCtrl'
            })
            .when('/polls', {
                templateUrl: './assets/tpl/poll_lists.html',
                controller: 'PollListCtrl',
                title: "Ankiety"
            })
            .when('/polls/:pollId', {
                templateUrl: './assets/tpl/question_lists.html',
                controller: 'QuestionListCtrl',
                title: "Pytania"
            })
            .when('/polls/:pollId/questions/:questionId', {
                templateUrl: './assets/tpl/answer_lists.html',
                controller: 'AnswerListCtrl',
                title: "Odpowiedzi"
            })
            .when('/404', {
                templateUrl: './assets/tpl/404.html',
                title: "404",
                controller: 'authCtrl'
            })
            .when('/', {
                redirectTo: '/login'
            })
            .otherwise({
                redirectTo: '/404'
            });

    }]).run(['$location', '$rootScope', '$route', 'Data', function ($location, $rootScope, $route, Data) {
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
                if (nextUrl == '/login' || nextUrl == '/404') {
                } else {
                    $location.path("/login");
                }
            }
        });
    });

    $rootScope.reloadRoute = function () {
        $route.reload();
    };

    $rootScope.login = {};
    $rootScope.logout = function () {
        Data.get('logout').then(function (results) {
            Data.toast(results);
            $location.path('logout');
        });
    };

    $rootScope.goGithub = function () {
        $window.open('//github.com/pbednarz/Simple-Polls-CMS');
    }
}]);

app.directive('focus', function () {
    return function (scope, element) {
        element[0].focus();
    }
});

app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $window, $location, $http, Data) {
    $scope.doLogin = function (admin) {
        Data.post('login', {
            username: admin.username,
            password: admin.password
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('/polls');
            }
        });
    };
});

app.config(function ($mdThemingProvider) {
    // Configure a dark theme with primary foreground yellow
    $mdThemingProvider.theme('docs-dark', 'default')
        .dark();
});

app.run(function ($http) {
    $http.defaults.headers.common.Authorization = 'Basic YWRtaW46YWRtaW4='
});