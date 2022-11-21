const fs = require('fs');
const axios = require('axios').default;
const cheerio = require('cheerio');
const { data } = require('cheerio/lib/api/attributes');
const { children } = require('cheerio/lib/api/traversing');

// const cardInfoJson = require('./cardinfo.php.json')

const delay = ms => new Promise(resolve => setTimeout(() => resolve(), ms));

// 각 카드의 페이지 번호 가져오기
const fetchCardList = async (item, page, locale) => {
  const response = await axios.get(`https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=1&rp=${item}&page=${page}&request_locale=${locale}`);
  const $ = cheerio.load(response.data);
  const list = [];

  if ($.html().includes('no_data')) {
    return false;
  }

  $('.list > .t_row > input.link_value').map((i_, item) => {
    const values = $(item).val().split('=');
    list.push(values[values.length - 1]);
  });

  return list;
};

const fetchCardInfo = async (id, locale) => {
  const info = {};
  const response = await axios.get(`https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=${id}&request_locale=${locale}`);
  const $ = cheerio.load(response.data);

  const n = locale == 'ko' ? 0 : locale == 'ja' ? 1 : null;
  // 카드 이름
  info.name = $('#cardname h1')
    .text()
    .trim()
    .split('\n')
    .map(t => t.trim())
    .filter(t => t)[n];

  if (locale === 'ja') {
    info.name2 = $('#cardname h1')
      .text()
      .trim()
      .split('\n')
      .map(t => t.trim())
      .filter(t => t)[n - 1];
  }

  // 유희왕 db 사이트의 해당 카드의 id를 code로 저장
  info.code = id;

  // limited는 나중에 테이블 따로 만들면 그 떄 필요할 거 같으니
  // 쓰기 전까지는 주석 처리함
  // const limited = $('#CardSet > .forbidden_limited_ber > .title').text();
  // limited !== '' ? (info.limited = limited) : false;

  // 카드 상세 데이터
  const cardData = $('#CardTextSet > .CardText > .frame > .item_box > .item_box_value')
    .text()
    .trim()
    .split('\n')
    .map(t => t.trim())
    .filter(t => t);

  if (cardData.length === 1) {
    // 마법 함정 타입
    info.icon = cardData[0];
  } else if (cardData.length >= 4) {
    const species = $('#CardTextSet > .CardText > .frame > .item_box > .species')
      .text()
      .trim()
      .split('\n')
      .map(t => t.trim())
      .filter(t => t);

    info.attribute = cardData[0];

    const lvRankLink = $('#CardTextSet > .CardText > .frame > .item_box > .item_box_title')
      .text()
      .trim()
      .split('\n')
      .map(t => t.trim())
      .filter(t => t)[1];

    if (locale === 'ko') {
      // 랭크 링크 레벨
      lvRankLink === '랭크' ? (info.rank = cardData[1]) : lvRankLink === '링크' ? (info.link = cardData[1]) : (info.level = cardData[1]);
    } else if (locale === 'ja') {
      lvRankLink === 'ランク' ? (info.rank = cardData[1]) : lvRankLink === 'リンク' ? (info.link = cardData[1]) : (info.level = cardData[1]);
    }
    info.atk = cardData[2];
    info.def = cardData[3];
    info.monster_type = species[0];

    info.card_type = species.join(' ');
    // info.cardType1 = species[2];
    // species.length >= 5 ? (info.cardType2 = species[4]) : false;
    // species.length === 7 ? (info.cardType3 = species[6]) : false;

    // 펜듈럼 카드
    if (cardData.length === 5) {
      // 펜듈럼 스케일
      info.p_scale = cardData[4];

      // 펜듈럼 효과
      info.p_effect = $('#CardTextSet > .CardText > .frame > .item_box_text').text().trim();
    }
  }
  info.card_text = $('#CardTextSet > .CardText > .item_box_text').children('.text_title').remove().end().text().trim();

  // 아래의 사이트를 참고하였음
  // https://stackoverflow.com/questions/27430267/cheeriojs-looping-through-ul-with-same-class-name
  const cardList = [];
  $('#update_list > .t_body .t_row').each((i, elm) => {
    obj = {};
    obj.time = $('.time', elm).text().trim();
    obj.card_number = $('.card_number', elm).text().trim();
    obj.pack_name = $('.pack_name', elm).text().trim();
    obj.rare = $('.icon', elm)
      .text()
      .split('\n')
      .map(t => t.trim())
      .filter(t => t)
      .slice(-1)[0];
    cardList.unshift(obj);
  });

  // console.log(cardList);

  info.card_list = cardList;

  return info;
};

const main = async () => {
  for (let page = 1; true; page++) {
    const data = [];
    const item = 100;
    const locale = 'ja';
    const koids = await fetchCardList(item, page, locale);
    if (!koids) {
      return;
    }
    let i = 1;
    for (let id of koids) {
      const info = await fetchCardInfo(id, locale);
      data.push(info);
      console.log(`${page}_${i}`);
      i++;
    }

    fs.writeFileSync(`output-${locale}/output${page}.json`, JSON.stringify(data));
    await delay(500);
  }
};

main();
