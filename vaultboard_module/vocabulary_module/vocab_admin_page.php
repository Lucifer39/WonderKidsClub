<?php
    $dir = __DIR__;
    require_once($dir . "/functions/admin_script.php");

    if(isset($_GET["universe"])){
        routeQuestions($_GET["universe"]);
    }
?>

<head>
    <title>Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            height: 100vh;
            width: 100vw;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 50%;
            /* height: 50%; */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #4caf50;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Form Questions</h1>
        <form method="get">
            <label for="universe">Choose an option:</label>
            <select name="universe" id="choice">
                <option value="words">Words</option>
                <option value="idioms">Idioms</option>
                <option value="simile">Simile</option>
                <option value="hyperbole">Hyperbole</option>
                <option value="metaphor">Metaphor</option>
            </select>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
