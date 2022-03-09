const fs = require("fs");
const axios = require("axios").default;
const cheerio = require("cheerio");

// const cardInfoJson = require('./cardinfo.php.json')

const delay = ms => new Promise(resolve => setTimeout(() => resolve(), ms));

// 각 카드의 페이지 번호 가져오기
const fetchCardList = async (page, locale) => {
    const response = await axios.get(
        `https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=1&page=${page}&request_locale=${locale}`
    );
    const $ = cheerio.load(response.data);
    const list = [];

    if ($.html().includes("no_data")) {
        return list;
    }

    $(".box_list > li > input.link_value").map((_i, item) => {
        const values = $(item).val().split("=");
        list.push(values[values.length - 1]);
    });
    console.log(page);
    return list;
};

const fetchCardInfo = async (id, locale) => {
    const info = {};
    const response = await axios.get(
        `https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=${id}&request_locale=${locale}`
    );
    const $ = cheerio.load(response.data);
    // info.titles = $('#broad_title h1').text().trim().split('\n').map((t) => t.trim()).filter((t) => t)
    info.title = $("#broad_title h1")
        .text()
        .trim()
        .split("\n")
        .map(t => t.trim())
        .filter(t => t)[0];

    // if(info.text)
    if ($(".item_box_title").text().includes("펜듈럼")) {
        console.log(
            $(".item_box_text")
                .text()
                .trim()
                .split("\n")
                .slice(1)
                .join("")
                .trim()
                .split("\t")[0] == "카드 텍스트"
        );
        if (
            $(".item_box_text")
                .text()
                .trim()
                .split("\n")
                .slice(1)
                .join("")
                .trim()
                .split("\t")[0] == "카드 텍스트"
        ) {
            info.ptext = "";
            info.text = $(".item_box_text")
                .text()
                .trim()
                .split("\n")
                .slice(1)
                .join("")
                .trim()
                .split("\t")
                .slice(1)
                .join("");
        } else {
            info.ptext = $(".item_box_text")
                .text()
                .trim()
                .split("\n")
                .slice(1)
                .join("")
                .trim()
                .split("\t");
            info.text = info.ptext[48];
            // info.text.push(info.ptext[30], info.ptext[48])
            info.ptext = info.ptext[0];
            // console.log(info.ptext[0])
        }
    } else {
        // info.text = $('.item_box_text').text().trim().split('\n').slice(1).join('\n').trim()
        info.text = $(".item_box_text")
            .text()
            .trim()
            .split("\n")
            .slice(1)
            .join("")
            .trim()
            .split("\t")
            .shift();
    }

    // if($('.forbidden_limiteds').text()) {

    // }

    $("#details .item_box").map((_i, box) => {
        box = $(box);
        const key = box.children(".item_box_title").text().trim();
        // console.log(box.children('div.item_box').remove().end().text().trim())
        let value = box.children(".item_box_value").text().trim();

        // https://stackoverflow.com/questions/20832910/get-text-in-parent-without-children-using-cheerio

        if (!value) {
            // if(key=='종족') {
            //     value = box.children('div.item_box').remove().end().text().trim().split('\n').slice(1).join('').trim()
            // } else if(key=='기타 항목') {
            //     value = box.children('div.item_box').remove().end().text().trim().split('\n').slice(1).join('').trim().split('\t').join('')

            // } else if (key=='펜듈럼 스케일'){
            //     value = box.children('div.item_box').remove().end().text().trim().split('\n').slice(1).join('').trim().split('\t').join('')
            //     console.log(value)
            // }
            value = box
                .children("div.item_box")
                .remove()
                .end()
                .text()
                .trim()
                .split("\n")
                .slice(1)
                .join("")
                .trim()
                .split("\t")
                .join("");
        }

        // if(!box.includes('item_box_value')) {
        //     const value = box.children('.item_box_title').text().trim()[1]
        // }

        info[key] = value;
    });

    if ($(".forbidden_limited").text()) {
        info.limited = $(".forbidden_limited")
            .text()
            .split("\n")
            .slice(1)
            .join("")
            .split("\t")
            .join("");
    }

    // $('#broad_title .row').map((_i, box) => {

    // })

    // console.log(info)
    return info;
};

const mergeCardInfo = info => {
    const json = JSON.stringify(info);
    return json;
};

const main = async () => {
    const data = [];
    for (let page = 1; true; page++) {
        const koids = await fetchCardList(page, "ko");
        for (let id of koids) {
            const info = await fetchCardInfo(id, "ko");
            // const merged = mergeCardInfo(info)
            // console.log(merged)
            data.push(info);
            // console.log(info)
        }

        fs.writeFileSync("out.json", JSON.stringify(data));
    }

    // const jaids = await fetchCardList(ja)
    // const koids = await fetchCardList(ko)
    // for(let id of jaids) {
    //     const info = await fetchCardInfo(id, 'ja')
    //     const merged = mergeCardInfo(info)
    // }

    // for(let page = 1 ; page <= 2 ; page++) {
    //     console.log(`page ${page}`)
    //     const ids = await fetchCardList(page)
    //     for(let id of ids) {
    //         const info = await fetchCardInfo(id, 'ko')
    //         const merged = mergeCardInfo(info, cardInfoJson)
    //         delete merged.card_pricesz
    //         data.push(merged)
    //     }
    //     fs.writeFileSync('out.json', JSON.stringify(data))
    //     // await delay(1000)
    // }
};

main();
