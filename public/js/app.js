 var csgApp = angular.module('csgApp', [],function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
	});


csgApp.factory('pukFactory', function($http) {
  return {

    getPUK: function(id,callback) {
        $http.get('http://'+window.location.hostname+'/admin/subscribers/'+id+'/puk').success(callback); 
    },
    getBill: function(id,callback) {
        $http.get('http://'+window.location.hostname+'/admin/subscribers/'+id+'/bill').success(callback);
    },
    getCust: function(id,callback) {
        $http.get('http://'+window.location.hostname+'/admin/subscribers/'+id+'/cust').success(callback);
    }        
  };
});

csgApp.controller('pukController', function($scope, pukFactory) {
       
  $scope.pukRefresh = function(id,$http) {
		pukFactory.getPUK(id,function(results) {
		    console.log(JSON.stringify(results,undefined, 2));
		    $scope.puk = results;
		  });
    } 
  $scope.billRefresh = function(id,$http) {
		pukFactory.getBill(id,function(results) {
		    console.log(JSON.stringify(results,undefined, 2));
		    $scope.bill = results;
		  });
    } 
  $scope.custRefresh = function(id,$http) {
		pukFactory.getCust(id,function(results) {
		    console.log(JSON.stringify(results,undefined, 2));
		    $scope.cust = results;
		  });
    }
});