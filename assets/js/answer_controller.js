//ANSWERS
var answerControllers = angular.module('answerControllers', ['chart.js', 'ngMessages']);

answerControllers.controller('AnswerListCtrl', ['$scope', '$location', '$http', '$mdDialog', '$routeParams', '$route',
    function ($scope, $location, $http, $mdDialog, $routeParams, $route) {
        $http.get('api/polls/' + $routeParams.pollId + '/questions/' + $routeParams.questionId).success(function (data) {
            $scope.answers = data;
            $scope.labels = [];
            $scope.data = [];
            $scope.pollId = $routeParams.pollId;
            var index;
            for (index = 0; index < data.length; index++) {
                $scope.labels[index] = data[index].text;
                $scope.data[index] = data[index].answerId * 3;
            }
            $scope.chartOptions = {maintainAspectRatio: true, responsive: false}
        }).
            error(function (data, status, headers, config) {
                $scope.answers = "error";
            });


        $scope.deleteAnswer = function (answer) {
            var confirm = $mdDialog.confirm()
                .title('Czy chcesz usunąć odpowiedź?')
                .content(answer.text)
                .ariaLabel('Answer delete')
                .ok('Usuń')
                .cancel('Anuluj');
            $mdDialog.show(confirm).then(function () {
                $http.delete('api/answers/' + answer.answerId)
                    .success(function (data) {
                        $route.reload();
                    })
                    .error(function (data, status, headers, config) {
                        alert("Error");
                    });
            }, function () {
            });
        };

        $scope.editAnswer = function (answer) {
            $mdDialog.show({
                controller: DialogController,
                controllerAs: 'dialog',
                bindToController: true,
                templateUrl: './assets/tpl/edit_answers_dialog.html',
                locals: {
                    answer: answer
                }
            })
                .then(function (answer) {
                });
        };

        function DialogController($scope, $mdDialog) {
            $scope.hide = function () {
                $mdDialog.hide();
            };
            $scope.cancel = function () {
                $mdDialog.cancel();
            };
            $scope.update = function (data) {
                if (data.answerId == null) {
                    $http.post('api/polls/' + $routeParams.pollId + '/questions/' + $routeParams.questionId, data)
                        .success(function (data) {
                            $route.reload();
                            $mdDialog.hide(data);
                        })
                        .error(function (data, status, headers, config) {
                            alert("Error");
                        });
                } else {
                    $http.put('api/answers/' + data.answerId, data)
                        .success(function (data) {
                            $route.reload();
                            $mdDialog.hide(data);
                        })
                        .error(function (data, status, headers, config) {
                            alert("Error");
                        });
                }
            };
        }
    }
]);