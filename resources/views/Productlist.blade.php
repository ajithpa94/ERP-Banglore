<?php
$current_page = 'Product';
?>
@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.3.4/css/searchBuilder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">
    <style>
        .dataTables_info,
        .dt-button,
        #example_previous,
        #example_next {
            color: black !important;
        }
        .dataTables_info{
            margin-top: 1.8% !important;
        }
        #example_paginate>span>a {
            color: black !important;
        }

        .dataTables_filter>label {
            color: black !important
        }
    </style>
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Product List</h4>
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="col-md-2">
                            @if (Auth::user()->usertype == 1)
                                <form action="" method="GET">
                                    <select class="form-control2" name="user" onchange="this.form.submit()">
                                        <option value="">All</option>
                                        @foreach ($users as $item)
                                            <option @if ($userId == $item->id) selected @endif
                                                value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            @endif
                        </div>
                        <div class="table-responsive pt-3">
                            <table id="example" class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th> #</th>
                                        @if (Auth::user()->usertype == 1)
                                            <th> Branch </th>
                                        @endif
                                        <th> Category </th>
                                        <th> Product name</th>
                                        {{-- <th> Product Item Code</th>
                                        <th> Cost Price</th>
                                        <th>Sales Price</th> --}}
                                        {{-- <th> Quantity </th> --}}

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cnt = 1;
                                    @endphp
                                    @foreach ($product as $products)
                                        <tr>
                                            <td>{{ $cnt++ }}</td>
                                            @if (Auth::user()->usertype == 1)
                                                <td>{{ $products->name }}</td>
                                            @endif
                                            <td>{{ $products->categoryname }}</td>
                                            <td>{{ $products->productname }}</td>
                                            {{-- <td>{{ $products->productitemcode }}</td>
                                            <td>{{ $products->costprice }}</td>
                                            <td>{{ $products->salesprice }}</td> --}}
                                            {{-- <td>{{ $products->quantity }}</td> --}}
                                            <td>
                                                <h3 style="display: flex;">
                                                    {{-- class="btn btn-primary" --}}
                                                    <a href="{{ url('Productedit', $products->id) }}"
                                                        style="margin-left:3%;margin-right:3%;border:none;color:green;"><i
                                                            class="fas fa-edit"></i></a>
                                                    <form action="{{ url('destroys', $products->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button style="border:none; color: red;background-color: Transparent;
                                                        background-repeat:no-repeat;"type="submit"
                                                            onclick="return confirm('Are you sure?')"
                                                            style="border:none;"><i class="fas fa-trash"></i></button>
                                                        {{-- class="btn btn-danger" --}}
                                                    </form>
                                                </h3>

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
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.3.4/js/dataTables.searchBuilder.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i style="color:green" class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel',
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i style="color:red" class="fa fa-file-pdf-o"></i>',
                        titleAttr: 'PDF'
                    }
                ]
            });
        });
    </script>
@endsection
