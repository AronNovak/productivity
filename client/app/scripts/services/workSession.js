'use strict';

/**
 * @ngdoc service
 * @name clientApp.WorkSession
 * @description
 * # WorkSession
 * Service in the clientApp.
 */
angular.module('clientApp')
  .service('WorkSession', function ($q, $http, $timeout, Config, $rootScope) {

    // A private cache key.
    var cache = {};

    // Update event broadcast name.
    var broadcastUpdateEventName = 'ProductivityWorkSessionChange';

    /**
     * Return the promise with the events list, from cache or the server.
     *
     * @returns {*}
     */
    this.get = function(employee, day, month, year) {
      return $q.when(getCache(employee, day, month, year) || getDataFromBackend(employee, day, month, year));
    };

    /**
     * Return events array from the server.
     *
     * @returns {$q.promise}
     */
    var getDataFromBackend = function(employee, day, month, year) {
      var deferred = $q.defer();
      var url = Config.backend + '/api/work-sessions?filter[employee]=9&filter[start][value]=1457422770&filter[start][operator]=">"&filter[end][value]=1457454740&filter[end][operator]="<"';
      // Debug mode.
      if (Config.debug) {
        url += '&XDEBUG_SESSION_START=14241';
      }

      $http({
        method: 'GET',
        url: url
      }).success(function(response) {
        // Create header days.
        setCache(response.data, employee, day, month, year);
        deferred.resolve(response.data);
      });

      return deferred.promise;
    };


    /**
     * Set the cache from the server.
     *
     * @param year
     *   The year to get the id of the cache.
     * @param month
     *   The month to get the id of the cache.
     */
    var getCache = function(employee, day, month, year) {
      // Cache data.
      if (cache[year + '_' + month] != undefined) {
        return cache[year + '_' + month].data;
      }
      return false;
    };


    /**
     * Set the cache from the server.
     *
     * @param data
     *   The data to cache
     * @param year
     *   The year to set the id of the cache.
     * @param month
     *   The month to set the id of the cache.
     */
    var setCache = function(data, employee, day, month, year) {
      // Cache data.

      cache[year + '_' + month] = {
        data: data,
        timestamp: new Date()
      };

      // Clear cache in 60 seconds.
      $timeout(function() {
        cache = {};
      }, 900000);

      // Broadcast a change event.
      $rootScope.$broadcast(broadcastUpdateEventName);
    };
    $rootScope.$on('clearCache', function() {
      cache = {};
    });

  });
