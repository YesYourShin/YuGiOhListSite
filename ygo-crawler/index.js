const fs = require("fs");
const axios = require("axios").default;
const cheerio = require("cheerio");

// 의문점
// 주소창에서 입력 해 json파일을 받을 때와 js파일을 실행해서 받는 파일의 배열 순서가 뭔가 다름
// 7(세븐) 카드가 js파일로 받을 때 맨 처음임

// 끝을 알 수가 없음
// offset을 말도 안 되는 숫자인 20000으로 했을 때 0부터 다시 받았음

// 퍼센트 인코딩 변환 인코더
// https://www.convertstring.com/ko/EncodeDecode/UrlEncode

// 각 카드의 페이지 번호 가져오기
const fetchCardList = async (offset, limit) => {
    const response = await axios.get(
        // `http://yugioh.wikia.com/index.php?title=Special:Ask&q=[[Japanese+kana+name::%2B]]&po=?Japanese name%0A?Page name%0A?Japanese name%0A?Japanese kana name%0A?Ruby Japanese name%0A?Ruby text%0A?Card image%0A?Card category%0A?Card type%0A?Card type (short)%0A?Property%0A?Property (short)%0A?S/T Class%0A?Attribute%0A?Type%0A?Type3%0A?Type4%0A?Level string%0A?Rank string%0A?Pendulum Scale String%0A?Link Arrows%0A?Link Rating%0A?Japanese Pendulum Effect%0A?Japanese lore%0A?Materials%0A?ATK string%0A?DEF string%0A?Passcode%0A?OCG Status%0A?Japanese database ID%0A?Card Gallery page for%0A?Card Tips page for%0A?Cover card%0A?Fusion Material%0A?Support%0A?Archetype support%0A?Archseries%0A?Primary type%0A?Set information%0A?Set information (JSON)%0A?Limitation Text%0A&eq=yes&p%5Bformat%5D=JSON&sort%5B0%5D=&order%5B0%5D=ASC&sort_num=&order_num=ASC&p%5Blimit%5D=500&p%5Boffset%5D=&p%5Blink%5D=all&p%5Bsort%5D=&p%5Bheaders%5D=show&p%5Bmainlabel%5D=&p%5Bintro%5D=&p%5Boutro%5D=&p%5Bsearchlabel%5D=...+further+results&p%5Bdefault%5D=&p%5Bclass%5D=sortable+wikitable+smwtable&p%5Bsep%5D=&eq=yes`
        `http://yugioh.wikia.com/index.php?title=Special:Ask&q=[[Japanese+kana+name::%2B]]&po=?Japanese name%0A?Page name%0A?Japanese name%0A?Japanese kana name%0A?Ruby Japanese name%0A?Ruby text%0A?Card image%0A?Card category%0A?Card type%0A?Card type (short)%0A?Property%0A?Property (short)%0A?S/T Class%0A?Attribute%0A?Type%0A?Type3%0A?Type4%0A?Level string%0A?Rank string%0A?Pendulum Scale String%0A?Link Arrows%0A?Link Rating%0A?Japanese Pendulum Effect%0A?Japanese lore%0A?Materials%0A?ATK string%0A?DEF string%0A?Passcode%0A?OCG Status%0A?Japanese database ID%0A?Card Gallery page for%0A?Card Tips page for%0A?Cover card%0A?Fusion Material%0A?Support%0A?Archetype support%0A?Archseries%0A?Primary type%0A?Set information%0A?Set information (JSON)%0A?Limitation Text%0A&eq=yes&p%5Bformat%5D=JSON&sort%5B0%5D=&order%5B0%5D=ASC&sort_num=&order_num=ASC&p%5Blimit%5D=${limit}&p%5Boffset%5D=${offset}&p%5Blink%5D=all&p%5Bsort%5D=&p%5Bheaders%5D=show&p%5Bmainlabel%5D=&p%5Bintro%5D=&p%5Boutro%5D=&p%5Bsearchlabel%5D=...+further+results&p%5Bdefault%5D=&p%5Bclass%5D=sortable+wikitable+smwtable&p%5Bsep%5D=&eq=yes`
    );

    return response.data;
};

const main = async () => {
    let offset = 20000;
    let limit = 500;
    for (let i = 1; i < 2; i++) {
        let data = await fetchCardList(offset, limit);
        fs.writeFileSync(`./outJson/out${i}.json`, JSON.stringify(data));
        offset += 500;
        console.log(i);
    }
};

main();
