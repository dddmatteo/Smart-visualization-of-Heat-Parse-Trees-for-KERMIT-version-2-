<div id="bottone"></div>
    <div class="row" style= "margin-top: 8%;"></div>

       <script>
          function drawNew(){
            var row = document.getElementsByClassName('row')[4];
            var testoInput = document.createElement("input")
            testoInput.id = "invia"
            testoInput.type = "submit"
            testoInput.value = "Submit"
            testoInput.style = "margin-right: 20%"
            testoInput.onclick=() => disegna()
            var canvass = document.createElement("canvas")
            canvass.id = "myCanvas_new"
            canvass.width = "100%";
            canvass.height = "100%";
            canvass.classList="br"
            canvass.style="border:1px solid #000000; clear: both;"
           
            row.append(testoInput)
            
            var divNew = document.createElement("div")
            divNew.style="margin-top:10%"
            row.append(divNew)
            divNew.append(canvass)
            
          }

          function creaDownloadButton(){
            
            var button = document.createElement("button");
            button.id = "myBtn"
            button.itype = "button"
            button.innerHTML = "Download Image"
            button.classList="br"
            button.style = "margin-top: 3%;"
            button.onclick=() => downloadCanvas();
         return button
          }
          var bool = false;

          //  change the version that you want (from drawtree to drawbranch)
          function disegna(){ 
            var row = document.getElementsByClassName('row')[4];
            var bottone = creaDownloadButton()
            canvas = document.getElementById('myCanvas_new');
            canvas.height = levelLength * (livello + 1);
            canvas.width = window.innerWidth;       
            drawTree(result[0], 1);
            drawBranch(result[0], 1);
            canvas.width = spazioOccupato;
            spazioOccupato = 0;
            drawTree(result[0], 1);
            drawBranch(result[0], 1);

            if (bool == false)
            row.append(bottone)
            bool = true;
          }


              function downloadCanvas() {  //function that download the Canvas in png
        var link = document.createElement('a');
        link.download = "canvas_new.png";
        link.href = document.getElementById("myCanvas_new").toDataURL("image/png");
        link.click();
}

      
    // DEFINISCO LA STRUTTURA DATI
        var string = "<?php echo $activeTree ?>";
        var brotherDistance
        var levelLength

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
        
      // FUNZIONE DI MODIFICARE DEL COLORE

        function modify_value(identifier){
          var new_val=document.getElementById(identifier).value;
          result[identifier].value=new_val;
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
            inputElement.value=result[i].value;
            return inputElement
          }

          function creaNodo(i){
            const divElement = document.createElement("div");
            const divElement_2 = document.createElement("div");
            divElement.classList = "divLettere"
            divElement.append(divElement_2)
            divElement_2.innerHTML = result[i].name  
            return divElement
          }

          // BOTTONE FINALE
          
        function creaBottone(){
          var btnMeno, btnPiu, textInput, aggLettera
          var divBottone = document.getElementById("bottone");
          for (var i=0; i<result.length; i++){
          btnMeno = createMinusButton(i)
          btnPiu = createPlusButton(i)
          textInput = createInputElement(i)
          aggLettera = creaNodo(i)
          divBottone.append(aggLettera)
          aggLettera.append(btnMeno)
          aggLettera.append(textInput)
          aggLettera.append(btnPiu)
          
      }
      
    }
  
  creaBottone();   
  drawNew();
  
</script>  


