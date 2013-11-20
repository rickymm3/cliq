function ThreadsCtrl($scope, $http) {
    $scope.getThreads = function(id) {
        if (!id) { id = 'reset'; 
        href = '';}
        href = 'api/example/threadlist/id/' + id;
        $http({method: 'GET', url: href}).
            success(function(data) {
                var href = '/cliq2/api/example/threadlist/id/'+id;
                history.pushState('', 'New URL: '+href, href);
                $scope.threadslist = data;                  //set view model
            }).
            error(function(data) {
                $scope.threadslist = data || "Request failed";
            });
  };
                         
  $scope.showThread = function(id) {
      $http({method: 'GET', url: 'api/example/thread/id/' + id}).
          success(function(data, status, headers, config) {
              $scope.appDetail = data;               //set view model
              $scope.view = './Partials/detail.html'; //set to detail view
          }).
          error(function(data, status, headers, config) {
              $scope.appDetail = data || "Request failed";
              $scope.status = status;
              $scope.view = './Partials/detail.html';
          });
  };
  
    $scope.sports = function() {
      $http({method: 'GET', url: 'api/example/threadlist/id/5'}).
          success(function(data) {
              $scope.threadslist = data;  
          });
    };
    $scope.reset = function() {
      $http({method: 'GET', url: 'api/example/threadlist/id/'}).
          success(function(data) {
              $scope.threadslist = data;  
          });
    };  
  
  $scope.name = 'ricky';
  $scope.view = './Partials//list.html'; //set default view
  $scope.getThreads();
}
ThreadsCtrl.$inject = ['$scope', '$http', '$templateCache'];