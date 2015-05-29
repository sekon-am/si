'use strict';
angular.module('proxy',['angularFileUpload'])
.controller('ProxyCtrl',['$scope', '$http', '$window', '$upload', function($scope, $http, $window, $upload) {
	function make_filter() {
		var args = arguments;
		return function () {
			var res = '';
			for(var i=0;i<args.length;i++){
				var name = args[i];
				if( $scope[name] !== undefined ) {
					res += '&' + name + '=' + $scope[name];
				}
			}
			return res;
		}
	}
	var filter = make_filter('ip_filter','ip_start','ip_finish');
	$scope.loadpages = function (callback) {
		$http.get('index.php?ctrl=proxy&action=pages'+filter()).success(function(data){
			$scope.pages_amount = Math.max(1,data.pages_amount);
			if(!$scope.page_num){
				$scope.page_num = 1;
			}
			if(typeof callback == 'function')callback();
		});
	}
	$scope.loaddata = function () {
		$http.get('index.php?ctrl=proxy&action=data&from='+($scope.page_num-1)+filter()).success(function(data){
			$scope.fieldset = data;
		});
	}
	$scope.dosearch = function () {
		$scope.loadpages( $scope.loaddata );
		$scope.page_num = 1;
	}
	$scope.doexport = function (format) {
		$window.open('index.php?ctrl=proxy&action=data&from='+($scope.page_num-1)+filter()+'&format='+format);
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
					$scope.loadpages( $scope.loaddata );
				});
			}
		}
	});

	$scope.loadpages( $scope.loaddata );
}]);