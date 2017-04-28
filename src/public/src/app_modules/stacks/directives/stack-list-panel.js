(function(){
    
    angular.module('app.stacks').directive('stackListPanel', ['config', '$cookieStore', function(config, $cookieStore){
            
            return {
                restrict: 'E',
                templateUrl: config.SRC_FOLDER + 'stacks/templates/stack-list-panel.html',
                transclude: true,       
                link: function(scope, element, attrs) {
                    scope.img_folder = config.PROFILE_IMG_FOLDER;
                    
                    scope.current_stack = $cookieStore.get("stack_id");
                },
                controller: ['$scope', '$rootScope', '$log', 'config', 'stacksFactory', 'ModalService', 
                    function($scope, $rootScope, $log, config, stacksFactory, ModalService) {
                     
                        /**
                         * Get stack list
                         */
                        $scope.stacks = stacksFactory.query();

                        /**
                         * Create new stack
                         */
                        $scope.addNew = function() {
                            ModalService.showModal({
                                templateUrl: config.SRC_FOLDER + "stacks/templates/modals/new-stack.html",
                                controller: "NewStackController"
                            }).then(function(modal) {
                                modal.element.modal();
                                modal.close.then(function (result) {

                                    if (result) {    

                                        // prepare data to submit to server 
                                        let stack = {
                                            name: modal.scope.form.name,
                                            description: modal.scope.form.description
                                        }

                                        stacksFactory.save(stack).$promise.then(function(response) {
                                            
                                            // emmit event
                                            stack.id = response.id;
                                            $rootScope.$broadcast('new-stack', stack);
                                            
                                            // add to stack
                                            $scope.stacks.unshift(stack);
                                        }, function(err) {

                                        });
                                    }
                                });
                            }, function(err) {
                                $log.error(err);
                            });
                        }
                        
                        /**
                         * Filter by stack
                         */
                        $scope.filter = function($event, stack_id) {
                            
                            $event.preventDefault();
                            $event.stopPropagation();
                            
                            let li = $($event.currentTarget);
                            
                            li.closest('ul').find('.list-group-item').removeClass('selected');
                            li.parent().addClass('selected');
                            
                            // tell the world
                            $rootScope.$broadcast('stack-selected', {stack_id: stack_id});
                        }
                }]
            };
    }]);
})();