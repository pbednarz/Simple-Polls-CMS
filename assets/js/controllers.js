var questionControllers = angular.module('questionControllers', ['chart.js']);

questionControllers.controller('QuestionListCtrl', ['$scope', '$http', '$routeParams',
    function ($scope, $http, $routeParams) {
        $http.get('api/polls/' + $routeParams.pollId + '/questions').success(function (data) {
            $scope.questions = data;
            $scope.labels = ["Answer A", "Answer B", "Answer C", "Answer D"];
            $scope.data = [300, 500, 100, 100];
            $scope.chartOptions = {maintainAspectRatio: true, responsive: false}
        }).
            error(function (data, status, headers, config) {
                $scope.questions = "error";
            });
    }]);


var pollControllers = angular.module('pollControllers', ['chart.js']);

pollControllers.controller('PollListCtrl', ['$scope', '$http', '$routeParams',
    function ($scope, $http, $routeParams) {
        $http.get('api/polls').success(function (data) {
            $scope.polls = data;
            $scope.labels = ["Answer A", "Answer B", "Answer C", "Answer D"];
            $scope.data = [300, 500, 100, 100];
            $scope.chartOptions = {maintainAspectRatio: true, responsive: false}
        }).
            error(function (data, status, headers, config) {
                $scope.polls = "error";
            });
    }]);

