{{-- <!DOCTYPE html>
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
    {{-- </div>
    <form method="post" action="{{route('product.update', ['product' => $product])}}">
@csrf
    {{-- <form method="post" action="{{route('product.update',['product' =>$product])}}"> --}}
        {{-- @csrf
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
</html> --}} 



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            font-size: 1.5rem;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        input[type="text"]:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        input[type="submit"] {
            background: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
        .error-messages {
            background: #ffe6e6;
            border: 1px solid #ff4d4d;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }
        .error-messages ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .error-messages li {
            color: #cc0000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>

        {{-- @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif --}}

        <form method="post" action="{{ route('product.update', ['product' => $product]) }}">
            @csrf
            @method('put')

            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter product name" value="{{ $product->name }}" required />
            </div>

            <div>
                <label for="quantity">Quantity:</label>
                <input type="text" id="quantity" name="quantity" placeholder="Enter quantity" value="{{ $product->quantity }}" required />
            </div>

            <div>
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" placeholder="Enter price" value="{{ $product->price }}" required />
            </div>

            <div>
                <label for="discription">Description:</label>
                <input type="text" id="discription" name="discription" placeholder="Enter description" value="{{ $product->discription }}" />
            </div>

            <input type="submit" value="Update Product" />
        </form>
    </div>
</body>
</html>
