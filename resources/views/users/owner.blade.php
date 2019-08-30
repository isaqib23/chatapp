@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-top: 50px">

        <!-- begin::page header -->
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <h4>Groups Owners</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Back</a></li>

                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="card">
            <div class="card-body">
                <table id="example2" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Owner Image</th>
                        <th>Owner Name</th>
                        <th>Owner Email</th>
                        <th>Group Name</th>
                        <th>Group Price</th>
                        <th>Group Users</th>
                        <th>Created Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($users)
                        @foreach($users as $key => $value)
                            <tr>
                                <td><img src="assets/media/image/light-logo.png" class="tbl-img" /></td>
                                <td>{{$value->user->first_name.' '.$value->user->last_name}}</td>
                                <td>{{$value->user->email}}</td>
                                <td>{{$value->name}}</td>
                                <td>${{$value->price}}</td>
                                <td>{{$value->members->count()}}</td>
                                <td>{{date('Y/m/d',strtotime($value->created_at))}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Owner Image</th>
                        <th>Owner Name</th>
                        <th>Owner Email</th>
                        <th>Group Name</th>
                        <th>Group Price</th>
                        <th>Group Users</th>
                        <th>Created Date</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
@endsection
