'use strict';
(function(){
	var first_time = true,
		filter = make_filter('ip_start','ip_finish','cidr');
	addWareLogCtrl('Subscribe',filter,function ($scope,$http) {
		$http.get('index.php?ctrl=subscribe&action=lst').success(
			function(data) {
				$scope.ranges = data;
			}
		);
		$scope.dosubscribe = function () {
			cidr2range();
			$http.get('index.php?ctrl=subscribe&action=add'+filter($scope)).success(
				function(data){
					$scope.ranges.push(data);
				}
			);
		};
		$scope.rangedel = function (id,index) {
			if(confirm("Are you sure you want to delete the range from your watchlist?")){
				$http.get('index.php?ctrl=subscribe&action=del&id='+id).success(
					function(data){
						$scope.ranges.splice(index,1);
					}
				);
			}
		};
		$scope.filtereddata = function(){
			cidr2range();
			$scope.loadpages();
			$scope.proxy_loadpages();
		};
		$scope.setrange = function(start,finish) {
			$scope.ip_start = start;
			$scope.ip_finish = finish;
			$scope.cidr = '';
			$scope.filtereddata();
		};
		function cidr2range() {
			if($scope.cidr) {
				$http.get('index.php?ctrl=warelog&action=cidr2range&cidr='+$scope.cidr).success(
					function (data){
						$scope.ip_start = data.ip_start;
						$scope.ip_finish = data.ip_finish;
					}
				);
			}
		};
		$scope.rangechange = function () {
			$scope.cidr = '';
		};
		$scope.proxy_loadpages = function () {
			$http.get('index.php?ctrl=proxy&action=pages'+filter($scope)).success(function(data){
				$scope.proxy_pages_amount = Math.max(1,data.pages_amount);
				if(! $scope.proxy_page_num){
					$scope.proxy_page_num = 1;
				}
				if( $scope.proxy_page_num > $scope.proxy_pages_amount ) {
					$scope.proxy_page_num = $scope.proxy_pages_amount;
				}
				$scope.proxy_loaddata();
			});
		};
		$scope.proxy_loaddata = function () {
			$http.get('index.php?ctrl=proxy&action=data&from='+($scope.proxy_page_num-1)+filter($scope)).success( 
				function(data) {
					$scope.proxies = data;
				}
			);
		};
	},
	[]);
})();
