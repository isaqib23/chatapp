@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-top: 50px">

        <!-- begin::page header -->
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <h4>Payments</h4>
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
                        <th>User Name</th>
                        <th>Group Name</th>
                        <th>Group Fee</th>
                        <th>Admin Share</th>
                        <th>Owner Share</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($payments)
                        @foreach($payments as $key => $value)
                            <tr>
                                <td>{{$value->user->first_name.' '.$value->user->last_name}}</td>
                                <td>{{$value->group->name}}</td>
                                <td>{{$value->group->price}}</td>
                                <td>{{$value->group->price*0.1}}</td>
                                <td>{{($value->group->price) - ($value->group->price*0.1)}}</td>
                                <td>{{date('Y/m/d',strtotime($value->created_at))}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>User Name</th>
                        <th>Group Name</th>
                        <th>Group Fee</th>
                        <th>Admin Share</th>
                        <th>Owner Share</th>
                        <th>Date</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
@endsection
