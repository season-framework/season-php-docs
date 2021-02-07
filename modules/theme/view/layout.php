<!DOCTYPE html>
<html ng-app="app">

<head>
    <?php $view->load("head"); ?>
</head>

<body class="antialiased">
    <?php $view->load("nav"); ?>

    <div class="page">
        <div class="content p-0" id="content-wrapper" ng-controller="content" ng-cloak>
            <?php $view->load("content"); ?>
            <?php $view->load("footer"); ?>
        </div>
    </div>

    <script>
        try {
            app.controller('content', content_controller);
        } catch (e) {
            app.controller('content', function() {});
        }
    </script>
</body>

</html>