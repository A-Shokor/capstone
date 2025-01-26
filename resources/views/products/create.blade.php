<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>    Create Product </h1>
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
    <form method="post" action="{{route('product.store')}}">
        @csrf
        @method('post')

    <div>
        <label>Name:</label>
        <input type="text" name="name" placeholder="Name" />
    </div>
    <div>
        <label>Quantity:</label>
        <input type="text" name="quantity" placeholder="Quantity" />
    </div>
    <div>
        <label>price:</label>
        <input type="text" name="price" placeholder="Price" />
    </div>
    <div>
        <label>Discription:</label>
        <input type="text" name="discription" placeholder="Disription" />
    </div>
    <input type="submit" value="Save a New Product" />

    </form>
</body>
</html>