const fs = require('fs');
fs.readFile('./src/output/output2.json', 'utf8', (error, jsonFile) => {
    const data = JSON.parse(jsonFile);
    console.log(data[26]);
});