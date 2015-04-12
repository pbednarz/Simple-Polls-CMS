var app = angular.module('PollsApp', ['ngMaterial', 'ngRoute', 'questionControllers', 'pollControllers', 'answerControllers']);
app.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider.
            when('/polls', {
                templateUrl: './assets/tpl/poll_lists.html',
                controller: 'PollListCtrl',
                title: "Polls",
                sections: []
            }).
            when('/polls/:pollId', {
                templateUrl: './assets/tpl/question_lists.html',
                controller: 'QuestionListCtrl',
                title: "Questions",
                sections: ["Polls"]
            }).
            when('/polls/:pollId/questions/:questionId', {
                templateUrl: './assets/tpl/answer_lists.html',
                controller: 'AnswerListCtrl',
                title: "Answers",
                sections: ["Polls", "Questions"]
            }).
            otherwise({
                redirectTo: '/polls'
            });
    }]);

app.run(['$location', '$rootScope', function($location, $rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
        $rootScope.sections = current.$$route.sections;
    });
}]);