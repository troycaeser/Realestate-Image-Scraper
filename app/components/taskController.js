define(['angular'], function(angular){
	angular.module('taskController', [])
		.controller('mainController', function($scope, $http){
			$http.get('api/crawl')
				.success(function(data){
					$scope.message = data;
				});

			function sendShit($name){
				$dataObj = {
					url: $name
				};

				$http
					.post('api/crawl', $dataObj)
					.success(function(data){
						$scope.message2 = data;
					});
			}

			$scope.change = function(){
				sendShit($scope.inputBro);
			}
		});
});