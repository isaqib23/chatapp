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
            img {
                max-width: 100%; }

            .preview {
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -webkit-flex-direction: column;
                -ms-flex-direction: column;
                flex-direction: column; }
            @media screen and (max-width: 996px) {
                .preview {
                    margin-bottom: 20px; } }

            .preview-pic {
                -webkit-box-flex: 1;
                -webkit-flex-grow: 1;
                -ms-flex-positive: 1;
                flex-grow: 1; }

            .preview-thumbnail.nav-tabs {
                border: none;
                margin-top: 15px; }
            .preview-thumbnail.nav-tabs li {
                width: 18%;
                margin-right: 2.5%; }
            .preview-thumbnail.nav-tabs li img {
                max-width: 100%;
                display: block; }
            .preview-thumbnail.nav-tabs li a {
                padding: 0;
                margin: 0; }
            .preview-thumbnail.nav-tabs li:last-of-type {
                margin-right: 0; }

            .tab-content {
                overflow: hidden; }
            .tab-content img {
                width: 100%;
                -webkit-animation-name: opacity;
                animation-name: opacity;
                -webkit-animation-duration: .3s;
                animation-duration: .3s; }

            .card {
                margin-top: 50px;
                background: #eee;
                padding: 3em;
                line-height: 1.5em; }

            @media screen and (min-width: 997px) {
                .wrapper {
                    display: -webkit-box;
                    display: -webkit-flex;
                    display: -ms-flexbox;
                    display: flex; } }

            .details {
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -webkit-flex-direction: column;
                -ms-flex-direction: column;
                flex-direction: column; }

            .colors {
                -webkit-box-flex: 1;
                -webkit-flex-grow: 1;
                -ms-flex-positive: 1;
                flex-grow: 1; }

            .product-title, .price, .sizes, .colors {
                text-transform: UPPERCASE;
                font-weight: bold; }

            .checked, .price span {
                color: #ff9f1a; }

            .product-title, .rating, .product-description, .price, .vote, .sizes {
                margin-bottom: 15px; }

            .product-title {
                margin-top: 0; }

            .size {
                margin-right: 10px; }
            .size:first-of-type {
                margin-left: 40px; }

            .color {
                display: inline-block;
                vertical-align: middle;
                margin-right: 10px;
                height: 2em;
                width: 2em;
                border-radius: 2px; }
            .color:first-of-type {
                margin-left: 20px; }

            .add-to-cart, .like {
                background: #ff9f1a;
                padding: 1.2em 1.5em;
                border: none;
                text-transform: UPPERCASE;
                font-weight: bold;
                color: #fff;
                -webkit-transition: background .3s ease;
                transition: background .3s ease; }
            .add-to-cart:hover, .like:hover {
                background: #b36800;
                color: #fff; }

            .not-available {
                text-align: center;
                line-height: 2em; }
            .not-available:before {
                font-family: fontawesome;
                content: "\f00d";
                color: #fff; }

            .orange {
                background: #ff9f1a; }

            .green {
                background: #85ad00; }

            .blue {
                background: #0076ad; }

            .tooltip-inner {
                padding: 1.3em; }

            @-webkit-keyframes opacity {
                0% {
                    opacity: 0;
                    -webkit-transform: scale(3);
                    transform: scale(3); }
                100% {
                    opacity: 1;
                    -webkit-transform: scale(1);
                    transform: scale(1); } }

            @keyframes opacity {
                0% {
                    opacity: 0;
                    -webkit-transform: scale(3);
                    transform: scale(3); }
                100% {
                    opacity: 1;
                    -webkit-transform: scale(1);
                    transform: scale(1); } }

            /*# sourceMappingURL=style.css.map */
        </style>
    </head>
    <body>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!------ Include the above in your HEAD tag ---------->

    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <div class="card">
                    <div class="container-fliud">
                        <div class="wrapper row">
                            <div class="preview col-md-6">
                            @if(isset($results->player))
                                {!! $results->player->embedHtml !!}
                            @else
                                <div class="preview-pic tab-content">
                                    <div class="tab-pane active" id="pic-1"><img src="@if($results->snippet->thumbnails->medium){{$results->snippet->thumbnails->medium->url}}@else{{$results->snippet->thumbnails->default->url}}@endif" /></div>
                                </div>
                                <ul class="preview-thumbnail nav nav-tabs">
                                    <li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="@if($results->snippet->thumbnails->medium){{$results->snippet->thumbnails->medium->url}}@else{{$results->snippet->thumbnails->default->url}}@endif" /></a></li>
                                </ul>
                            @endif
                            </div>
                            <div class="details col-md-6">
                                <h3 class="product-title">{{$results->snippet->title}}</h3>
                                <div class="rating">
                                    <span class="review-no">Published at: {{$results->snippet->publishedAt}}</span>
                                </div>
                                <h4 class="price">Channel: <span>{{ucwords($results->snippet->channelTitle)}}</span></h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Statistics</h4>
                                        <table class="table table-hover group table-striped">
                                            <tr>
                                                <td>View Count</td>
                                                <td>{{$results->statistics->viewCount}}</td>
                                            </tr>
                                            <tr>
                                                <td>Like Count</td>
                                                <td>{{$results->statistics->likeCount}}</td>
                                            </tr>
                                            <tr>
                                                <td>Dislike Count</td>
                                                <td>{{$results->statistics->dislikeCount}}</td>
                                            </tr>
                                            <tr>
                                                <td>Favorite Count</td>
                                                <td>{{$results->statistics->favoriteCount}}</td>
                                            </tr>
                                            <tr>
                                                <td>Comment Count</td>
                                                <td>{{$results->statistics->commentCount}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Status</h4>
                                        <table class="table table-hover group table-striped">
                                            <tr>
                                                <td>Upload Status</td>
                                                <td>{{$results->status->uploadStatus}}</td>
                                            </tr>
                                            <tr>
                                                <td>Privacy Status</td>
                                                <td>{{$results->status->privacyStatus}}</td>
                                            </tr>
                                            <tr>
                                                <td>License</td>
                                                <td>{{$results->status->license}}</td>
                                            </tr>
                                            <tr>
                                                <td>Embeddable</td>
                                                <td>@if($results->status->embeddable) Yes @else No @endif</td>
                                            </tr>
                                            <tr>
                                                <td>Viewable</td>
                                                <td>@if($results->status->publicStatsViewable) Yes @else No @endif</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                @if(isset($results->snippet->tags))
                                <div class="row">
                                    <h4>Tags</h4>
                                    <p>
                                        @foreach($results->snippet->tags as $tag_key => $tag_value)
                                            <span class="badge badge-info">{{$tag_value}}</span>
                                        @endforeach
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <p>
                                {!! $results->snippet->description !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </body>
</html>

