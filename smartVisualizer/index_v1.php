<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>Smart visualization of Heat Parse Trees for KERMIT Version</title>
    
</head>

<body>
   
    <h1>Smart visualization of Heat Parse Trees for KERMIT</h1>
    <div class="container">
        <form method="post">
            <div class="row">
                <div class="col-25">
                    <label for="atree">Active Tree</label>
                </div>
                <div class="col-75">
                    <input type="text" id="atree" name="activeTree" placeholder="Active Tree" required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="bDistance">Brothers Distance</label>
                </div>
                <div class="col-75">
                    <input type="number" id="bDistance" name="brothersDistance" min="1" placeholder="Brothers Distance in px" required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="llength">Level Length</label>
                </div>
                <div class="col-75">
                    <input type="number" id="llenght" name="levelLength" min="1" placeholder="Level Length in px" required>
                </div>
            </div>
            <div class="row">
                <input id="invia" type="submit" value="Submit">
            </div>
        </form>
    </div>
    <?php if (isset($_POST['activeTree']) && isset($_POST['brothersDistance']) && isset($_POST['levelLength'])) : ?>
        <p>
            <ul>
                <li>Active Tree: <?php
                                    $activeTree = $_POST['activeTree'];
                                    echo $activeTree;
                                    ?>
                </li>
                <li>Brothers Distance: <?php
                                        $brothersDistance = $_POST['brothersDistance'];
                                        echo $brothersDistance . "px";
                                        ?>
                </li>
                <li>Level Length: <?php
                                    $levelLength = $_POST['levelLength'];
                                    echo $levelLength . "px";
                                    ?>
                </li>
            </ul>
            <button itype="button" id="myBtn" onclick="downloadCanvas()">Download Image</button>
        </p>
        <div>
            <canvas id="myCanvas" width="100%" height="100%" style="border:1px solid #000000;">
            </canvas>

        </div>
        <script>
            var string = "<?php echo $activeTree ?>";
            var brotherDistance = <?php echo $brothersDistance?>;
            var levelLength = <?php echo $levelLength?>;
        </script>
        <script type="text/javascript" src="version1.js"></script> <!-- change the version that you want -->
  
    <?php include ("es1_v1.php");
    endif;
     
      ?>
    <footer>
        © Tesi Andrea Ciccotti 2020, Università degli Studi di Roma "Tor Vergata", code avaiable on <a href="https://github.com/ART-Group-it/Smart-visualization-of-Heat-Parse-Trees-for-KERMIT" target="blank"> <i class="fa fa-github" aria-hidden="true"></i></a>
         </footer>
</body>


<?php
    if(!empty($_POST['activeTree'])){
        $activeTree = htmlspecialchars($_POST['activeTree']);  //to prevent XSS attack
    }
?>
