{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Product</h1>
        
@if (session()->has ('success'))
<div>

    {{session('success')}}
</div>
    
@endif

        


    <div> 
     <table border="1">   
        
    <tr>
        <th> ID </th>
        <th> Name</th>

        <th> Quantity</th>

        <th> Price </th>

        <th> Discreption </th>
        <th> Edit</th>
        <th>delete</th>

    </tr>       
    @foreach ($products as $product )
        
    <tr>
       <td> {{$product->id}}</td>       
       <td> {{$product->name}}</td>     
       <td> {{$product->quantity}}</td>    
       <td> {{$product->price}}</td>     
       <td> {{$product->discription}}</td>   


       <td>
        <a   href="{{route('product.edit',['product' => $product])}}">Edit</a>
    </td>  

    <td>
        <form method="post" action="{{ route('product.destroy', ['product' => $product]) }}">

        {{-- <form action="post" action="{{route('product.destroy',['product'=>$product])}}"> --}}
        {{-- @csrf
        @method('delete')
        <input type="submit" value="Delete" />
        
        </form>
    
    
    </td>


    </tr >
    @endforeach
    
    </table>   
    
    
    </div>
    <div>
        <a href="{{route('product.create')}}">create a product</a>
    </div>
</body> --}}
{{-- </html> --}} 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            text-align: left;
            padding: 12px;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #f4f4f4;
            color: #555;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .button {
            display: inline-block;
            padding: 8px 15px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .button.delete {
            background-color: #dc3545;
        }
        .button.delete:hover {
            background-color: #b21f2d;
        }
        .no-products {
            text-align: center;
            color: #555;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Products</h1>
    
    <div class="container">
        <!-- Success Message -->
        @if (session()->has('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
        @endif

        <!-- Product Table or No Products Found -->
        @if ($products->isEmpty())
            <p class="no-products">No products found. <a href="{{ route('product.create') }}" class="button">Create a Product</a></p>
        @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->discription }}</td>
                    <td>
                        <a href="{{ route('product.edit', ['product' => $product]) }}" class="button">Edit</a>
                    </td>
                    <td>
                        <form method="post" action="{{ route('product.destroy', ['product' => $product]) }}" style="display: inline;">
                            @csrf
                            @method('delete')
                            <input type="submit" value="Delete" class="button delete" onclick="return confirm('Are you sure you want to delete this product?');" />
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div>
            {{ $products->links() }}
        </div>
        @endif

        <!-- Create Product Button -->
        <div style="text-align: center;">
            <a href="{{ route('product.create') }}" class="button">Create a Product</a>
        </div>
    </div>
</body>
</html>
