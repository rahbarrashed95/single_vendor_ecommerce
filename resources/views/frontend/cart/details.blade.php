@php $cart = session()->get('cart', []); @endphp
<aside class="card">
  <article class="card-body">
    <header class="mb-4">
      <h4 class="card-title" style="font-size: 16px;"> Details </h4>
    </header>
    <div class="row">
      <div class="table-responsive bg-white">
        <table class="table border-bottom">
          <thead>
            <tr>
              <th class="product-image">Image</th>
              <th class="product-name">Product</th>
              <th class="product-price">Price</th>
              <th class="product-quanity">Quantity</th>
              <th class="product-total">Total</th>
            </tr>
          </thead>
          <tbody>
            @php
            $total=0;
            $discount=0;
            @endphp
            @foreach($cart as $key=>$item)
            @php
            $price=$item['price']*$item['quantity'];
            $total +=$price;
            $discount +=$item['discount']*$item['quantity'];
            @endphp
            <tr class="cart-item">
              <td class="product-image" style="display: flex; flex-direction: row-reverse;">
                <a href="{{ route('front.products.show', [$item['product_id'] ]) }}" >
                  <img class="lazyload" src="{{ getImage('products', $item['image']) }}" style="max-width: 50px">
                </a>
                <a data-href="{{ route('front.carts.destroy',[$key])}}" class="btn btn-danger remove_item" type="button"><i class="fa fa-trash"></i></a> 
              </td>

              <td class="product-name">
                <span class="d-block">{{ $item['name']}}</span>
              </td>

              <td class="product-price">
                <span class="d-block">{{ priceFormate($item['price'])}}</span>
              </td>

              <td class="product-quantity" data-title="Qty">
                <div class="pro-qty" data-segment="{{ request()->segment(1)}}" data-href="{{ route('front.carts.edit',[$key])}}">
                  <span class="dec qtybtn">-</span>
                  <input type="number" class="quantity-input" value="{{ $item['quantity'] }}">
                  <span class="inc qtybtn">+</span>
                </div>
              </td>
              <td class="product-total">
                <span>{{ priceFormate($price) }}</span>
              </td>

            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </article>

  <article class="card-body border-top total_section">
    <div class="row">
      <div class="col-md-6 col-6"><p class="h6 text-dark">Subtotal:</p></div>
      <div class="col-md-6 col-6"><p class="h6 text-dark">{{ priceFormate($total)}}</p></div>
      <div class="col-md-6 col-6"><p class="h6 text-dark">Delivery charge: </p></div>
      <div class="col-md-6 col-6"><p class="h6 text-danger delivery_charge">৳0</p></div>
      <div class="col-md-6 col-6"><p class="h6 text-dark">Total:</p></div>
      <div class="col-md-6 col-6"><p class="h6 text-dark total">{{ priceFormate($total)}}</p></div>
      <input type="hidden" value="{{ $total }}" id="subtotal">
      <input type="hidden" value="{{ $total }}" name="amount" id="amount">
    </div>

  </article>

</aside>