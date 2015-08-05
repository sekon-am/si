'use strict';
addWareLogCtrl(
	'Warelog',
	make_filter('cidr','domain_filter','malware_filter'),
	function($scope,$http){
		$scope.cidr = '';
		$scope.domain_filter = '';
		$scope.malware_filter = '';
		$scope.loadpages();
                $http.get('index.php?ctrl=warelog&action=malwares').success(function(data){
                    $scope.malwares = data;
                });
                $scope.filterdata = function() {
                    if($scope.malware_autocomplete){
                        $scope.malware_filter = $scope.malware_autocomplete.description.name;
                    }
                    $scope.loadpages($scope.loaddata);
                }
	},
	['ngTouch', 'angucomplete-alt']
);