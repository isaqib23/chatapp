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
            .container-fluid{
                padding:5%;
            }
            /*Profile Card 5*/
            .profile-card-5{
                margin-top:20px;
            }
            .profile-card-5 .btn{
                border-radius:2px;
                text-transform:uppercase;
                font-size:12px;
                padding:7px 20px;
            }
            .profile-card-5 .card-img-block {
                width: 91%;
                margin: 0 auto;
                position: relative;
                top: -20px;

            }
            .profile-card-5 .card-img-block img{
                border-radius:5px;
                box-shadow:0 0 10px rgba(0,0,0,0.63);
            }
            .profile-card-5 h5{
                color:#4E5E30;
                font-weight:600;
            }
            .profile-card-5 p{
                font-size:14px;
                font-weight:300;
            }
            .profile-card-5 .btn-primary{
                background-color:#4E5E30;
                border-color:#4E5E30;
            }
        </style>
    </head>
    <body>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!------ Include the above in your HEAD tag ---------->

    <div class="container-fluid">
        <h1 class="text-center">Search Results</h1>
        <div class="row">

            @if($results != Null)
                @foreach($results as $key => $value)
                    <div class="col-md-3 mt-3">
                        <div class="card profile-card-5">
                            <div class="card-img-block">
                                <img class="card-img-top" src="@if($value->snippet->thumbnails->medium){{$value->snippet->thumbnails->medium->url}}@else{{$value->snippet->thumbnails->default->url}}@endif" alt="Card image cap">
                            </div>
                            <div class="card-body pt-0">
                                <h5 class="card-title">{{$value->snippet->title}}</h5>
                                <p>
                                    <span class="badge badge-warning" style="float: right">{{ucfirst($value->snippet->channelTitle)}}</span>
                                </p>
                                <p class="card-text">{{$value->snippet->description}}</p>
                                <a href="{{url('/get_details?type=video&id=').$value->contentDetails->upload->videoId}}" class="btn btn-primary">Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="alert alert-danger">No Results Found</p>
            @endif

        </div>
    </div>
    </body>
</html>
