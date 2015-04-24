'use strict';
angular.module('manusers',[])
.controller('ManusersCtrl',['$scope', '$http', function($scope, $http) {
	function get_users() {
		$http.get('index.php?ctrl=manusers&action=lst').success(
			function(data){
				$scope.users = data;
			}
		);
	}
	function add_for_init() {
		$scope.login = '';
		$scope.email = '';
		$scope.pass = '';
		$scope.repass = '';
		$scope.adderror = '';
	}
	$scope.adduser = function () {
		console.log('index.php?ctrl=manuser&action=add&login='+$scope.login+'&email='+$scope.email+'&pass='+$scope.pass+'&repass='+$scope.repass);
		if( !$scope.login ) {
			$scope.adderror = "Enter login";
			return;
		}
		if( !$scope.email ) {
			$scope.adderror = "Enter email";
			return;
		}
		if( !$scope.pass ) {
			$scope.adderror = "Enter password";
			return; 
		}
		if ($scope.pass != $scope.repass) {
			$scope.adderror = "Password and re-password are not matched";
			return;
		}
		$http.get('index.php?ctrl=manusers&action=add&login='+$scope.login+'&email='+$scope.email+'&pass='+$scope.pass).success(
			function(data){
				if(data>0){
					add_for_init();
					get_users();
				}
			}
		);
	};
	$scope.deluser = function(id,login,index) {
		if(confirm("Are you sure you want to delete " + login + "?")){
			$http.get('index.php?ctrl=manusers&action=del&id='+id).success(
				function (data) {
					if(data){
						$scope.users.splice(index,1);
					}
				}
			);
		}
	}
	
	add_for_init();
	get_users();
}]);