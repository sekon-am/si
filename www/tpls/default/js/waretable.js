'use strict';
function make_filter() {
	var args = arguments;
	return function ($scope) {
		var res = '';
		for(var i=0;i<args.length;i++){
			var name = args[i];
			if( $scope[name] !== undefined ) {
				res += '&' + name + '=' + $scope[name];
			}
		}
		return res;
	}
}
function addWareLogCtrl(name,filter,additional,modules){
	angular.module(name,modules)
	.controller(name+'Ctrl',['$scope', '$http', '$window', function($scope, $http, $window) {
		$scope.loadpages = function () {
			$http.get('index.php?ctrl=warelog&action=pages'+filter($scope)).success(function(data){
				$scope.pages_amount = Math.max(1,data.pages_amount);
				if(! $scope.page_num){
					$scope.page_num = 1;
				}
				if( $scope.page_num > $scope.pages_amount ) {
					$scope.page_num = $scope.pages_amount;
				}
				$scope.loaddata();
			});
		};
		$scope.loaddata = function () {
			$http.get('index.php?ctrl=warelog&action=data&from='+($scope.page_num-1)+filter($scope)).success(function(data){
				$scope.fieldset = data;
			});
		}
		$scope.doexport = function (format) {
			$window.open('index.php?ctrl=warelog&action=data&from='+(page_num-1)+'&format='+format+filter($scope));
		}
		if(typeof additional === "function"){
			additional($scope,$http);
		}
	}]);
}
