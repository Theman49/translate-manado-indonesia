<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>TEST</title>
    <style>
        #suggestions {
            height: 300px;
            overflow: auto;
        }
        .list-group .list-group-item:hover {
            background-color: rgba(0,0,0,.5);
            color: white;
            cursor: pointer;
        }

        .divider {
            height: 200px;
            width: 2px;
            background: #999;
        }
    </style>
</head>
<body onload="switchLang()">
    <div class="container mt-3">
        <h1 class="mb-3">Kamus Indonesia - Manado</h1>


        <div class="d-flex">
            <div class="w-100">
                <label for="input_word"><span id="label-input">Manado</span>:</label><br/>
                <input class="w-100" type="text" id="input_word" onkeyup="doDelayedSearch(this.value)"/>
                <div id="suggestions">
                    <ul class="list-group ms-5">
                    </ul>
                </div>
            </div>
            

            <div class="d-flex flex-column mt-4 mx-5">
                <div class="w-100">
                    <button class="d-block mx-auto" id="switch" onclick="switchLang()">switch</button>
                </div>

                <div class="w-100">
                    <div class="divider mx-auto mt-5"></div>
                </div>

            </div>

            <div class="w-100">
                <label><span id="label-result">Indonesia</span>:</label><br/>
                <input class="w-100" type="text" id="result_word" readonly/>
            </div>

        </div>

    </div>

    <!-- <div class="container mt-3">
        <h1>Raita</h1>
        <div class="d-flex justify-content-between w-25">
            <div>
                <label>Text:</label>
                <input class="w-75" type="text" id="text">
            </div>
            <div>
                <label>Pattern:</label>
                <input class="w-75" type="text" id="pattern">
            </div>
        </div>
        <div>
            <p class="my-3" id="raita_result"></p>
        </div>
        <button onclick="countRaita()">count</button>
    </div> -->

    <script>
        let targetLang = "indonesia";
        let fromLang = "manado";
        var timeout = null;

        const inputWord = document.getElementById("input_word")
        const resultWord = document.getElementById("result_word")

        function runLevenshtein(){
            // levenshtein
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onload = function() {
                let response = JSON.parse(this.responseText)
                response = response.sort((a,b) => (a.lev_dist > b.lev_dist) ? 1 : (a.lev_dist < b.lev_dist) ? -1 : 0)

                console.log(response)
                // let listResponse = response.slice(0, 5)
                let listResponse = response.slice(0,10)
                listResponse = listResponse.map((item) => `
                    <li class="d-flex justify-content-between list-group-item" onclick="getTranslatedWord(this.children[0].innerText)">
                        <p class="mb-0">${item.compared_word}</p>
                        <p class="mb-0 text-secondary">${item.lev_dist}</p>
                    </li>`)
                document.querySelector("#suggestions ul").innerHTML = listResponse.join("");
            }
            xmlhttp.open("GET", "./test/count_lev_dist?word_query=" + inputWord.value + "&target_lang=" + targetLang);
            xmlhttp.send();
        }

        function doDelayedSearch(val) {
            if (timeout) {  
                clearTimeout(timeout);
            }
            timeout = setTimeout(function() {
                // // levenshtein
                // const xmlhttp = new XMLHttpRequest();
                // xmlhttp.onload = function() {
                //     let response = JSON.parse(this.responseText)
                //     response = response.sort((a,b) => (a.lev_dist > b.lev_dist) ? 1 : (a.lev_dist < b.lev_dist) ? -1 : 0)

                //     console.log(response)
                //     // let listResponse = response.slice(0, 5)
                //     let listResponse = response.slice(0,10)
                //     listResponse = listResponse.map((item) => `
                //         <li class="d-flex justify-content-between list-group-item" onclick="getTranslatedWord(this.children[0].innerText)">
                //             <p class="mb-0">${item.compared_word}</p>
                //             <p class="mb-0 text-secondary">${item.lev_dist}</p>
                //         </li>`)
                //     document.querySelector("#suggestions ul").innerHTML = listResponse.join("");
                // }
                // xmlhttp.open("GET", "./test/count_lev_dist?word_query=" + val + "&target_lang=" + targetLang);
                // xmlhttp.send();

                // raita
                const xmlhttp = new XMLHttpRequest();
                xmlhttp.onload = function() {
                    let response = JSON.parse(this.responseText)
                    if(response.status == false){
                        document.querySelector("#suggestions ul").innerHTML = `
                            <li>${response.message}</li>
                            <button class="w-fit" onclick="runLevenshtein()">Tampilkan Saran</button>
                        `;
                    }else{
                        response = response.data
                        response = response.sort((a,b) => (a.iteration > b.iteration) ? 1 : (a.iteration < b.iteration) ? -1 : 0)

                        console.log(response)
                        // let listResponse = response.slice(0, 5)
                        let listResponse = response.slice(0,10)
                        listResponse = listResponse.map((item) => `
                            <li class="d-flex justify-content-between list-group-item" onclick="getTranslatedWord(this.children[0].innerText)">
                                <p class="mb-0">${item.word}</p>
                                <p class="mb-0 text-secondary">${item.iteration}</p>
                            </li>`)
                        document.querySelector("#suggestions ul").innerHTML = listResponse.join("");
                    }
                }
                xmlhttp.open("GET", "./test/count_raita?word_query=" + val + "&from_lang=" + fromLang);
                xmlhttp.send();
            }, 2000);
        }

        function switchLang(){
            const labelInput = document.getElementById('label-input')
            const labelResult = document.getElementById('label-result')
            if(targetLang == "indonesia"){
                labelInput.innerText = "Indonesia"
                labelResult.innerText = "Manado"
                
                targetLang = "manado"
                fromLang = "indonesia"
            }else if(targetLang == "manado"){
                labelInput.innerText = "Manado"
                labelResult.innerText = "Indonesia"
                
                targetLang = "indonesia"
                fromLang = "manado"
            }

            const temp = inputWord.value
            inputWord.value = resultWord.value
            resultWord.value = temp
        }

        function getTranslatedWord(val){
                inputWord.value = val
                const xmlhttp = new XMLHttpRequest();
                xmlhttp.onload = function() {
                    document.getElementById("result_word").value = this.responseText
                }
                xmlhttp.open("GET", "./test/get_translated_word?word_query=" + val +"&from_lang=" + fromLang);
                xmlhttp.send();
        }

        function countRaita(){
                const pattern = document.getElementById("pattern");
                const text = document.getElementById("text");
                const xmlhttp = new XMLHttpRequest();
                xmlhttp.onload = function() {
                    console.log(this.responseText);
                    document.getElementById('raita_result').innerHTML = this.responseText
                }
                xmlhttp.open("GET", "./test/count_raita?pattern=" + pattern.value + "&text=" + text.value);
                xmlhttp.send();
        }


    </script>
</body>
</html>