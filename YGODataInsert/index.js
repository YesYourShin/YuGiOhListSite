const fs = require('fs');

fs.readFile('./out.json', 'utf8', (error, jsonFile) => {
    if (error) return console.log(error);
    // console.log(jsonFile);

    const jsonData = JSON.parse(jsonFile); 
    // console.log(jsonFile);

    console.log(jsonData.length); // 배열 길이

    
    let data = jsonData.slice(10, 15);
    console.log(data);

    const cardData = JSON.stringify(data);
    fs.writeFileSync('test.json',cardData);

    // const todos = jsonData.todos;
    // todos.forEach(todo => {
    //     console.log(todo);
    // });
});