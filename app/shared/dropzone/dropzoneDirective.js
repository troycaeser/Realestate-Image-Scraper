/* @ngInject */
var Dropzone = function(){
	var dropzoneDirective = {
		restrict: 'AE',
		compile: function(){
			return {
				post: postLink
			}
		},
		scope:{
			configuration: "="
		}
	};

	return dropzoneDirective;

	/* @ngInject */
	function postLink(scope, element, attrs){
		var config, dropzone;

		config = scope.configuration;

		dropzone = new Dropzone(element[0], config.options);

		angular.forEach(config.eventHandlers, function(handler, event) {
			dropzone.on(event, handler);
		});

		/*scope.processDropzone = function() {
			dropzone.processQueue();
		};

		scope.resetDropzone = function() {
			dropzone.removeAllFiles();
		}*/
	};
};

angular.module('fileUpload')
	.directive('dropzoneDirective', Dropzone);
