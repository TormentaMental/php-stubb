<!DOCTYPE html>
<html ng-app="app">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Stubb</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
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
        <script src="src/app.js"></script>
    </head>
    <body>
        <div class="container">

            <header class="text-left margin-bottom-lg clearfix">
                <h1> <img src="img/logo.png" alt="logo" /> Stubb.</h1>
                <div class="col-md-1"></div><div class="col-md-11">Simply hash your notes and navigate them</div>
            </header>

            <div class="content row" ng-view></div>

            <footer>

            </footer>
        </div>
    </body>
</html>


