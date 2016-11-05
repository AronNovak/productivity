'use strict';

/**
 * @ngdoc directive
 * @name clientApp.directive:loadingBarText
 * @description
 * # loadingBarText
 */
angular.module('clientApp')
  .directive('workSession', function () {
    return {
      restrict: 'E',
      template: '',
      controller: function($scope, WorkSession) {
        $scope.workSession = WorkSession.get();
      },
      // Isolate scope the directive, and avoid read or modify data from the parent scope.
      scope: {}
    };
  });
