'use strict';
function make_filter() {
	var args = arguments;
	return function ($scope) {
		var res = '';
		for(var i=0;i<args.length;i++){
			var name = args[i];
			if( $scope[name] !== undefined && $scope[name] ) {
				res += '&' + name + '=' + $scope[name];
			}
		}
		return res;
	}
}
function addWareLogCtrl(name,filter,additional,modules){
	angular.module(name,modules)
	.controller(name+'Ctrl',['$scope', '$http', '$window', function($scope, $http, $window) {
                function getHiddenParam(name) {
                    var element = document.getElementById(name);
                    if(element){
                        return element.value;
                    }
                    return null;
                }
                var country = getHiddenParam('country');
                var malware = getHiddenParam('malware');
                var port = getHiddenParam('port');
                function addparams() {
                    var add = '';
                    if(country)add += '&country='+country;
                    if(malware)add += '&malware_filter='+malware;
                    if(port)add += '&port='+port;
                    return add;
                }
		$scope.loadpages = function () {
			$http.get('index.php?ctrl=warelog&action=pages'+addparams()+filter($scope)).success(function(data){
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
			$http.get('index.php?ctrl=warelog&action=data&from='+($scope.page_num-1)+addparams()+filter($scope)).success(function(data){
				$scope.fieldset = data;
			});
		}
                $scope.goto = function (num) {
                    if(1 <= num && num <= $scope.pages_amount){
                        $scope.page_num = num;
                        $scope.loaddata();
                    }else{
                        alert("Page number must be from 1 to " + $scope.pages_amount + " range" );
                    }
                }
		$scope.doexport = function (format) {
			$window.open('index.php?ctrl=warelog&action=data&from='+($scope.page_num-1)+'&format='+format+addparams()+filter($scope));
		}
		if(typeof additional === "function"){
			additional($scope,$http);
		}
	}]);
}
