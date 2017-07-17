/**
 * @author v.lugovksy
 * created on 16.12.2015
 */
(function () {
  'use strict';

  angular.module('BlurAdmin.pages.dashboard')
      .controller('DashboardTodoCtrl', DashboardTodoCtrl);

  /** @ngInject */
  function DashboardTodoCtrl($scope, baConfig, $http) {

    $scope.transparent = baConfig.theme.blur;
    var dashboardColors = baConfig.colors.dashboard;
    var colors = [];
    for (var key in dashboardColors) {
      colors.push(dashboardColors[key]);
    }

    function getRandomColor() {
      var i = Math.floor(Math.random() * (colors.length - 1));
      return colors[i];
    }

    // <p id="date"></p>
    //   <script>
    //     n =  new Date();
    //     y = n.getFullYear();
    //     m = n.getMonth() + 1;
    //     d = n.getDate();
    //   </script>
    
    //getting student id e00*****
    $scope.studID = $scope.profileData.data.Results[0].UserID;
//    console.log("id here:");
//    console.log($scope.studID);
    
    $scope.todoList = [
      //document.getElementById("date").innerHTML = m + "." + d + "." + y;
      { text: 'Print CS2107 lecture notes' },
      { text: 'Revise GES chapter 4y' },
      { text: 'Do CS2010 PS3' },
    ];

   $http.get('/phpscripts/index.php?userID=$scope.studID').then(function(todoData){
     $scope.todoData = todoData;
       console.log("todo data:");
       console.log($scope.todoData);
        }, function(errorMsg) {
            console.log("no todo");
        });  

    $scope.todoList.forEach(function(item) {
      item.color = getRandomColor();
    });

    $scope.newTodoText = '';

    $scope.addToDoItem = function (event, clickPlus) {
      if (clickPlus || event.which === 13) {
        $scope.todoList.unshift({
          text: $scope.newTodoText,
          color: getRandomColor(),
        });
        $scope.newTodoText = '';
      }
    };
  }
})();