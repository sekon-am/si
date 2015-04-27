'use strict';
addWareLogCtrl(
	'Warelog',
	make_filter('ip_filter','ip_start','ip_finish'),
	function($scope,$http){
		$scope.ip_filter = '';
		$scope.domain_filter = '';
		$scope.malware_filter = '';
		$scope.loadpages();
	},
	[]
);