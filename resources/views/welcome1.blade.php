<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
        </style>
    </head>
    <body>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!------ Include the above in your HEAD tag ---------->

    <div class="container">
        <h1>Instagram Statistics</h1>
        <br><br>
    <div class="row">
        <div class="col-md-6">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">With Username</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="{{url('/report')}}">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Instagram Username" name="username" type="text" autofocus="">
                            </div>
                            <button type="submit" class="btn btn-sm btn-success">Login</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">With Username & Password</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="{{url('/report')}}">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Instagram Username" name="username" type="text" autofocus="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <button type="submit" class="btn btn-sm btn-success">Login</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </body>
</html>
