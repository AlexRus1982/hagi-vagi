<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Test page</title>
    </head>
    <body>
        Test page
        <?php
            for($i = 0; $i < 10; $i++){
            ?>
                <div id="id-{{$i}}">{{$i}}</div>
            <?
            }
        ?>
    </body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/js/test.js"></script>
</html>
