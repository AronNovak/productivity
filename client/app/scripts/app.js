'use strict';

/**
 * @ngdoc overview
 * @name clientApp
 * @description
 * # clientApp
 *
 * Main module of the application.
 */
angular
  .module('clientApp', [
    'ngAnimate',
    'ngCookies',
    'ngSanitize',
    'config',
    'LocalStorageModule',
    'ui.bootstrap',
    'ui.router',
    'angular-loading-bar',
    'ui.calendar'
  ])
  .config(function($stateProvider, $urlRouterProvider, $locationProvider, $httpProvider, cfpLoadingBarProvider) {

    /**
     * Redirect a user to a 403 error page.
     *
     * @param $state
     *   The ui-router state.
     * @param Auth
     *   The Auth service.
     * @param $timeout
     *   The timeout service.
     */
    var page403 = function($state, Auth,$timeout) {
      if (!Auth.isAuthenticated()) {
        // We need to use $timeout to make sure $state is ready to
        // transition.
        $timeout(function() {
          $state.go('403');
        });
      }
    };

    // Now set up the states.
    $stateProvider
      .state('homepage', {
        url: '/',
        controller: 'HomepageCtrl',
        resolve: {
          account: function(Account) {
            return Account.get();
          }
        }
      })
      .state('login', {
        title: 'Login',
        url: '/login',
        templateUrl: 'views/login.html',
        controller: 'LoginCtrl'
      })
      .state('github', {
        url: '/auth/github',
        templateUrl: 'views/github-auth.html',
        controller: 'GithubAuthCtrl'
      })
      .state('dashboard', {
        title: 'Dashboard',
        abstract: true,
        url: '',
        templateUrl: 'views/dashboard/main.html',
        controller: 'DashboardCtrl',
        onEnter: page403,
        resolve: {
          account: function(Account) {
            return Account.get();
          }
        }
      })
      .state('dashboard.tracking-form', {
        title: 'Tracking form',
        url: '/tracking/{username:string}/{year:int}/{month:int}/{day:string}/{id:string}',
        templateUrl: 'views/dashboard/tracking-form.html',
        controller: 'TrackingFormCtrl',
        onEnter: page403,
        resolve: {
          projects: function($stateParams, Projects) {
            return Projects.get($stateParams.year, $stateParams.month);
          },
          tracking: function($stateParams, Tracking) {
            return Tracking.get($stateParams.year, $stateParams.month, $stateParams.username);
          }
        }
      })
      .state('dashboard.tracking', {
        title: 'Tracking',
        url: '/tracking/{year:int}/{month:int}',
        templateUrl: 'views/dashboard/tracking.html',
        controller: 'TrackingCtrl',
        onEnter: page403
      })
      .state('dashboard.tracking-table', {
        title: 'Tracking table',
        url: '/tracking-table/{year:int}/{month:int}',
        templateUrl: 'views/dashboard/tracking-table.html',
        controller: 'TrackingTableCtrl',
        onEnter: page403,
        resolve: {
          security: function(account, $state) {
            if(account.roles.indexOf('administrator') < 0) {
              $state.go('dashboard.tracking-form');
            }
          },
          tracking: function($stateParams, Tracking, account) {
            if(account.roles.indexOf('administrator') >= 0) {
              return Tracking.get($stateParams.year, $stateParams.month);
            }
          },
          trackingProject: function($stateParams, TrackingProject, account) {
            if(account.roles.indexOf('administrator') >= 0) {
              return TrackingProject.get($stateParams.year, $stateParams.month);
            }
          }
        }
      })
      .state('dashboard.tracking.track', {
        title: 'Tracking table',
        url: '/tracking-table/{trackId:int}',
        templateUrl: 'views/dashboard/tracking-table.html',
        controller: 'TrackingCtrl',
        onEnter: page403,
        resolve: {
          tracking: function($stateParams, Tracking) {
            return Tracking.get($stateParams.year, $stateParams.month);
          }
        }
      })
      .state('dashboard.account', {
        title: 'My account',
        url: '/my-account',
        templateUrl: 'views/dashboard/account/account.html',
        controller: 'AccountCtrl',
        onEnter: page403,
        resolve: {
          account: function(Account) {
            return Account.get();
          }
        }
      })
      .state('403', {
        title: 'Forbidden',
        url: '/403',
        templateUrl: 'views/403.html'
      });

    // For any unmatched url, redirect to '/'.
    $urlRouterProvider.otherwise('/');

    // Define interceptors.
    $httpProvider.interceptors.push(function ($q, Auth, localStorageService) {
      return {
        'request': function (config) {

          if (!config.url.match(/login-token/)) {
            config.headers = {
              'access-token': localStorageService.get('access_token')
            };
          }
          return config;
        },

        'response': function(result) {
          if (result.data.access_token) {
            localStorageService.set('access_token', result.data.access_token);
          }
          return result;
        },

        'responseError': function (response) {
          if (response.status === 401) {
            Auth.authFailed();
          }

          return $q.reject(response);
        }
      };
    });

    // Configuration of the loading bar.
    cfpLoadingBarProvider.includeSpinner = true;
    cfpLoadingBarProvider.latencyThreshold = 0;
  })
  .run(function ($rootScope, $state, $stateParams, $log, Config) {
    // It's very handy to add references to $state and $stateParams to the
    // $rootScope so that you can access them from any scope within your
    // applications.For example:
    // <li ng-class="{ active: $state.includes('contacts.list') }"> will set the <li>
    // to active whenever 'contacts.list' or one of its decendents is active.
    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams;
    $rootScope.debug = Config.debugUiRouter;

    // If we're not on a local env, take the backend url for base URL.
    if (!Config.local) {
      Config.backend = window.location.protocol + '//' +  window.location.host + '/';
    }


      if (!!Config.debugUiRouter) {
      $rootScope.$on('$stateChangeStart',function(event, toState, toParams) {
        $log.log('$stateChangeStart to ' + toState.to + '- fired when the transition begins. toState,toParams : \n', toState, toParams);
      });

      $rootScope.$on('$stateChangeError',function() {
        $log.log('$stateChangeError - fired when an error occurs during transition.');
        $log.log(arguments);
      });

      $rootScope.$on('$stateChangeSuccess',function(event, toState) {
        $log.log('$stateChangeSuccess to ' + toState.name + '- fired once the state transition is complete.');
      });

      $rootScope.$on('$viewContentLoaded',function(event) {
        $log.log('$viewContentLoaded - fired after dom rendered',event);
      });

      $rootScope.$on('$stateNotFound',function(event, unfoundState, fromState, fromParams) {
        $log.log('$stateNotFound '+unfoundState.to+'  - fired when a state cannot be found by its name.');
        $log.log(unfoundState, fromState, fromParams);
      });
    }
  });
