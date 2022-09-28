<?php
$current_page = 'Stock';
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
                        <h4 class="card-title">Stock Update</h4>
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
                        <form method="POST" action="{{ url('stockUpdate/' . $stock->id) }}">
                            @csrf

                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <label class="col-form-label"> Product Name <span style="color: red;">*</span></label>
                                </div>
                                <div class="col-lg-8">
                                    <select class="form-control2" name="productname" >

                                        <option selected value="{{ $stock->prodctid }}" style="color: white;">
                                            {{ $stock->productname }}</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <label class="col-form-label"> Product Quantity <span style="color: red;">*</span></label>
                                </div>
                                <div class="col-lg-8">
                                    <input class="form-control" name="quantity" type="number"min="1"
                                        value="{{ $stock->stock_count }}" placeholder="Enter Quantity.">
                                </div>
                            </div>




                            <center>
                                <button type="submit"style="background-color:black;border-radius:10px;"
                                    class="btn btn-primary">Update</button>
                               
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
