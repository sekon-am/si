'use strict';
angular.module('sfp',['angularFileUpload'])
.controller('DataCtrl',['$scope', '$http', '$upload', function($scope, $http, $upload) {
	var page_num;
	
	function loadPages(callback) {
		$http.get('api/index.php?action=pages').success(function(data){
			$scope.pages_amount = data.pages_amount;
			if(typeof callback == 'function')callback();
		});
	}
	function loadData(num) {
		$http.get('api/index.php?action=data&from='+num).success(function(data){
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
	$scope.diagnosticLenLimit = 60;
	$scope.pagesFrom = 1;
	$scope.pages_amount = 1;
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
	$scope.$watch('files',function(){
		var files = $scope.files;
		if(files && files.length){
			for(var i=0;i<files.length;i++){
				var file = files[i];
				$upload.upload({
					url:'api/index.php?action=import',
					file:file
				}).progress(function(evt){
					var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
					console.log('progress: ' + progressPercentage + '% ' + evt.config.file.name);
				}).success(function(data, status, headers, config){
					loadPages();
				}).error(function(data){
					console.log('Errod during uploading process... '+data);
				});
			}
		}
	});
}]);