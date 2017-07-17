/**
 * @author v.lugovksy
 * created on 16.12.2015
 */
(function () {
    'use strict';

    angular.module('BlurAdmin.pages.dashboard')
        .controller('DashboardCalendarCtrl', DashboardCalendarCtrl);

    /** @ngInject */
    function DashboardCalendarCtrl(baConfig, $scope, $http, toastr, $uibModal, baProgressModal) {
        $scope.open = function (page, size) {
            $uibModal.open({
                animation: true,
                templateUrl: page,
                size: size,
                resolve: {
                    items: function () {
                        return $scope.items;
                    }
                }
            });
        };
        $scope.openProgressDialog = baProgressModal.open;

        $scope.getUserProfile = function() {
            console.log("user profile");      

            $http.get('index.php?id=profile&token=' + sessionStorage.getItem("token"))
                .then(function(profileData) {
                    console.log(profileData); // success result
                    $scope.profileData = profileData;
                    return $http.get('index.php?id=unreadAnnouncement&token=' + sessionStorage.getItem("token"));
                }, function(errorMsg) {
                    console.log("User Authentication failed!");
                }).then(function(announcementData) {
                    console.log(announcementData);
                }, function(errorMsg2) {
                    console.log("Failed to get announcements");
                });
        }


        var dashboardColors = baConfig.colors.dashboard;
        var $element = $('#calendar').fullCalendar({
            //height: 335,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: '2017-06-24',
            selectable: true,
            selectHelper: true,
            select: function (start, end) {
                //$('#createEventModal').modal('show');
                var title = prompt("Add an event");
                var eventData;
                if (title) {
                    eventData = {
                        title: title,
                        start: start,
                        end: end
                    };
                    $element.fullCalendar('renderEvent', eventData, true); // stick? = true
                }
                $element.fullCalendar('unselect');
            },
            dayClick: function( date, jsEvent, view ) {
                // some info in console
                console.log('Clicked on: ' + date.format());
                $scope.open('app/pages/ui/modals/modalTemplates/warningModal.html');
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
            {
                title: 'CS2105 assignment 2',
                start: '2017-06-27',

                color: dashboardColors.silverTree
            },
            {
                title: 'CS2010 online quiz',
                start: '2017-06-22',
                end: '2017-06-22',
                color: dashboardColors.surfieGreen
            },
            {
                title: 'CS2010 problem set 3',
                start: '2017-06-11',
                color: dashboardColors.surfieGreen
            },
            {
                title: 'CS2107 project deadline',
                start: '2017-06-02',
                color: dashboardColors.gossipDark
            },
            {
                title: 'GES1010 assignment 1',
                start: '2017-07-25',
                color: dashboardColors.blueStone
            },
            {
                title: 'CS2107 midterm 2',
                start: '2017-07-14',
                color: dashboardColors.gossipDark
            }
            ]
        });
    }
})();
