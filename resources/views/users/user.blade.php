@extends('layouts.index')

@section('main')
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        <div class="row">    
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data User</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example5" class="table display table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">User ID</th>
                                        <th style="text-align:center">Name</th>
                                        <th style="text-align:center">Phone</th>
                                        <th style="text-align:center">Level</th>
                                        <th style="text-align:center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user as $us)
                                    <tr>
                                        <td style="text-align:center">{{$us->id}}</td>
                                        <td style="text-align:center">{{$us->nama}}</td>
                                        <td style="text-align:center">{{$us->phone}} <br><small>{{$us->email}}</small></td>
                                        <td style="text-align:center">{{$us->role->name}}</td>
                                        <td style="text-align:center">
                                            <a href="{{url('profile/edit?id='.$us->id)}}" class="btn btn-xs btn-info btn-rounded m-1"><i class="fa fa-list"></i>&nbsp; Edit</a>
                                            <a href="{{url('user/delete/'.$us->id)}}" class="btn btn-xs btn-danger btn-rounded m-1"><i class="fa fa-trash">&nbsp;</i>Delete</a>
                                        </td>												
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection