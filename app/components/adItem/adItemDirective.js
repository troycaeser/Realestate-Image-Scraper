/* @ngInject */
var AdItemDirective = function(adItemService){
	var adItemDirective = {
		restrict: 'AE',
		templateUrl: 'app/components/adItem/adItemDirective.html',
		compile: function(){
			return {
				pre: preLink,
				post: postLink
			}
		},
		controller: Controls,
		controllerAs: 'adItem',
		//binds "out" with parent scope
		//binds "model" with current scope
		//binds "remove" as a method
		scope:{
			listingType: "=",
			index: "@",
			model: "=",
			remove: "&",
		}
	};

	return adItemDirective;

	/* @ngInject */
	function Controls($scope, $element){
		var _this = this;
		var data = adItemService.Crawl().getData();

		var links = data.links;
		var propertyInfo = data.propertyInfo;
		var templateDirWeb = data.templateDirWeb;
		var templateInfo = data.templateInfo;

		var auctionHour = propertyInfo.auction_hour;
		var auctionDay = propertyInfo.auction_day;
		//console.log(data);

		//full array of values
		_this.values = [];
		_this.photo = {};

		//draw images
		//_this.source = links[$scope.index];
		if(typeof links[$scope.index] === "string"){
			_this.photo = {
				"src": links[$scope.index],
				"class": 'adItemPhotos'
			};
			console.log(_this.photo);
			_this.values.push(_this.photo);
		}else{
			var file = links[$scope.index];
			//need to convert file into dataurl
			reader = new FileReader();
			reader.onload = function(){
				$scope.$apply(function(){
					_this.photo = {
						"src": reader.result,
						"class": 'adItemPhotos'
					};
					_this.values.push(_this.photo);
				});
			}

			reader.readAsDataURL(file);
		}

		//add in the sources

		//add in templates
		_this.banner = {
			'src': templateDirWeb.Banner,
			'class': 'adItemBanner'
		};

		_this.bottom = {
			'src': templateDirWeb.Bottom,
			'class': 'adItemBottom'
		};

		_this.logo = {
			'src': templateDirWeb.Logo,
			'class': 'adItemLogo',
		};

		_this.bed = {
			'src': templateDirWeb.Bed,
			'class': 'adItemBed',
			'text': {
				text: propertyInfo.no_bed
			}
		};

		_this.bath = {
			'src': templateDirWeb.Bath,
			'class': 'adItemBath',
			'text': {
				text: propertyInfo.no_bath
			}
		};

		_this.car = {
			'src': templateDirWeb.Car,
			'class': 'adItemCar',
			'text': {
				text: propertyInfo.no_car
			}
		};

		//_this.bannerText = {
			//'firstLine': {
				//text: $scope.listing.firstLine
			//},
			//'secondLine': {
				//text: $scope.listing.secondLine
			//}
		//}

		if($scope.listingType.code == 'AC'){
			_this.bannerText = {
				'firstLine': {
					text: 'Auction this'
				},
				'secondLine': {
					text: propertyInfo.auction_day + " " + propertyInfo.auction_hour
				}
			};
		}else{
			_this.bannerText = {
				'firstLine': {
					text: 'JUST'
				},
				'secondLine': {
					text: 'LISTED'
				}
			};
		}

		//add in other elements
		if($scope.index == 0){
			if($scope.listingType.code == 'AC'){
				//add in positioning
				_this.bannerText.firstLine.style = {
					'font-family': propertyInfo.agency_localDir,
					'font-size': templateInfo.main.Banner.A.top.font_size + "pt",
					'left': templateInfo.main.Banner.A.top.t_pos_x,
					'top': templateInfo.main.Banner.A.top.t_pos_y,
					'margin-left': -templateInfo.main.Banner.A.top.font_size,
					'margin-top': -templateInfo.main.Banner.A.top.font_size,
					'color': 'rgb('+templateInfo.main.Text.colour_banner_r+','+templateInfo.main.Text.colour_banner_g+','+templateInfo.main.Text.colour_banner_b+')',
					'webkit-transform-origin': 'left top',
					'-webkit-transform': "rotate(-" + templateInfo.main.Banner.angle + "deg)"
				};

				_this.bannerText.secondLine.style = {
					'font-family': propertyInfo.agency_localDir,
					'font-size': templateInfo.main.Banner.A.bottom[auctionDay][auctionHour.length].font_size + "pt",
					'left': templateInfo.main.Banner.A.bottom[auctionDay][auctionHour.length].t_pos_x,
					'top': templateInfo.main.Banner.A.bottom[auctionDay][auctionHour.length].t_pos_y,
					'margin-left': -templateInfo.main.Banner.A.bottom[auctionDay][auctionHour.length].font_size,
					'margin-top': -templateInfo.main.Banner.A.bottom[auctionDay][auctionHour.length].font_size,
					'color': 'rgb('+templateInfo.main.Text.colour_banner_r+','+templateInfo.main.Text.colour_banner_g+','+templateInfo.main.Text.colour_banner_b+')',
					'webkit-transform-origin': 'left top',
					'-webkit-transform': "rotate(-" + templateInfo.main.Banner.angle + "deg)"
				};
			}else{
				_this.banner.style = {
					'left': templateInfo.main.Banner.pos_x_jl,
					'top': templateInfo.main.Banner.pos_y_jl
				};
				_this.bannerText.firstLine.style = {
					'font-family': propertyInfo.agency_localDir,
					'font-size': templateInfo.main.Banner.J.font_size + "pt",
					'left': templateInfo.main.Banner.J.top.t_pos_x,
					'top': templateInfo.main.Banner.J.top.t_pos_y,
					'margin-left': -templateInfo.main.Banner.J.font_size,
					'margin-top': -templateInfo.main.Banner.J.font_size,
					'color': 'rgb('+templateInfo.main.Text.colour_banner_r+','+templateInfo.main.Text.colour_banner_g+','+templateInfo.main.Text.colour_banner_b+')',
					'webkit-transform-origin': 'left top',
					'-webkit-transform': "rotate(-" + templateInfo.main.Banner.angle + "deg)"
				};

				_this.bannerText.secondLine.style = {
					'font-family': propertyInfo.agency_localDir,
					'font-size': templateInfo.main.Banner.J.font_size + "pt",
					'left': templateInfo.main.Banner.J.bottom.t_pos_x,
					'top': templateInfo.main.Banner.J.bottom.t_pos_y,
					'margin-left': -templateInfo.main.Banner.J.font_size,
					'margin-top': -templateInfo.main.Banner.J.font_size,
					'color': 'rgb('+templateInfo.main.Text.colour_banner_r+','+templateInfo.main.Text.colour_banner_g+','+templateInfo.main.Text.colour_banner_b+')',
					'webkit-transform-origin': 'left top',
					'-webkit-transform': "rotate(-" + templateInfo.main.Banner.angle + "deg)"
				};
			}

			_this.logo.style = {
				'left': templateInfo.main.Logo.pos_x,
				'top': templateInfo.main.Logo.pos_y,
			};

			_this.bed.style = {
				'left': templateInfo.main.Bed.pos_x,
				'top': templateInfo.main.Bed.pos_y
			};

			_this.bath.style = {
				'left': templateInfo.main.Bath.pos_x,
				'top': templateInfo.main.Bath.pos_y
			};

			_this.car.style = {
				'left': templateInfo.main.Car.pos_x,
				'top': templateInfo.main.Car.pos_y
			};

			//add in looped elements
			_this.values.push(_this.banner);
			_this.values.push(_this.bottom);
			_this.values.push(_this.logo);
			_this.values.push(_this.bannerText);
			_this.values.push(_this.bed);
			_this.values.push(_this.bath);

			if(propertyInfo.no_car != "N/A"){
				_this.bed.text.style = {
					'font-family': propertyInfo.agency_localDir,
					'font-size': templateInfo.main.Text.font_size + "pt",
					'left': templateInfo.main.Bed.t_pos_x,
					'top': templateInfo.main.Bed.t_pos_y - templateInfo.main.Text.font_size+"px",
					'line-height': templateInfo.main.Text.font_size + "px",
					'color': 'rgb('+templateInfo.main.Text.colour_r+','+templateInfo.main.Text.colour_g+','+templateInfo.main.Text.colour_b+')'
				};

				_this.bath.text.style = {
					'font-family': propertyInfo.agency_localDir,
					'font-size': templateInfo.main.Text.font_size + "pt",
					'left': templateInfo.main.Bath.t_pos_x,
					'top': templateInfo.main.Bath.t_pos_y - templateInfo.main.Text.font_size+"px",
					'line-height': templateInfo.main.Text.font_size + "px",
					'color': 'rgb('+templateInfo.main.Text.colour_r+','+templateInfo.main.Text.colour_g+','+templateInfo.main.Text.colour_b+')'
				};

				_this.car.text.style = {
					'font-family': propertyInfo.agency_localDir,
					'font-size': templateInfo.main.Text.font_size + "pt",
					'left': templateInfo.main.Car.t_pos_x,
					'top': templateInfo.main.Car.t_pos_y - templateInfo.main.Text.font_size+"px",
					'line-height': templateInfo.main.Text.font_size + "px",
					'color': 'rgb('+templateInfo.main.Text.colour_r+','+templateInfo.main.Text.colour_g+','+templateInfo.main.Text.colour_b+')'
				};
				_this.values.push(_this.car);
			}else if(propertyInfo.no_car == "N/A"){
				_this.bed.text.style = {
					'font-family': propertyInfo.agency_localDir,
					'font-size': templateInfo.main.Text.font_size + "pt",
					'left': templateInfo.main.Bed.t_pos_x_2,
					'top': templateInfo.main.Bed.t_pos_y_2 - templateInfo.main.Text.font_size+"px",
					'line-height': templateInfo.main.Text.font_size + "px",
					'color': 'rgb('+templateInfo.main.Text.colour_r+','+templateInfo.main.Text.colour_g+','+templateInfo.main.Text.colour_b+')'
				};

				_this.bath.text.style = {
					'font-family': propertyInfo.agency_localDir,
					'font-size': templateInfo.main.Text.font_size + "pt",
					'left': templateInfo.main.Bath.t_pos_x_2,
					'top': templateInfo.main.Bath.t_pos_y_2 - templateInfo.main.Text.font_size+"px",
					'line-height': templateInfo.main.Text.font_size + "px",
					'color': 'rgb('+templateInfo.main.Text.colour_r+','+templateInfo.main.Text.colour_g+','+templateInfo.main.Text.colour_b+')'
				};

				_this.car.text.style = {
					'font-family': propertyInfo.agency_localDir,
					'font-size': templateInfo.main.Text.font_size + "pt",
					'left': templateInfo.main.Car.t_pos_x_2,
					'top': templateInfo.main.Car.t_pos_y_2 - templateInfo.main.Text.font_size+"px",
					'line-height': templateInfo.main.Text.font_size + "px",
					'color': 'rgb('+templateInfo.main.Text.colour_r+','+templateInfo.main.Text.colour_g+','+templateInfo.main.Text.colour_b+')'
				};
			}
		}else{
			//add in positioning
			_this.logo.style = {
				'left': templateInfo.other.Logo.pos_x,
				'top': templateInfo.other.Logo.pos_y,
			};

			_this.values.push(_this.logo);
		}
	}

	function postLink(scope, elem, attrs){
		//postlinks functions here
		//elem.find('img.adItemLogo').css({'background-color': 'red'});
	}

	function preLink(scope, elem, attrs){
	}
};

angular.module('adItem')
	.directive('adItemDirective', AdItemDirective);
