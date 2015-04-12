//POLLS
var pollControllers = angular.module('pollControllers', ['chart.js']);

pollControllers.controller('PollListCtrl', ['$scope', '$location', '$http', '$mdDialog', '$routeParams',
    function ($scope, $location, $http, $mdDialog, $routeParams) {
        $http.get('api/polls').success(function (data) {
            $scope.polls = data;
        }).
            error(function (data, status, headers, config) {
                $scope.polls = "error";
            });


        $scope.details = function (poll) {
            $location.path('/polls/' + poll.poll_id);
            $location.replace();
        };

        $scope.showAdvanced = function (poll) {
            $mdDialog.show({
                controller: DialogController,
                controllerAs: 'dialog',
                bindToController: true,
                templateUrl: './assets/tpl/edit_polls_dialog.html',
                locals: {
                    poll: poll
                }
            })
                .then(function (poll) {
                    $location.path('/');
                    $http.delete('api/polls/' + poll.poll_id).success(function (data) {
                        alert(data);
                    }).
                        error(function (data, status, headers, config) {
                            alert("Error");
                        });
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
                $mdDialog.hide(data);
            };
        }
    }


]);