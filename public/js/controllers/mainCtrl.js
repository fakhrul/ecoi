
angular.module('mainCtrl', [])

	// inject the Comment service into our controller
	.controller('mainController', function($scope, $http, Channel) {
		// object to hold all the data for the new comment form
		$scope.commentData = {};

		// loading variable to show the spinning loading icon
		$scope.loading = true;

		// get all the comments first and bind it to the $scope.comments object
		// use the function we created in our service
		// GET ALL COMMENTS ====================================================
		Channel.get()
			.success(function(data) {
				$scope.channels = data;
				$scope.loading = false;
			});

		// function to handle submitting the form
		// SAVE A COMMENT ======================================================
		$scope.submitChannel = function() {
			$scope.loading = true;

			// save the comment. pass in comment data from the form
			// use the function we created in our service
			Channel.save($scope.channelData)
				.success(function(data) {

					// if successful, we'll need to refresh the comment list
					Channel.get()
						.success(function(getData) {
							$scope.channels = getData;
							$scope.loading = false;
						});

				})
				.error(function(data) {
					console.log(data);
				});
		};

		// function to handle deleting a comment
		// DELETE A COMMENT ====================================================
		$scope.deleteComment = function(id) {
			$scope.loading = true; 

			// use the function we created in our service
			Channel.destroy(id)
				.success(function(data) {

					// if successful, we'll need to refresh the comment list
					Channel.get()
						.success(function(getData) {
							$scope.channels = getData;
							$scope.loading = false;
						});

				});
		};

	});
	