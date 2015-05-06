'use strict';
addWareLogCtrl(
	'Warelog',
	make_filter('ip_filter','domain_filter','malware_filter'),
	function($scope,$http){
		$scope.ip_filter = '';
		$scope.domain_filter = '';
		$scope.malware_filter = '';
		$scope.loadpages();
	},
	[]
);