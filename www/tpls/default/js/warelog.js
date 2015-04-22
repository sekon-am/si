'use strict';
angular.module('warelog',[])
.controller('DataCtrl',['$scope', '$http', '$window', function($scope, $http, $window) {
	var page_num;
	
	function loadPages(callback) {
		$http.get('index.php?ctrl=warelog&action=pages&ip_filter='+$scope.ip_filter+'&domain_filter='+$scope.domain_filter+'&malware_filter='+$scope.malware_filter).success(function(data){
			$scope.pages_amount = Math.max(1,data.pages_amount);
			$scope.pagesTo = Math.max(1,Math.min($scope.pages_amount,$scope.pagesTo));
			if(typeof callback == 'function')callback();
		});
	}
	function loadData(num) {
		if(!(num = Number(num)))num=0;
		$http.get('index.php?ctrl=warelog&action=data&from='+num+'&ip_filter='+$scope.ip_filter+'&domain_filter='+$scope.domain_filter+'&malware_filter='+$scope.malware_filter).success(function(data){
			$scope.fieldset = data;
			page_num = num;
			for(var i=0; i<$scope.pages.length; i++){
				$scope.pages[i].clss = ($scope.pages[i].num == page_num) ? 'active' : '';
			}
		});
	}
	function update_pages() {
		$scope.pages = [];
		for(var i=$scope.pagesFrom-1;i<$scope.pagesTo;i++){
			$scope.pages.push({num: i, clss: (i == page_num) ? 'active' : ''});
		}
	}

	$scope.loaddata = loadData;
	$scope.loadpages = function (){
		loadPages( loadData	);
	};
	$scope.doexport = function (format) {
		$window.open('index.php?ctrl=warelog&action=data&from='+page_num+'&ip_filter='+$scope.ip_filter+'&domain_filter='+$scope.domain_filter+'&malware_filter='+$scope.malware_filter+'&format='+format);
	}
	$scope.diagnosticLenLimit = 60;
	$scope.pagesFrom = 1;
	$scope.pages_amount = 1;
	$scope.ip_filter = '';
	$scope.domain_filter = '';
	$scope.malware_filter = '';
	loadPages(function(){
		$scope.pagesTo = Math.min($scope.pages_amount,10);
		loadData(0);
	});

	$scope.$watch('pagesFrom',function(){
		update_pages();
		if($scope.pagesFrom-1 > page_num){
			page_num = $scope.pagesFrom-1;
			loadData(page_num);
		}
	});
	$scope.$watch('pagesTo',function(){
		update_pages();
		if($scope.pagesTo-1 < page_num){
			page_num = $scope.pagesTo-1;
			loadData(page_num);
		}
	});
}]);