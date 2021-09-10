const fs = require('fs');
const axios = require('axios').default

fs.readFile('./src/input/out.json', 'utf8', (error, jsonFile) => {
    if (error) return console.log(error);
    // console.log(jsonFile);

    const jsonData = JSON.parse(jsonFile); 
    // console.log(jsonFile);

    console.log(jsonData.length); // 배열 길이

    let count = 0;

    for(let i = 0; i <= jsonData.length; i++){

        if (i%1000==0 && i !=0) {
            let data = jsonData.slice(i-1000, i);
            count += 1;
            // cardDataOutput(data, count);
            cardDataInsert(data);

        }

        if (i == jsonData.length) {
            let data = jsonData.slice(((count*1000)+1), i);
            // cardDataOutput(data, count);
            cardDataInsert(data);
        }
    }
    // const todos = jsonData.todos;
    // todos.forEach(todo => {
    //     console.log(todo);
    // });
});

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