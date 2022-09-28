<?php
$current_page = 'Product';
?>
@extends('layouts.app')
<?php
$title = 'Add User | Mr:Rocks';
?>
@section('content')
    <div class="content-wrapper">
        <div class="row grid-margin">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Quantity Type Add</h4>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ url('QuantitytypeStore') }}">
                            @csrf
                            @if (Auth::user()->usertype == 1)
                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <label class="col-form-label">Select Branch
                                            <span style="color: red;">*</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <select class="form-control2" required name="user">
                                            <option value="">Select Branch</option>
                                            @foreach ($users as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            
                            
                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <label class="col-form-label">  Quantity Types <span
                                            style="color: red;">*</span></label>
                                </div>
                                <div class="col-lg-8">
                                    <input class="form-control" name="quantityTypes" type="number"min="1"
                                        placeholder=" Quantity Types">
                                </div>
                            </div>
                           
                            <center><button type="submit"style="background-color:black;border-radius:10px;"
                                    class="btn btn-primary">Add</button>
                                <button type="reset"
                                    style="background-color:black;border-radius:10px;"value="Reset"class="btn btn-primary">Clear</button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
