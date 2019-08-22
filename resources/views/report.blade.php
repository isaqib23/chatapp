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
            .container .img{
                text-align:center;
            }
            .container .details{
                border-left:3px solid #ded4da;
            }
            .container .details p{
                font-size:15px;
                font-weight:bold;
            }
        </style>
    </head>
    <body>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!------ Include the above in your HEAD tag ---------->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 img">
                <img src="{{$account->getProfilePicUrl()}}"  alt="" class="img-rounded">
                <blockquote>
                    <h5>{{$account->getFullName()}}</h5>
                    <small><cite title="Source Title">{{$account->getBiography()}}</cite></small>
                </blockquote>
                <ul>
                    <li><strong>Account ID: </strong>{{$account->getId()}}</li>
                    <li><strong>External link: </strong>{{$account->getExternalUrl()}}</li>
                    <li><strong>Published Posts: </strong>{{$account->getMediaCount()}}</li>
                    <li><strong>Followers: </strong>{{$account->getFollowsCount()}}</li>
                    <li><strong>Follows: </strong>{{$account->getFollowedByCount()}}</li>
                    <li><strong>Is private: </strong>{{($account->isPrivate()) ? 'Yes' : 'No'}}</li>
                    <li><strong>Is verified: </strong>{{($account->isVerified()) ? 'Yes' : 'No'}}</li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong> {{$account->getUsername()}}'s Followers</strong>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            @if($media_response != Null)
                                    @foreach($media_response as $key => $value)
                                        <div class="col-sm-4 sm-margin-b-50">
                                            <div class="margin-b-20">
                                                <img class="img-responsive" src="{{$value->getImageHighResolutionUrl()}}" style="width: 100%" alt="Latest Products Image">
                                            </div>
                                            <h4>{{$value->getCaption()}}</h4>
                                            <div class="bottom-wrap">
                                                <a href="" class="btn btn-sm btn-primary float-right">Comments: {{$value->getCommentsCount()}}</a>
                                                <div class="price-wrap h5">
                                                    <span class="price-new">Likes: {{$value->getLikesCount()}}</span>
                                                </div> <!-- price-wrap.// -->
                                            </div>
                                            <a class="link" href="{{$value->getLink()}}" target="_blank">Read More</a>
                                        </div>
                                @endforeach
                            @else
                            <p>No Media Found against this Account</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>
