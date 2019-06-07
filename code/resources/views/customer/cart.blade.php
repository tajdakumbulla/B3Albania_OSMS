@extends('layouts.app')

@section('content')
<div class="container">
    @isset($msg)
        <blockquote>
            {{$msg}}
        </blockquote>
    @endisset
    <div class="card">
        <div class="card-content">
        <form method="post" id="cart_order" action="{{route('cart.order')}}">
            @csrf
            @foreach($products as $product)
                <input class="products" type="hidden" name="product_id[]" value="{{$product->id}}">
                <input id="stock_{{$product->id}}" type="hidden" value="{{$product->in_stock}}">
                <input id="title_{{$product->id}}" type="hidden" value="{{$product->title}}">
                <input id="price_{{$product->id}}" type="hidden" value="{{$product->price}}">
                <div id="product_div_{{$product->id}}" style="height: 40rem">
                    <div class="col s6">
                        <div id="images">
                            @isset($product->images)
                                <div class="slider">
                                    <ul id="product_images" class="slides">
                                        @foreach($product->images as $image)
                                            <li><img class="materialboxed" alt="" src="{{asset('/img/'.$image->url)}}"></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endisset
                        </div>
                        <div class="row">
                            <div class="col s7">
                                <h5>{{$product->title}}</h5>
                                <p>{{$product->description}}</p>
                            </div>
                            <div class="col s1">
                                <h5>{{$product->price}}<i class="tiny material-icons">euro_symbol</i></h5>
                            </div>
                            <div class="input-field col s3">
                                <input class="quantity" min="1" id="quantity_{{$product->id}}" value="1" name="quantity[]" type="number" class="validate">
                                <label class="active" for="first_name2">Quantity</label>
                            </div>
                            <a class="btn-floating btn-flat white waves-effect waves-red waves-circle">
                                <i product_id="{{$product->id}}" style="color: red;" class="remove_cart material-icons">delete</i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="row">
                <div class="input-field col s12">
                    <textarea name="note" id="textarea1" class="materialize-textarea"></textarea>
                    <label for="textarea1">Note</label>
                </div>
                <div class="col s6">
                    <h5 id="sum"></h5>
                </div>
                <div class="input-field col s6">
                    <button id="submit_order" class="btn waves-effect waves-light right" type="submit" name="action">Make Order
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
            <input type="hidden" id="verified" value="{{\Illuminate\Support\Facades\Auth::user()->verified}}">
        </form>
        </div>
    </div>
</div>


    <script>
        $(document).ready(function(){
            $('.slider').slider();
            $('.materialboxed').materialbox();
            $('#submit_order').addClass('disabled');
            calculate();

            $('.quantity').change(function () {
                calculate();
            });

            function calculate() {
                var sum = 0;
                $('.products').each( function () {
                    if($('#verified').val()==0){
                        M.toast({html: 'Please verify your e-mail'});
                        $('#submit_order').addClass('disabled');
                        return false;
                    }
                    var id = $(this).val();
                    var stock = parseInt($('#stock_'+id).val());
                    var quantity = parseInt($('#quantity_'+id).val());
                    if(quantity > stock || stock<=0){
                        var name = $('#title_'+id).val();
                        M.toast({html: 'Product ' + name + ' is out of stock. You can try to change quantity or remove item from cart!'});
                        $('#submit_order').addClass('disabled');
                        return false;
                    }
                    $('#submit_order').removeClass('disabled');
                    sum += quantity * parseFloat($('#price_'+id).val());
                    $('#sum').html('Total: '+sum + '<i class="material-icons tiny">euro_symbol</i>');
                });
            }

            $('.remove_cart').click(function () {
                var product_id = $(this).attr('product_id');
                $.ajax({
                    url: "/api/customer/{{\Illuminate\Support\Facades\Auth::user()->id}}/cart/remove/"+product_id,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(result, status, statusCode){
                        console.log(result);
                        if(statusCode.status==201){
                            M.toast({html: 'Item removed from cart'});
                            $('#product_div_'+product_id).remove();
                        }
                    },
                });
            });
        });

    </script>
@endsection
