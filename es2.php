<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>es2</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
</head>
<body >

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
            
        <?php
        endif;
         
          ?>
        
        <script type="text/javascript" src="versione1_foglie.js"></script> <!-- change the version that you want -->
      
    <script>
// DEFINISCO LA STRUTTURA DATI


var result = []; //is the data structure final

    //Start to divide the parse tree and put into a data structure
    var res = string.slice(string.indexOf('('), string.lastIndexOf("'"));
    var pilaParent = [];
    var firstIndex = res.indexOf(':');
    var j = 0;
    for (i = 0; i <= res.length; i++) {

        if (res[i] == '(') {
            var nome = computeName(i);
            i = i + nome.length;
            var valore = computeValue(i + 1);
            i = i + valore.length;

            if (j == 0) {
                result[j] = {
                    name: nome,
                    value: valore,
                    parent: {},
                    id: j,
                    disegnato: false
                }
                pilaParent.push(result[j]);
            } else {
                result[j] = {
                    name: nome,
                    value: valore,
                    parent: {
                        padre: pilaParent[pilaParent.length - 1]
                    },
                    id: j,
                    disegnato: false
                }
                pilaParent.push(result[j]);
            }
            j++;
        }


        if (res[i] == ' ' && res[i + 1] != '(') {
            var nome = computeName(i);
            i = i + nome.length;
            var valore = computeValue(i + 1);
            i = i + valore.length;

            result[j] = {
                name: nome,
                value: valore,
                parent: {
                    padre: pilaParent[pilaParent.length - 1]
                },
                id: j,
                disegnato: false
            }
            j++;
        }

        if (res[i] == ')') {
            pilaParent.pop();
        }
    }


    for (i = 0; i < result.length; i++) {
        var nodo = result[i].id;
        var figli = [];
        for (j = i; j < result.length; j++) {
            if (j == 0) {
                j++;
            }
            if (nodo == result[j].parent.padre.id) {
                figli.push(result[j]);
            }
        }
        result[i].children = figli;
    }

    function computeName(index) {  //function that computes the name of each node
        var primaDuePunti = res.indexOf(":", index)

        if (res[primaDuePunti + 1] == res[primaDuePunti]) {
            return res.slice(index + 1, primaDuePunti + 1);
        } else {
            return res.slice(index + 1, primaDuePunti);
        }
    }

    function computeValue(index) { //function that computes the value of each node
        var inizioNumeri = index + 1;
        var number = '';
        while ((res[inizioNumeri] != ' ') && (res[inizioNumeri] != ')') && (inizioNumeri < res.length)) {
            number = number + res[inizioNumeri];
            inizioNumeri++;
        }
        if (isNaN(number)) {
            var ultimiDuePunti = number.lastIndexOf(":") + 1;
            number = number.slice(ultimiDuePunti);
        }
        return number;
    }
    

    var foglie = []
      function stampaFoglie(){
       for (var i=0; i<result.length; i++){
       if(result[i].children.length == 0){
       foglie.push(result[i])
       
       }
     }
  }
    stampaFoglie()
  
        
        function mostraFoglie(){
            for(var j=0; j<foglie.length; j++){
        drawTree(foglie[j], 1);
    
    }
    }
    mostraFoglie()

        
        </script>
        
</body>
</html>