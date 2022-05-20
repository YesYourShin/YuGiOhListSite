const fs = require('fs');
const { mainModule } = require('process');
const axios = require('axios').default;
const delay = ms => new Promise(resolve => setTimeout(() => resolve(), ms));

const main = async () => {
    for (let i = 1; i <= 111; i++) {
        fs.readFile(`../ygo-crawler/output-ja/output${i}.json`, 'utf8', (error, jsonFile) => {
            if (error) return console.log(error);

            axios
                .post('http://127.0.0.1:8000/insert', jsonFile)
                .then(function (response) {
                    // console.log(i);
                    // console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
        });
        await delay(1000);
    }
};
main();
