'use strict';
angular.module('proxy',['angularFileUpload'])
.controller('ProxyCtrl',['$scope', '$http', '$window', '$upload', function($scope, $http, $window, $upload) {
	function loadPages(callback) {
		$http.get('index.php?ctrl=proxy&action=pages').success(function(data){
			$scope.pages_amount = Math.max(1,data.pages_amount);
			$scope.page_num = Math.max(1,Math.min($scope.pages_amount,$scope.page_num));
			if(typeof callback == 'function')callback();
		});
	}
	function loadData() {
		$http.get('index.php?ctrl=proxy&action=data&from='+($scope.page_num-1)).success(function(data){
			$scope.fieldset = data;
		});
	}
	$scope.loaddata = loadData;
	$scope.doexport = function (format) {
		$window.open('index.php?ctrl=proxy&action=data&from='+($scope.page_num-1)+'&format='+format);
	}
	$scope.$watch('files', function () {
		var files = $scope.files;
		if (files && files.length) {
			for (var i = 0; i < files.length; i++) {
				var file = files[i];
				$upload.upload({
					url: 'index.php?ctrl=proxy&action=import',
					file: file
				}).progress(function (evt) {
					var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
					console.log('progress: ' + progressPercentage + '% ' + evt.config.file.name);
				}).success(function (data, status, headers, config) {
					loadPages( loadData	);
				});
			}
		}
	});

	loadPages(function(){
		loadData();
	});
	
}]);