<!DOCTYPE html>
<html ng-app="app">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Stubb</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href='//fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
        <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

        <!-- Css -->
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="src/app.css" rel="stylesheet" type="text/css">

        <!-- Js -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.3/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.3/angular-route.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.3/angular-animate.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.3/angular-sanitize.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.3/angular-resource.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.3/angular-cookies.min.js"></script>
        <script src="src/node_modules/marked/lib/marked.js"></script>
        <script src="src/node_modules/angular-marked/dist/angular-marked.js"></script>
        <script src="src/node_modules/angular-modal-service/dst/angular-modal-service.min.js"></script>
        <script src="src/node_modules/angular-translate/dist/angular-translate.min.js"></script>
        <script src="src/node_modules/angular-translate/dist/angular-translate-loader-static-files/angular-translate-loader-static-files.min.js"></script>
        <script src="src/node_modules/angular-translate/dist/angular-translate-storage-cookie/angular-translate-storage-cookie.min.js"></script>
        <script src="src/app.js"></script>
      
        <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token()
        ]) !!};
    </script>
    </head>
    <body>
        <div class="container" ng-controller="LayoutController">

            <header class="margin-bottom-lg clearfix" ng-controller="HeaderController"> 

                <div class="col-md-8 text-left">
                    <h1 class="col-md-12"><img src="img/logo.png" alt="logo" /> Stubb.</h1>
                    <div class="col-md-1"></div><div class="col-md-11" translate="translations.home.header.subtitle"></div>
                </div>
                
                <div class="col-md-4 text-right profile-area">

                    <div class="navbar navbar-default pull-right" role="navigation">
                        <ul class="nav navbar-nav">
                            <li>
                                <session-dropdown data='{{ Auth::user() }}'></session-dropdown>                                
                            </li>
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="glyphicon glyphicon-cog"></span>
                                </a>
                            </li>                                
                        </ul>
                    </div>
                </div>
            </header>

            <div class="content row" ng-view></div>

            <footer></footer>
        </div>
    </body>
</html>


