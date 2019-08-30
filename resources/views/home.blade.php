@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-top: 50px">

        <!-- begin::page header -->
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <div>
                <h4>Dashboard</h4>
            </div>
            <div>
                <div class="reportrange btn btn-light">
                    <i class="ti-calendar m-r-10"></i>
                    <span></span>
                    <i class="ti-angle-down m-l-10"></i>
                </div>
            </div>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Total Users</div>
                    <div class="card-body text-center">
                        <h2 class="text-danger font-weight-bold">700+</h2>
                        <p class="m-b-0">
                            <i class="fa fa-caret-up text-primary m-r-5"></i> 23% increase in Last week
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Total Groups</div>
                    <div class="card-body text-center">
                        <h2 class="text-danger font-weight-bold">700+</h2>
                        <p class="m-b-0">
                            <i class="fa fa-caret-up text-primary m-r-5"></i> 23% increase in Last week
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Total Admins</div>
                    <div class="card-body text-center">
                        <h2 class="text-danger font-weight-bold">700+</h2>
                        <p class="m-b-0">
                            <i class="fa fa-caret-up text-primary m-r-5"></i> 23% increase in Last week
                        </p>
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
                                <h5 class="card-title">Group Joining Report</h5>
                                <h6 class="card-subtitle">Sales graph of last 7 months</h6>
                            </div>
                            <div class="reportrange btn btn-sm btn-light">
                                <i class="ti-calendar m-r-10"></i>
                                <span></span>
                                <i class="ti-angle-down m-l-10"></i>
                            </div>
                            <div class="d-lg-none d-sm-block m-t-15"></div>
                        </div>
                        <div class="row m-b-20">
                            <div class="col-md-6">
                                <div class="bg-light text-success p-15 text-center m-b-10">
                                    <h4 class="font-weight-bold">$560.234,076</h4>
                                    <h6 class="m-b-0">Total Paid</h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light text-warning p-15 text-center m-b-10">
                                    <h4 class="font-weight-bold">$620,076</h4>
                                    <h6 class="m-b-0">Our Profit</h6>
                                </div>
                            </div>
                        </div>
                        <canvas id="chartjs_one"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
