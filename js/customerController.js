/**
 * 
 */
app.controller('customerCtrl',function PostController($scope, customerFactory) {
					$scope.regions = [ "Asia", "Europe", "Africa",
							"North America", "South America" ];
					$scope.customers = [];
					$scope.customer = null;
					$scope.editMode = false;

					// get all Ｃustomers
					$scope.getAll = function() {
						customerFactory.list()
						               .then(
										function(data) {
											$scope.customers = data;
										})
					}

					// Add customer
					$scope.add = function() {
						var currentCustomer = this.customer;
						if (currentCustomer != null) {
							customerFactory.add(currentCustomer)
									       .then(
											function(data) {
												$scope.customers
														.push(currentCustomer);
												// reset form
												$scope.customer = null;
												$("#myModal").modal('hide');
												$scope.getAll();
											})
						}
					}

					// update customer
					$scope.update = function() {
						var currentCustomer = this.customer;
						customerFactory.save(currentCustomer)
								       .then(
										function(data) {
											$('#myModal').modal('hide');
											currentCustomer.editMode = false;
											$scope.getAll();
										})
					}
					// remove customer
					$scope.remove = function() {
						var currentCustomer = this.customer;
						customerFactory.remove(currentCustomer.id)
						        .then(
										function(data) {
											$scope.getAll();
										})
								
					}

					$scope.showadd = function() {
						$scope.customer = null;
						$scope.editMode = false;
						$('#myModal').modal('show');
					};

					$scope.edit = function() {
						$scope.customer = this.customer;
						$scope.editMode = true;
						$('#myModal').modal('show');
					};

					$scope.cancel = function() {
						$scope.user = null;
						$('#myModal').modal('hide');
					};

					// initialize your Customers data
					$scope.getAll();
				});
