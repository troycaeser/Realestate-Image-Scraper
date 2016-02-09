/* @ngInject */
var FileUploadController = function(adItemService){
	_this = this;

	_this.dropzoneConfig = {
		'options': {
			url: 'api/upload',
			maxFileSize: 100,
			paramName: 'uploadFile',
			maxThumbnailFilesize: 10,
			uploadMultiple: true,
			parallelUploads: 5,
			autoProcessQueue: false
		},
		'eventHandlers': {
			//listen if dropzone has something dropped in
			'addedfile': function(file){
				adItemService.Crawl().addLinks(file);
			},
			'complete': function(evt){
				//console.log('drag ended bitch');
				console.log(this.getQueuedFiles().length);
			},
			'sending': function(file, xhr, formData){
				//sending code here
				console.log('sending?');
			},
			'success': function(file, response){
				console.log(this.getQueuedFiles().length);
				//success code here
				console.log(response);
			}
		}
	};

};

angular.module('fileUpload')
	.controller('fileUploadController', FileUploadController);
