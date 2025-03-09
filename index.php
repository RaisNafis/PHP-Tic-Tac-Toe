<?php
session_start();
if (!isset($_SESSION['box'])) {
    $_SESSION['box'] = array_fill(0, 9, "");
    $_SESSION['match'] = true; 
}
if (isset($_POST['restart'])) {
    $_SESSION['box'] = array_fill(0, 9, "");
    $_SESSION['match'] = true;
}
if ($_SESSION ['match'] === true && isset($_POST['click'])) {
    $click_id = $_POST['click'];
    if ($_SESSION['box'][$click_id] === "") {
        $_SESSION['box'][$click_id] = (count(array_filter($_SESSION['box'])) % 2 === 0) ? "X" : "O";
    }
}
$winningCombos = [
    [0, 1, 2], [3, 4, 5], [6, 7, 8], 
    [0, 3, 6], [1, 4, 7], [2, 5, 8], 
    [0, 4, 8], [2, 4, 6]  
];
$winner = null;
$tie = true;
foreach ($winningCombos as $combo) {
    if ($_SESSION['box'][$combo[0]] === $_SESSION['box'][$combo[1]] && $_SESSION['box'][$combo[1]] === $_SESSION['box'][$combo[2]] && $_SESSION['box'][$combo[0]] !== "") {
        $winner = $_SESSION['box'][$combo[0]]. " WIN!";
       $_SESSION ['match'] = false;
       $tie = false;
        break;
    }
}
if ($tie && !in_array("", $_SESSION['box'])) {
    $winner = "TIE";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }
        .container-box {
            display: grid;
            grid-template-columns: repeat(3, 100px);
            gap: 5px;
        }
        .box {
            height: 100px;
            width: 100px;
            border: 1px solid black;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            cursor: pointer;
        }
        .box:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }
        .wrapper{
        }
        .restart-btn{
            width: 100%;
            height: 35px;
            margin-top: 10px;
        }
        .alert{
            background-color: green;
            color: white;
            padding: 10px 10px;
        }
    </style>
</head>
<body>
    <div class="wrapper">

    <?php if ($winner): ?>
        <p class="alert"><?php echo $winner; ?></p>
        <h2></h2>
    <?php endif; ?>
    <div class="container-box">
        <?php for ($i = 0; $i < 9; ++$i): ?>
            <form method="POST" style="display: inline;">
                <input type="hidden" name="click" value="<?php echo $i; ?>">
                <button type="submit" class="box"><?php echo $_SESSION['box'][$i]; ?></button>
            </form>
        <?php endfor; ?>
    </div>

    <!-- Restart Button -->
    <form method="POST">
        <button type="submit" name="restart" class="restart-btn">Restart Game</button>
    </form>

  
    </div>
</body>
</html>