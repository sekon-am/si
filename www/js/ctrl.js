'use strict';
angular.module('sfp',['angularFileUpload'])
.filter('range',function () {
	return function (input,from,to){
		if(Object.prototype.toString.call( input ) === '[object Array]'){
			return input.slice(from-1,to-1);
		}
	}
})
.controller('DataCtrl',['$scope', '$http', '$upload', function($scope, $http, $upload) {
	$scope.diagnosticLenLimit = 60;
	$scope.pagesFrom = 1;
	$scope.pages_amount = 1;
	var page_num= 0;
	function loadData(num) {
		$http.get('api/index.php?action=data&from='+num).success(function(data){
			$scope.fieldset = data;
			page_num = num;
			$scope.pages[num].clss = 'active';
		});
	}
	function update_pages() {
		$scope.pages = [];
		for(var i=$scope.pagesFrom-1;i<$scope.pagesTo;i++){
			$scope.pages[i] = {num: i, clss: ''};
		}
	}
	function loadPages(callback) {
		$http.get('api/index.php?action=pages').success(function(data){
			$scope.pages_amount = data.pages_amount;
			update_pages();
			if(typeof callback == 'function')callback();
		});
	}
	$scope.$watch('pagesFrom',function(){
		update_pages();
		if($scope.pagesFrom-1>page_num){
			loadData($scope.pagesFrom-1);
		}
	});
	$scope.$watch('pagesTo',function(){
		update_pages();
		if($scope.pagesTo-1<page_num){
			loadData($scope.pagesTo-1);
		}
	});
/*	$scope.pageleft = function () {
		console.log('11');
		if(page>0){
			loadData(page-1);
		}
	};
	$scope.pageright = function () {
		console.log('22');
		if(page<$scope.pages.length-1){
			loadData(page+1);
		}
	};*/
	$scope.loaddata = loadData;
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
	loadPages(function(){
		$scope.pagesTo = Math.min($scope.pages_amount,10);
		loadData(0);
	});
}]);