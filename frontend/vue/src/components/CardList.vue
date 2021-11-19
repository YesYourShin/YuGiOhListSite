<template>
    <div>
        <v-container>
            <v-data-iterator
                :items="cards"
                :items-per-page="itemsPerPage"
                :page.sync="currentPage"
                :server-items-length.sync="lastPage"
                hide-default-footer
            >
                <template v-slot:default="props">
                    <v-row>
                        <v-col
                            v-for="card in props.items"
                            :key="card.title"
                            cols="12"
                            sm="6"
                            md="4"
                            lg="3"
                        >
                            <v-card>
                                <v-card-title><router-link to="/">{{ card.title }}</router-link></v-card-title>
                            </v-card>
                            <v-divider></v-divider>
                        </v-col>
                    </v-row>
                </template>
                <template v-slot:footer>
                    <v-row
                        class="mt-2"
                        align="center"
                        justify="center"
                    >
                        <v-pagination
                            v-model="currentPage"
                            :length="lastPage"
                            :total-visible="10"
                            @input="getPage"/>
                    </v-row>
                </template>
            </v-data-iterator>
        </v-container>

        <!-- <card-item v-for="(card, index) in cards.data"
                    :key="index" :card="card"/> -->
        <!-- <v-pagination
            v-model="currentPage"
            :length="lastPage"
            :total-visible="10"
            @input="getPage"/> -->

    </div>
</template>

<script>
import axios from 'axios';
// import CardItem from './CardItem.vue';

export default {
    props: ['card'],
    // components: {CardItem},
    data() {
        return {
            // cards : null,
            cards : [],
            currentPage : 10,
            lastPage : 0,
            itemsPerPage : null,
        }
    },
    mounted() {
        axios.get('http://localhost:8000/show')
        .then(response=>{
            console.log(response.data.cards);
            this.cards = response.data.cards.data
            this.currentPage = response.data.cards.current_page
            this.lastPage = response.data.cards.last_page
            this.itemsPerPage = response.data.cards.per_page
        })
        .catch (function (error) {
            console.error(error);
        })
        axios.post('http://localhost:8000/login', {email: 'testtest@naver.com', password: 'testtest'})
        .then(response=>{
            console.log(response);
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
                // this.cards = response.data.cards
                this.cards = response.data.cards.data
                this.currentPage = response.data.cards.current_page
                this.lastPage = response.data.cards.last_page
                this.itemsPerPage = response.data.cards.per_page
            })
            .catch (function (error) {
                console.error(error);
            })
        },
    }
}
</script>
