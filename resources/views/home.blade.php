@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-top: 50px">

        <!-- begin::page header -->
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <div>
                <h4>Dashboard</h4>
            </div>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Total Users</div>
                    <div class="card-body text-center">
                        <h2 class="text-danger font-weight-bold">{{$users->count()}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Total Groups</div>
                    <div class="card-body text-center">
                        <h2 class="text-danger font-weight-bold">{{$groups->count()}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Total Admins</div>
                    <div class="card-body text-center">
                        <h2 class="text-danger font-weight-bold">{{$owner->count()}}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-md-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title">Group Report</h5>
                            </div>
                            <div class="d-lg-none d-sm-block m-t-15"></div>
                        </div>
                        <div class="row m-b-20">
                            <div class="col-md-6">
                                <div class="bg-light text-success p-15 text-center m-b-10">
                                    <h4 class="font-weight-bold">${{$total-$profit}}</h4>
                                    <h6 class="m-b-0">Total Groups Payment</h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light text-warning p-15 text-center m-b-10">
                                    <h4 class="font-weight-bold">${{$profit}}</h4>
                                    <h6 class="m-b-0">Our Profit</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
