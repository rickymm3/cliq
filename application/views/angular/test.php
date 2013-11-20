
 <script >
    
MyApp.app.service("tagDataSvc", function () {

var _tagId = {};

return {
    getTagId: function () {
        return _tagId;
    },
    setTagId: function (value) {
        _tagId = value;
    }
};

});
    
function PageCtrl($scope, $http, myService) {
  $scope.text = '<?=$cliqid?>';

var _tagId = {};


 $scope.$watch('myVar', function() {
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
   });
   }
       
   PageCtrl.$inject = ['$scope','tagDataSvc'];
   
</script>


    <div ng-controller="PageCtrl">
            <input type='submit' ng-click='getTagIdg()' />
    {{tagId}}
        <input ng-model='text' />
      <ul>
        <li >
          <span>{{text}}</span>
        </li>
      </ul>
    </div>

