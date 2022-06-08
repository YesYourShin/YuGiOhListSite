const fs = require('fs');
const mysql = require('mysql');
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'rootuser',
    database: 'yugiohtest',
});
const delay = ms => new Promise(resolve => setTimeout(() => resolve(), ms));

const main = async () => {
    connection.connect();
    for (let i = 1; i <= 1; i++) {
        fs.readFile(`../ygo-crawler/output-ja/output${i}.json`, 'utf8', (error, cards) => {
            if (error) return console.log(error);
            const jsonFile = JSON.parse(cards);
            for (const card of jsonFile) {
                // 컬럼에 예약어와 동일한 이름의 컬럼이 있기 때문에 백틱으로 감싸주어야 한다.
                // 백틱 안에서 백틱을 쓰는 방법을 찾지 못했다.
                // card 객체에 있는 key 값을 따로 모아서 백틱 + key + 백틱 으로 해서 감싸주었다.
                const columns = Object.keys(card)
                    .map(key => '`' + key + '`')
                    .join();

                const values = Object.values(card)
                    .map(key => '"' + key + '"')
                    .join();

                connection.query(`INSERT INTO cards(${columns}) VALUES(${values});`, (error, results, fields) => {
                    if (error) return console.log(error);
                    console.log(results);
                });
            }await delay(1000);
        });
        
    }
};
main();
