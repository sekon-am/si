'use strict';
function filter($scope) {
	return '&ip_filter='+$scope.ip_filter+'&domain_filter='+$scope.domain_filter+'&malware_filter='+$scope.malware_filter;
}
addWareLogCtrl('Warelog',filter);
