angular.module('spApp', ["spApp.controllers"], function($httpProvider){
  // Use x-www-form-urlencoded Content-Type
  $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

  /**
   * The workhorse; converts an object to x-www-form-urlencoded serialization.
   * @param {Object} obj
   * @return {String}
   */
  var param = function(obj) {
    var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

    for(name in obj) {
      value = obj[name];

      if(value instanceof Array) {
        for(i=0; i<value.length; ++i) {
          subValue = value[i];
          fullSubName = name + '[' + i + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += param(innerObj) + '&';
        }
      }
      else if(value instanceof Object) {
        for(subName in value) {
          subValue = value[subName];
          fullSubName = name + '[' + subName + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += param(innerObj) + '&';
        }
      }
      else if(value !== undefined && value !== null)
        query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
    }

    return query.length ? query.substr(0, query.length - 1) : query;
  };

  // Override $http service's default transformRequest
  $httpProvider.defaults.transformRequest = [function(data) {
    return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
  }];
})
.factory("commonService", ["$location", function($location){
  return {
    getUrlParameter : function(key){
      var value = "", params = $location.url() ? $location.url().split("/")[1].split("&") : [];
      angular.forEach(params, function (v) {
        if (v.split("=")[0] === key) {
          value = v.split("=")[1];
          return;
        }
      });
      return value;
    }
  };
}])
.config(function ($routeProvider) {
  return $routeProvider
    .when("/", {
      controller: 'userController'
    }).when("/add", {
      controller: 'userController'
    }).otherwise({
      redirectTo: '/'
    });
}).run(function ($route) {
});
angular.module("spApp.controllers", [])
  .controller('userController', ['$scope', '$http', '$routeParams', 'commonService', function($scope, $http, $routeParams, commonService){
    console.log("add" + $routeParams);
    $scope.action = commonService.getUrlParameter("a");
    $scope.form = {};
    $scope.saveFormData = function () {
      $http.post("/api.php?m=apir_user&a=add", $scope.form)
        .success(function (data, status, headers, config) {
          console.log(data);
        });
    };
    $scope.setFormData = function () {
      $scope.form = {
        "username" : "Owen",
        "password" : "123456",
        "email"    : "Owen@gmail.com",
        "is_disable" : "0"
      };
    };
    if ($scope.action === "edit") {
      $scope.setFormData();
    }
  }]);