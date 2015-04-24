'use strict';
addWareLogCtrl('Warelog',function ($scope) {
	return '&ip_filter='+$scope.ip_filter+'&domain_filter='+$scope.domain_filter+'&malware_filter='+$scope.malware_filter;
},function($scope,$http){
	$scope.pagesFrom = 1;
	$scope.pages_amount = 1;
	$scope.loadpages(
		function(){
			$scope.pagesTo = Math.min($scope.pages_amount,10);
			$scope.loaddata($scope.pagesFrom);
		}
	);
});