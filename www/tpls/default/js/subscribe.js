function filter($scope) {
	return (($scope.ip_start) ? '&ip_start=' + $scope.ip_start : '') + (($scope.ip_finish) ? '&ip_finish='+$scope.ip_finish : '');
}
function additional($scope,$http) {
	$scope.dosubscribe = function () {
		$http.get('index.php?ctrl=warelog&action=addsubscr'+filter($scope));
	}
}
addWareLogCtrl('Subscribe',filter,additional);
