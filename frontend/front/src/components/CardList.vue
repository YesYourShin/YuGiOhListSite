<template>
    <div>
        <card-item v-for="(card, index) in cards.data"
                :key="index" :card="card"/>
        <!-- {{cards}} -->
        <!-- <pagination @pageClicked="getPage($event)"
            v-if="cards.links != null" :links="cards.links"/> -->
    </div>
</template>

<script>
import axios from 'axios';
import CardItem from './CardItem.vue';
// import Pagination from './Pagination.vue';

export default {
    props: ['card'],
    components: {CardItem},
    data() {
        return {
            cards : null,
        }
    },
    mounted() {
        axios.get('http://localhost:8000/show')
        .then(response=>{
            console.log(response.data.cards);
            this.cards = response.data.cards
        })
        .catch (function (error) {
          console.error(error);
        })
    },
    methods: {
        getPage(url) {
            console.log(url);
            axios.get(url)
            .then(response=>{
                this.cards = response.data;
            })
            .catch(error=>{
                console.log(error);
            });
        },
    }
}
</script>
