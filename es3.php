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
            <script type="text/javascript" src="versione1_foglie.js"></script> <!-- change the version that you want -->
            <div id="bottone"></div>
    <div class="row" style= "margin-top: 8%;"></div>
        <?php
        endif;
         
          ?>
        
  
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

        

// FUNZIONE DI MODIFICARE DEL COLORE

function modify_value(identifier){
          var new_val=document.getElementById(identifier).value;
          foglie[identifier].value=new_val;
        }
    // FUNZIONE DI INCREMENTO E DECREMENTO DEL BOTTONE
      function increment(identifier) {
        document.getElementById(identifier).stepUp(1);
        modify_value(identifier);
      }

      function decrement(identifier) {
        document.getElementById(identifier).stepDown(1);
        modify_value(identifier);
        
      }

    // FUNZIONE CHE STAMPA SOLO LE FOGLIE DELL'ALBERO
        var foglie = []
          function stampaFoglie(){
            
            for (var i=0; i<result.length; i++){
              if(result[i].children.length == 0){
              foglie.push(result[i])
            
            }
            }

          }

      // BOTTONE PIU E MENO

          function createPlusButton(i){
        const plusButton = document.createElement("button");
        plusButton.onclick=() => increment(i);
        plusButton.classList="inc";
        plusButton.innerHTML="+";
        return plusButton
      }

      function createMinusButton(i){
        const minusButton = document.createElement("button");
        minusButton.onclick=() => decrement(i);
        minusButton.classList="dec";
        minusButton.innerHTML="-";
        return minusButton
      }
        
      // BLOCCO NUMERO E LETTERA
      function createInputElement(i){
            const inputElement = document.createElement("input");
            inputElement.classList = "inserisci"
            inputElement.type = "number";
            inputElement.readOnly = true;
            inputElement.max="1";
            inputElement.min="0";
            inputElement.step="0.1";
            inputElement.id=+""+i;
            inputElement.value=foglie[i].value;
            return inputElement
          }

          function creaNodo(i){
            const divElement = document.createElement("div");
            divElement.classList = "divLettere"
            divElement.innerHTML = foglie[i].name  
            
            return divElement
          }

          // BOTTONE FINALE
          
        function creaBottone(){
          var btnMeno, btnPiu, textInput, aggLettera
          var divBottone = document.getElementById("bottone");
          for (var i=0; i<foglie.length; i++){
          btnMeno = createMinusButton(i)
          btnPiu = createPlusButton(i)
          textInput = createInputElement(i)
          aggLettera = creaNodo(i)
          divBottone.append(aggLettera)
          aggLettera.append(textInput)
          aggLettera.append(btnMeno)
          aggLettera.append(btnPiu)
          textInput.classList="br"
          
      }
      
    }
         

          function drawNew_foglie(){
            var row = document.getElementsByClassName('row')[4];
            var button = document.createElement("button");
            button.id = "myBtn"
            button.itype = "button"
            button.innerHTML = "Download Image"
            button.classList="br"
            button.style = "clear:both; margin-top: 8%; margin-bottom: 3%;"
            button.onclick=() => downloadCanvas_new();
            var testoInput = document.createElement("input")
            testoInput.id = "invia"
            testoInput.type = "submit"
            testoInput.value = "Submit"
            testoInput.style = " margin-top: 1%; margin-right: 10%"
            testoInput.onclick=() => disegnaFoglie()
            var canvass = document.createElement("canvas")
            canvass.id = "myCanvas_new"
            canvass.width = "100%";
            canvass.height = "100%";
            canvass.classList="br"
            canvass.style="border:1px solid #000000; clear: both;"
           
           
            row.append(testoInput)
            row.append(button)

            var divNew = document.createElement("div");
            row.append(divNew)
            divNew.append(canvass)
            
          }

          function disegnaFoglie(){
            canvas = document.getElementById('myCanvas_new');
            canvas.height = levelLength * (livello + 1);
            canvas.width = window.innerWidth;
            mostraFoglie()
            canvas.width = arraySpazioLivelli[arraySpazioLivelli.length - 1];
            for (let i = 0; i < livello; i++) {
                arraySpazioLivelli[i] = 0;
            }
            mostraFoglie()
            
          }


          function downloadCanvas_new() {  //function that download the Canvas in png
        var link = document.createElement('a');
        link.download = "canvas_new.png";
        link.href = document.getElementById("myCanvas_new").toDataURL("image/png");
        link.click();
}

        function downloadCanvas() {  //function that download the Canvas in png
                var link = document.createElement('a');
                link.download = "canvas.png";
                link.href = document.getElementById("myCanvas").toDataURL("image/png");
                link.click();
}
       
        stampaFoglie();
        creaBottone(); 
        drawNew_foglie()
        </script>
        
</body>
</html>