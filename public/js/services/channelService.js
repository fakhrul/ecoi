
angular.module('channelService', [])

	.factory('Channel', function($http) {

		return {
			// get all the comments
			get : function() {
				return $http.get('/channel');
			},

			// save a comment (pass in comment data)
			save : function(channelData) {
				return $http({
					method: 'POST',
					url: '/api/comments',
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param(channelData)
				});
			},

			// destroy a comment
			destroy : function(id) {
				return $http.delete('/channels/' + id);
			}
		}

	});
	