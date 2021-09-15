const fs = require('fs');
const axios = require('axios').default
const delay = (ms) => new Promise((resolve) => setTimeout(() => resolve(), ms))

fs.readFile('./src/input/out.json', 'utf8', (error, jsonFile) => {
    if (error) return console.log(error);
    // console.log(jsonFile);

    const jsonData = JSON.parse(jsonFile); 
    // console.log(jsonFile);

    // console.log(jsonData.length); // 배열 길이

    
    load(jsonData)

    // const todos = jsonData.todos;
    // todos.forEach(todo => {
    //     console.log(todo);
    // });
});

async function load(jsonData) {
console.log('load')
    let count = 0;
    for(let i = 0; i <= jsonData.length; i++){
        
        if (i%100==0 && i !=0) {
            let data = jsonData.slice(i-100, i);
            count += 1;
            cardDataOutput(data, count);
            cardDataInsert(data);
            console.log(count)

        }

        if (i == jsonData.length) {
            let data = jsonData.slice(((count*100)+1), i);
            cardDataOutput(data, count);
            cardDataInsert(data);
        }
        await delay(50)
    }
}

function cardDataInsert(data) {

    const cardData = JSON.stringify(data);
    axios.post('http://127.0.0.1:8000/insert', cardData,{
        headers:{"Content-Type" : "application/json"}
    })
    // .then(function (response) {
    //     console.log(response);
    // })
    .catch(function (error) {
        console.log(error);
    });
}

function cardDataOutput(data, count) {
    const cardData = JSON.stringify(data);
    fs.writeFileSync(`./src/output/output${parseInt(count)}.json`,cardData);
}