//QUESTIONS
var questionControllers = angular.module('questionControllers', ['chart.js']);

questionControllers.controller('QuestionListCtrl', ['$scope', '$rootScope', '$http', '$routeParams',
    function ($scope, $rootScope, $http, $routeParams) {
        $http.get('api/polls/' + $routeParams.pollId + '/questions').success(function (data) {
            $scope.questions = data;
            $rootScope.pollId = $routeParams.pollId;
        }).
            error(function (data, status, headers, config) {
                $scope.questions = "error";
            });
    }]);

//ANSWERS
var answerControllers = angular.module('answerControllers', ['chart.js']);

answerControllers.controller('AnswerListCtrl', ['$scope', '$http', '$routeParams',
    function ($scope, $http, $routeParams) {
        $http.get('api/polls/' + $routeParams.pollId + '/questions/' + $routeParams.questionId).success(function (data) {
            $scope.answers = data;
            $scope.labels = [];
            $scope.data = [];
            $scope.pollId = $routeParams.pollId;
            var index;
            for (index = 0; index < data.length; index++) {
                $scope.labels[index] = data[index].text;
                $scope.data[index] = data[index].answer_id;
            }
            $scope.chartOptions = {maintainAspectRatio: true, responsive: false}
        }).
            error(function (data, status, headers, config) {
                $scope.answers = "error";
            });
    }]);
