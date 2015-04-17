//QUESTIONS
var questionControllers = angular.module('questionControllers', ['chart.js', 'ngMessages']);

questionControllers.controller('QuestionListCtrl', ['$scope', '$location', '$http', '$mdDialog', '$routeParams', '$route',
    function ($scope, $location, $http, $mdDialog, $routeParams, $route) {
        $http.get('api/polls/' + $routeParams.pollId + '/questions').success(function (data) {
            $scope.questions = data;
        }).
            error(function (data, status, headers, config) {
                $scope.questions = "error";
            });


        $scope.details = function (question) {
            $location.path('/polls/' + question.pollId + '/questions' + question.questionId);
            $location.replace();
        };

        $scope.deleteQuestion = function (question) {
            var confirm = $mdDialog.confirm()
                .title('Czy chcesz usunąć pytanie?')
                .content(question.text)
                .ariaLabel('Question delete')
                .ok('Usuń')
                .cancel('Anuluj');
            $mdDialog.show(confirm).then(function () {
                $http.delete('api/questions/' + question.questionId)
                    .success(function (data) {
                        $route.reload();
                    })
                    .error(function (data, status, headers, config) {
                        alert("Error");
                    });
            }, function () {
            });
        };

        $scope.editQuestion = function (question) {
            $mdDialog.show({
                controller: DialogController,
                controllerAs: 'dialog',
                bindToController: true,
                templateUrl: './assets/tpl/edit_questions_dialog.html',
                locals: {
                    question: question
                }
            })
                .then(function (question) {
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
                if (data.questionId == null) {
                    $http.post('api/polls/' + $routeParams.pollId + '/questions/', data)
                        .success(function (data) {
                            $route.reload();
                            $mdDialog.hide(data);
                        })
                        .error(function (data, status, headers, config) {
                            alert("Error");
                        });
                } else {
                    $http.put('api/questions/' + data.questionId, data)
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