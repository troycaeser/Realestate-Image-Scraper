/* @ngInject */
var FileUploadController = function(adItemService){
	_this = this;

	_this.dropzoneConfig = {
		'options': {
			url: 'api/upload',
			maxFileSize: 100,
			paramName: 'uploadFile',
			maxThumbnailFilesize: 10,
			parallelUploads: 1,
			autoProcessQueue: false
		},
		'eventHandlers': {
			//listen if dropzone has something dropped in
			'addedfile': function(file){
				adItemService.Crawl().addLinks(file);
			},
			'sending': function(file, xhr, formData){
				//sending code here
				console.log('sending?');
			},
			'success': function(file, response){
				//success code here
				console.log(response);
			}
		}
	};

};
//var eventHandlers = {
	//'addedFile': function(file){
		//scope.file = file;
		//if(this.files[1] != null){
			//this.removeFile(this.files[0]);
		//}
		//scope.$apply(function(){
			//scope.fileAdded = true;
		//});
	//},
	//'success': function(file, response){
		//response code here!
		//console.log(response);
	//}
//};

angular.module('fileUpload')
	.controller('fileUploadController', FileUploadController);
