'use strict';
angular.module('sfp',['angularFileUpload'])
.controller('DataCtrl',['$scope', '$http', '$upload', function($scope, $http, $upload) {
	var page = 0;
	function loadData(num) {
		$http.get('api/index.php?action=data&from='+num).success(function(data){
			$scope.fieldset = data;
			page = num;
			for(var i=0;i<$scope.pages.length;i++){
				$scope.pages[i].clss = '';
			}
			$scope.pages[page].clss = 'active';
		});
	}
	function loadPages(callback) {
		$http.get('api/index.php?action=pages').success(function(data){
			$scope.pages = data;
			callback();
		});
	}
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
					loadPages(function(){});
				}).error(function(data){
					console.log('Errod during uploading process... '+data);
				});
			}
		}
	});
	loadPages(function(){
		loadData(0);
	});
}]);