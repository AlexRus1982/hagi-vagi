<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="cookie-uuid" content="{{ Config::get('cookie-uuid') }}">
        <title>Test page</title>
    </head>
    <body>
        Test page<br>
        <?php

            $cookieUuid = json_encode(Cookie::get());
            echo "cookie read = {$cookieUuid}<br>";

            // $propertyName = "Свойство: Материал";
            // $propertyArray = [];
            // $used = DB::table('catalog')
            // ->select("{$propertyName}")
            // ->where([
            //     [$propertyName, '<>', 'NULL'],
            //     [$propertyName, '<>', ''],
            // ])
            // ->get();

            // foreach ($used as $property) {
            //     $splitArray = explode(';', $property->{$propertyName});

            //     foreach ($splitArray as $splitProperty) {
            //         array_push($propertyArray, $splitProperty);
            //     }
            // }

            // $propertyCollection = collect($propertyArray);

            // $uniqCollection = $propertyCollection->countBy();
            // // $uniqCollection->dump();

        ?>
    </body>
    {{-- 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/js/test.js"></script>
    --}}
</html>
