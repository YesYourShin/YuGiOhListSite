# 백엔드

## 완료

- 카드 crud 할 때 컨트롤러에서도 데이터가 제대로 왔는지 validate 확인 및 에러 메세지
- 로그인 한 사용자(토큰을 가진 클라이언트)가 자신의 정보를 요청할 경우 자신의 이름과 이메일을 줌

- create나 update로 user_id를 받지 말고 보낸 사람의 로그인 정보로 유저 아이디를 추출해서 쓰기(그렇게 안 하면 다른 사람이 아이디 바꿔서 crud 가능)
- 프론트쪽에서는 한 api로만 신호를 보내고
  백에서 받은 정보를 바탕으로 create인가 update인가를 판단하기"

- 전체 카드와 유저가 가진 카드 페이지네이션

- 유저가 가진 카드 테이블도 언어별로 나누기

- db에서 user id 나 cardid는 bigint로 설정하기

- 유희왕 사이트에서 쓰는 카드 별 아이디도 db에 저장하여
- 아이디는 각 언어의 card테이블에 code칼럼으로 저장
- 카드 정보 제공할 때 아이디로 찾는 게 아니라 code로 찾아 정보 제공

- usercardshow를 유저 카드 리스트를 보여주는 usercardindex함수로 변경
- usercardshow 새로 만듬 카드 아이디를 기준으로 card_number를 찾아 소지중인 개수를 보여줌

---

## 하고 있는 거

---

## 미완료

- 관리자만 db에 카드 정보 집어넣기 가능하게 하기(어떻게 하는지 모름)
- 자동으로 추가된 카드가 있는지 특정 시간대에 확인해서 있으면 집어넣기

- 로그인 안 된 유저 api에서 걸리는 거 오류 메세지 출력 해주기

- 로그인 후 토큰 만료 기간 따로 설정 가능하면 짧게 설정하기 (1년은 너무 긴 듯?)
  아니면 이미 토큰을 받은 사람은 다음에 로그인 할 때도 같은 토큰 주기

- 비밀번호 찾기 기능 만들기

- CardController 에서 create와 update 궁금한거
  다른 함수 하나 만들어서 카드 정보 받은 후에 DB에 카드 정보 없으면 create, 있으면 update 하는 게 낫나?

- 만약 필요한 정보들 외에 추가로 다른 정보가 같이 들어올 경우 이런 건 에러처리 안 하나?

# 프론트 엔드

## 완료

- 로그인 페이지에 회원 가입 페이지로 가는 버튼 추가
- 회원가입 페이지 css 적용
- 유저가 현재 로그인이 됐는지 체크는 토큰만 확인
- 유저가 토큰을 가지고 있을 경우 유저 정보 요청해 유저 정보 저장
- 네이게이션바 프로필 누르면 나오는 드롭메뉴에도 로그인 되어있지 않을 때 회원가입 버튼 추가
- 로그인 된 유저는 로그인, 회원가입 페이지 갈 수 없도록 하기
- 언어 선택하는 버튼 만들고 언어 변경되면 카드 리스트 변경되기
- 카드 정보 페이지 아이디가 아니라 code로 파라미터 전송
- 카드 상세 정보 확인 란에서 언어 바꾸면 해당 언어에 맞게 정보 표시(해당 언어에 이 카드가 없을 경우 없는 페이지라고 띄우기)
- 로그인 후 바로 사용자 정보 요청하기
- 로그인 후 뒤로가기 같은 걸 했을 때 안 되게 하기
- 유저가 가진 카드 리스트 출력
- mounted 쓰지 말고 watch immediate으로 최초실행되게 하기

carditem.vue {
carditem.vue에 저 기능들 알아보기 쉽게 바꾸기
지금 개 더러움 진짜

- 카드 상세 정보에서 유저가 로그인 중이면 해당 유저가 가진 카드의 수량 표시해주기
- 같은 수량일 경우 서버에 요청 안 하게 바꾸기
- 카드 수량은 로그아웃되면 다 사라져야 됨
  }
- 로그인 된 유저만 카드 개수 crud 할 수 있도록 하기
- 로그인 안 된 유저는 카드 crud 못하게 막기
- card도 computed 할 것
- 언어 별로 crud 되게 하기
- amount 없을 때 엔터하면 값이 변경되었습니다 창 뜨는 거 수정하기
- vuex mutation에서 actions으로
- 전체 카드와 유저가 가진 카드 페이지네이션

---

나중에 다시 한 번 보셈
userStore에 getPages getCurrentPage 같은 것도 있으니까

- 페이지네이션을 url query로 표시하는 게 좋을 듯?
- vue router params 랑 query 구분해서 사용하는 이유??
- 페이지네이션 하고 있는 페이지에서 아이템 클릭해서
  아이템 상세 페이지 확인 후 뒤로가기를 했을 때,
  아이템 클릭 전 페이지네이션을 그대로 유지하기
- userStore에서 resetPage 할 때 lastPage도 초기화??

---

---

## 지금 하는 중

## 미완료

- 검색 및 필더, 정렬 기능 추가

- MenuBar.vue에 updateLang()을 select에서 할 수 있도록 하기

- 비밀번호 찾기 페이지

- 로그인 페이지에서 로그인 할 때 로그인 버튼 한 번 누르고 나면 다시 버튼 못 누르게 해서 요청 못 보내게 하기

- 로그아웃 했을 때 로그인 된 유저만 있을 수 있는 페이지면 페이지 이동시키기

- 로그인 dropdown에 a태그 썼는데 href안쓰면 굳이 a태그 쓸 필요 있나? href를 안 쓰는 데 a태그를 쓰는 건 맞는 건가?

기록

- vuex mutation getters actions 등 설명 사용법
  https://ux.stories.pe.kr/149
  getters는 computed에서 this.$store.getters.isLogin; 이런 식으로 씀

- 라라벨 유저의 토큰으로 유저의 정보를 찾는 방법
  https://laracasts.com/discuss/channels/laravel/get-user-id-by-access-token

- 토큰 보낼 때 이렇게 해야됨
- 헤더 안에 Bearer 꼭 넣어야 됨
- headers: {
  'Content-Type': `application/json`,
  Authorization: 'Bearer ' + this.$store.state.userStore.token,
  },

try {
axios
.get('api/myinfo', {
headers: {
'Content-Type': `application/json`,
Authorization: 'Bearer ' + this.$store.state.userStore.token,
            },
          })
          .then(res => {
            console.log(res);
            if (res.status === 200) {
              // 로그인 성공시 처리해줘야할 부분
              console.log('유저 정보 가져오기 성공!');
              this.data.myEmail = res.data.my_email;
              this.data.myNickname = res.data.my_name;
              this.$store.commit('login', this.data);
}
});
} catch (error) {
console.log('에러');
console.error(error);
}

스크립트 부분

- 한글 카드 스크립트 할 때 ""로 카드 이름 표시하는 경우 있어서 json 양식 안 맞으니 수정할 것

vue router 같은 위치로 push하면서 params나 query 값을 변경하려하면 링크는 바뀌는 데 페이지가 변경이 안 됨
아래 링크에서 <router-view :key="$route.fullPath"></router-view> 로 해결
https://stackoverflow.com/questions/41301099/do-we-have-router-reload-in-vue-router
