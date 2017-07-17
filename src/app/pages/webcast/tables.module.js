/**
 * @author v.lugovsky
 * created on 16.12.2015
 */

(function () {
  'use strict';

  angular.module('BlurAdmin.pages.tables', [])
      .config(routeConfig);

  /** @ngInject */
  function routeConfig($stateProvider) {
    $stateProvider
        .state('tables', {
          url: '/tables',
          templateUrl: 'app/pages/tables/tables.html',
          controller: 'TablesPageCtrl',
          title: 'Webcasts',
          sidebarMeta: {
            icon: 'ion-grid',
            order: 300,
          },
        });
  }

})();

//(function () {
//  'use strict';
//
//  angular.module('BlurAdmin.pages.tables.smart', [])
//    .config(routeConfig);
//    
//  function routeConfig($stateProvider) {
//    $stateProvider
//        .state('tables.smart', {
//          url: '/tables/smart',
//          templateUrl: 'app/pages/tables/smart/tables.html',
//          title: 'Webcasts',
//          sidebarMeta: {
//            icon: 'ion-grid',
//            order: 300,
//          },
//        });
//  }
//  /** @ngInject */
//  function routeConfig($stateProvider, $urlRouterProvider) {
//    $stateProvider
//        .state('tables.smart', {
//          url: '/smart',
//          //template : '<ui-view  autoscroll="true" autoscroll-body-top></ui-view>',
//          templateUrl: 'app/pages/tables/smart/tables.html',
//          //abstract: true,
//          controller: 'TablesPageCtrl',
//          title: 'Webcast',
//          sidebarMeta: {
//            icon: 'ion-grid',
//            order: 300,
//          },
////        }).state('tables.basic', {
////          url: '/basic',
////          templateUrl: 'app/pages/tables/basic/tables.html',
////          title: 'Basic Tables',
////          sidebarMeta: {
////            order: 0,
////          },
//        }).state('tables.smart', {
//          url: '/smart',
//          templateUrl: 'app/pages/tables/smart/tables.html',
//          title: 'Webcast',
//          sidebarMeta: {
//            order: 100,
//          },
//        });
//    $urlRouterProvider.when('/tables','/tables/basic');
//  }

//})();

//    $stateProvider
//        .state('dashboard', {
//          url: '/dashboard',
//          templateUrl: 'app/pages/dashboard/dashboard.html',
//          title: 'Dashboard',
//          sidebarMeta: {
//            icon: 'ion-android-home',
//            order: 0,
//          },
//        });