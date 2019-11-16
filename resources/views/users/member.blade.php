@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-top: 50px">

        <!-- begin::page header -->
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <h4>Users</h4>
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
                        <th>User Image</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Participated Group</th>
                        <th>Registered Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($users)
                        @foreach($users as $key => $value)
                            <tr>
                                <td><img src="assets/media/image/light-logo.png" class="tbl-img" /></td>
                                <td>{{$value->first_name.' '.$value->last_name}}</td>
                                <td>{{$value->email}}</td>
                                @if($value->group != null)
                                    <td>{{$value->group->group->name}}</td>
                                @else
                                    <td>-</td>
                                @endif
                                <td>{{date('Y/m/d',strtotime($value->created_at))}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>User Image</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Participated Group</th>
                        <th>Registered Date</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
@endsection
