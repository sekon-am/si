'use strict';
angular.module('recovery',[])
.controller('RecCtrl',['$scope', '$http', function($scope, $http) {
	function initAlerts() {
		$scope.error = '';
		$scope.success = '';
	}
	initAlerts();
	$scope.dorecovery = function () {
		if(!($scope.login) && !($scope.email)) {
			initAlerts();
			$scope.error = 'Enter login or email';
			return;
		}
		if($scope.email && !($scope.email.match(/[\w\d_\-\.]+@[\w\d_\-\.]+\.\w{2,5}/g))){
			initAlerts();
			$scope.error = 'Email is not valid';
			return;
		}
		$http.get('index.php?ctrl=auth&action=recovery&email='+$scope.email+'&login='+$scope.login).success(
			function(data) {
				initAlerts();
				if(data){
					$scope.success = 'Your password was recovered successfuly';
				}else{
					$scope.error = 'There is no such user';
				}
			}
		);
	}
}]);