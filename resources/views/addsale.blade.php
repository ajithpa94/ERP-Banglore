<?php
$current_page = 'Sale';
?>
<?php

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;
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
                        <h4 class="card-title">Sale Add</h4>
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
                        <form method="POST" action="{{ url('addsaleStore') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- <div class="col-sm-12 b-r"> --}}
                                <div class="col-md-5">
                                    @if (Auth::user()->usertype == 1)
                                        <div class="col-md-12">
                                            <label class="col-form-label">Select Branch<span
                                                    style="color: red;">*</span></label>
                                            <select class="form-control2" onchange="getproduct(this)" required
                                                name="user">
                                                <option value="">Select Branch</option>
                                                @foreach ($users as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="col-md-12 ">
                                        <label class="col-form-label">Date <span style="color: red;">*</span></label>
                                        <input class="form-control" required id="datepicker" name="date" type="date"
                                            value="<?php echo $today; ?>" placeholder="Enter date">
                                    </div>

                                    <div class="col-md-12 ">
                                        <label class="col-form-label">Invoice Number <span
                                                style="color: red;">*</span></label>
                                        <input class="form-control" required id="InvoiceNumber" name="number"
                                            max="1000"value="{{ $number }}" readonly type="text"
                                            placeholder="Enter Invoice Number">
                                    </div>

                                    <div class="col-md-12">
                                        <label class="col-form-label">Customer Name <span
                                                style="color: red;">*</span></label>
                                        <input class="form-control" required name="suppliername" type="text"
                                            value="{{ old('suppliername') }}" placeholder="Enter Customer Name">
                                    </div>
                                </div>
                                <div class="col-md-7" id="tb">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label class="col-form-label"> Product Name <span
                                                    style="color: red;">*</span></label>
                                            <select class="form-control2 prds" onchange="getStock(this)" required
                                                name="productName[]">
                                                <option value=""> Please Select</option>
                                                @foreach ($product as $Row)
                                                    <option value="{{ $Row->id }}">{{ $Row->productname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="col-form-label">Quantity <span
                                                    style="color: red;">*</span></label>
                                            <input class="form-control qty" name="quantities[]" min="1" required
                                                type="number" placeholder="Enter quantity">
                                        </div>
                                        <div class="col-md-2">

                                            <button
                                                id="btn"type="button"style="background-color:black;border-radius:10px;margin-top:38%"
                                                class="btn btn-primary">+</button>
                                        </div>
                                    </div>
                                    <div class="row" id="rr" hidden>
                                        <div class="col-md-5">
                                            <label class="col-form-label"> Product Name <span
                                                    style="color: red;">*</span></label>
                                            <select class="form-control2 prds" id="prds" onchange="getStock(this)"
                                                name="productName[]">
                                                <option value=""> Please Select</option>
                                                @foreach ($product as $Row)
                                                    <option value="{{ $Row->id }}">{{ $Row->productname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="col-form-label">Quantity <span
                                                    style="color: red;">*</span></label>
                                            <input class="form-control qty" name="quantities[]" min="1"type="number"
                                                placeholder="Enter quantity">
                                        </div>
                                        <div class="col-md-2">

                                            <button onclick="remove(this)"
                                                type="button"style="background-color:black;border-radius:10px;margin-top:38%"
                                                class="btn btn-primary">-</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
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
@section('script')
    <script>
        $(document).ready(function() {
            $("#btn").click(function() {
                $(".prds option").each(function(i) {
                    if ($(this).is(':selected') && $(this).val() != '') {
                        $("#prds option[value='" + $(this).val() + "']").attr('disabled', true);
                    }
                });

                var row = $("#rr").clone().appendTo("#tb");
                row.removeAttr('hidden');
                row.find('select').attr('required', true);
                row.find('input').attr('required', true);
            });
            $('.remove').click(function() {
                console.log($(this))
                $(this).parent().remove();
            })

        });

        function getStock(e) {
            $.ajax({
                url: "stock_count/" + $(e).val(),
                success: function(result) {
                    $(e).parent().parent().find(".qty").attr({
                        "max": result,
                        "min": 0
                    });
                }
            });
        }

        function getproduct(e) {
            $.ajax({
                url: "getProduct/" + $(e).val(),
                success: function(result) {
                    var data = JSON.parse(result);
                    $('#InvoiceNumber').val(data.number)
                    $('.prds').empty();
                    $('.prds').append(data.product)
                }
            });
        }

        function remove(e) {
            $(e).parent().parent().remove();
            console.log(e);
        }
    </script>
    <script>
        $(function() {
            var dtToday = new Date();

            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();

            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;
            $('#datepicker').attr('max', maxDate);
        });
    </script>
@endsection
