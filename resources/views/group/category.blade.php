@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-top: 50px">

        <!-- begin::page header -->
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <h4>Categories</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Back</a></li>

                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target=".bs-example-modal-sm" style="margin-bottom: 15px">Add New</button>
                <table id="example2" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Category ID</th>
                        <th>Category Title</th>
                        <th>Created Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($categories)
                        @foreach($categories as $key => $value)
                            <tr>
                                <td>{{$value->id}}</td>
                                <td>{{$value->title}}</td>
                                <td>{{date('Y/m/d',strtotime($value->created_at))}}</td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <p>No Records Founds</p>
                    </tr>
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Category ID</th>
                        <th>Category Title</th>
                        <th>Created Date</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>


        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <form method="post" action="{{ route('categories') }}">
                        @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Category Title:</label>
                            <input type="text" class="form-control" id="recipient-name" name="title">
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </form>
            </div>
        </div>

    </div>
@endsection
