<template>
    <div>
        <div class="container">
            <form>
                <input type="text" placeholder="검색어를 입력하세요" autofocus>
                <button type="reset" class="btn-reset"></button>
            </form>
        </div>
        <card-item v-for="(card, index) in cards.data"
                :key="index" :card="card"/>
        <v-pagination
            v-model="currentPage"
            :length="lastPage"
            :total-visible="10"
            @input="getPage"
        ></v-pagination>
    </div>
</template>

<script>
import axios from 'axios';
import CardItem from './CardItem.vue';

export default {
    props: ['card'],
    components: {CardItem},
    data() {
        return {
            cards : null,
            currentPage : 10,
            lastPage : 0,
        }
    },
    mounted() {
        axios.get('http://localhost:8000/show')
        .then(response=>{
            console.log(response.data.cards);
            this.cards = response.data.cards
            this.currentPage = response.data.cards.current_page
            this.lastPage = response.data.cards.last_page
        })
        .catch (function (error) {
          console.error(error);
        })
    },
    methods: {
        getPage(value) {
            let url = 'http://localhost:8000/show?page=' + value
            axios.get(url)
            .then(response=>{
                console.log(response.data.cards);
                this.cards = response.data.cards
                this.currentPage = response.data.cards.current_page
                this.lastPage = response.data.cards.last_page
            })
            .catch (function (error) {
            console.error(error);
            })
        }
    }
}
</script>
