<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>    Edit Product </h1>
    <div>

        {{-- @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error  )
                <li>
                    {{$error}}
                </li>
            @endforeach
        </ul> --}}
    </div>
    <form method="post" action="{{route('product.update', ['product' => $product])}}">
@csrf
    {{-- <form method="post" action="{{route('product.update',['product' =>$product])}}"> --}}
        @csrf
        @method('put')

    <div>
        <label>Name:</label>
        <input type="text" name="name" placeholder="Name" value="{{$product->name}}"/>
    </div>
    <div>
        <label>Quantity:</label>
        <input type="text" name="quantity" placeholder="Quantity"value="{{$product->quantity}}"/>
    </div>
    <div>
        <label>price:</label>
        <input type="text" name="price" placeholder="Price" value="{{$product->price}}" />
    </div>
    <div>
        <label>Discription:</label>
        <input type="text" name="discription" placeholder="Disription" value="{{$product->discription}}"/>
    </div>
    <input type="submit" value="   Update" />

    </form>
</body>
</html>