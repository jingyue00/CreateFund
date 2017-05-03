/**
 * 
 */

app.factory('customerFactory', function ($http) {
	var baseURL = 'rs/';
	var suffix='customer';
	var instance={};
	 
	instance.list=function(){
		return $http.get(baseURL+suffix).then(
			function(response){
				return response.data;
			},
			function(response){
				alert('Status：'+response.status+'msg：' + response.statusText);
			}	
		)
	}
	// It saves with parameter
	instance.save=function(param){
		return $http.put(baseURL+suffix,param).then(
			function(response){
				return response.data;
			},
			function(response){
				alert('Status：'+response.status+'msg：' + response.statusText);
				}	
		)
	} 
	
	//It adds with entity
	instance.add=function(entity){
		return $http({
	        method: 'POST',
	        url:  baseURL + suffix,
	        data: entity,
	        headers: {
	             'Content-Type': 'application/json'
	         }}) .then(
			function(response){
				return response.data;
			},
			function(response){
					alert('Status：'+response.status+'msg：' + response.statusText);
			}	
		)
	}
	// it delete by id
	instance.remove=function(param){
		return $http({
	        method: 'DELETE',
	        url:  baseURL + suffix+'/'+param,
	        data: param,
	        headers: {
	             'Content-Type': 'application/json'
	         }}) .then(
			function(response){
				return response.data;
			},
			function(response){
				alert('Status：'+response.status+'msg：' + response.statusText);
			}	
		)
	}
	return instance;
});	
	