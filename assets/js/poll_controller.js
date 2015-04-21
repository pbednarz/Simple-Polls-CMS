//POLLS
var pollControllers = angular.module('pollControllers', ['chart.js', 'ngMessages']);

pollControllers.controller('PollListCtrl', ['$scope', '$location', '$http', '$mdDialog', '$routeParams', '$route',
    function ($scope, $location, $http, $mdDialog, $routeParams, $route) {
        $http.get('api/polls').success(function (data) {
            $scope.polls = data;
        }).
            error(function (data, status, headers, config) {
                $scope.polls = "error";
            });


        $scope.details = function (poll) {
            $location.path('/polls/' + poll.pollId);
            $location.replace();
        };

        $scope.deletePoll = function (poll) {
            var confirm = $mdDialog.confirm()
                .title('Czy chcesz usunąć ankietę?')
                .content(poll.title)
                .ariaLabel('Poll delete')
                .ok('Usuń')
                .cancel('Anuluj');
            $mdDialog.show(confirm).then(function () {
                $http.delete('api/polls/' + poll.pollId)
                    .success(function (data) {
                        $route.reload();
                    })
                    .error(function (data, status, headers, config) {
                        alert("Error");
                    });
            }, function () {
            });
        };

        $scope.editPoll = function (poll) {
            $mdDialog.show({
                controller: DialogController,
                controllerAs: 'dialog',
                bindToController: true,
                templateUrl: './assets/tpl/edit_polls_dialog.html',
                locals: {
                    poll: angular.copy(poll)
                }
            })
                .then(function (poll) {

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
                if (data.pollId == null) {
                    $http.post('api/polls/', data)
                        .success(function (data) {
                            $route.reload();
                            $mdDialog.hide(data);
                        })
                        .error(function (data, status, headers, config) {
                            alert("Error");
                        });
                } else {
                    $http.put('api/polls/' + data.pollId, data)
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