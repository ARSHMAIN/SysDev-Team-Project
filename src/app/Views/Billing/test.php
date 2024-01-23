<html>

<head>
    <style>
        .page
        {
            margin-top: 50px;
            margin-left: 200px;
            max-height: 100px;
        }

        .column {
            margin-right: 10px;
            float: left;
            border: 2px solid yellow;
        }

        .left
        {
            height: 1000px;
            width: 1000px;
        }

        .right
        {
            height: 1000px;
            width: 500px;
        }

        .column:left {
            float: left;
            margin-right: 20px;
            
        }

        .gap
        {
            width: 20px;
            
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="left column" style="background-color:lightgrey;">

        </div>
        <div class="gap column"></div>
        <div class="right column" style="background-color:grey;">

        </div>
    </div>
</body>

</html>