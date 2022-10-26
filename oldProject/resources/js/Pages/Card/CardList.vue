<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                CardList
            </h2>
        </template>
        <v-app>
            <v-container>
                <v-data-iterator
                    :items="cards"
                    :items-per-page="itemsPerPage"
                    :page.sync="currentPage"
                    :sort-by="sortBy.toLowerCase()"
                    :sort-desc="sortDesc"
                    hide-default-footer
                >
                    <template v-slot:header>
                        <v-toolbar dark color="blue darken-3" class="mb-1">
                            <v-text-field
                                v-model="search"
                                clearable
                                flat
                                solo-inverted
                                hide-details
                                prepend-inner-icon="mdi-magnify"
                                label="Search"
                            ></v-text-field>
                            <v-btn @click="getSearch()"> 検索 </v-btn>
                            <template v-if="$vuetify.breakpoint.mdAndUp">
                                <v-spacer></v-spacer>
                                <v-select
                                    v-model="sortBy"
                                    flat
                                    solo-inverted
                                    hide-details
                                    :items="keys"
                                    prepend-inner-icon="mdi-magnify"
                                    label="Sort by"
                                ></v-select>
                                <v-spacer></v-spacer>
                                <v-btn-toggle v-model="sortDesc" mandatory>
                                    <v-btn
                                        large
                                        depressed
                                        color="blue"
                                        :value="false"
                                    >
                                        <v-icon>mdi-arrow-up</v-icon>
                                    </v-btn>
                                    <v-btn
                                        large
                                        depressed
                                        color="blue"
                                        :value="true"
                                    >
                                        <v-icon>mdi-arrow-down</v-icon>
                                    </v-btn>
                                </v-btn-toggle>
                            </template>
                        </v-toolbar>
                    </template>

                    <template v-slot:default="props">
                        <v-row>
                            <v-col
                                v-for="card in props.items"
                                :key="card.id"
                                cols="12"
                                sm="6"
                                md="4"
                                lg="3"
                            >
                                <v-card>
                                    <v-card-title>
                                        <Link :href="'show/' + card.id">
                                            {{ card.title }}
                                        </Link>
                                    </v-card-title>
                                </v-card>
                            </v-col>
                        </v-row>
                    </template>

                    <template v-slot:footer>
                        <v-row class="mt-2" align="center" justify="center">
                            <v-pagination
                                v-model="currentPage"
                                :length="lastPage"
                                :total-visible="10"
                                @input="getPage"
                            />
                        </v-row>
                    </template>
                </v-data-iterator>
            </v-container>
        </v-app>
    </app-layout>
</template>

<script>
import axios from "axios";
import AppLayout from "@/Layouts/AppLayout";
import { Link } from "@inertiajs/inertia-vue";
// import CardItem from './CardItem.vue';

export default {
    components: { Link, AppLayout },
    data() {
        return {
            cards: [],
            currentPage: null,
            lastPage: 0,
            itemsPerPage: null,
            search: "",
            search1: "",
            filter: {},
            sortBy: "title",
            sortDesc: false,
            // keys: ['title', 'effect', 'pEffect', 'icon', 'attribute',
            //         'level', 'rank', 'pScale', 'link', 'monsterType', 'cardType',
            //         'atk', 'def', 'limited', ],
            keys: ["title"],
        };
    },
    mounted() {
        axios
            .get("http://localhost:8000/cardlistpage")
            .then((response) => {
                let res = response.data.response;
                this.cards = res.data;
                this.currentPage = res.current_page;
                this.lastPage = res.last_page;
                this.itemsPerPage = res.per_page;
            })
            .catch(function (error) {
                console.error(error);
            });
    },
    computed: {
        filteredKeys() {
            let array = this.keys.filter((key) => key !== "title");
            return array;
        },
    },
    methods: {
        getPage(value) {
            if (!this.search1) {
                let url = "http://localhost:8000/cardlistpage?page=" + value;
                axios
                    .get(url)
                    .then((response) => {
                        console.log(response);
                        let res = response.data.response;
                        this.cards = res.data;
                        this.currentPage = res.current_page;
                        this.lastPage = res.last_page;
                        this.itemsPerPage = res.per_page;
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            } else {
                let url =
                    "http://localhost:8000/search/" +
                    this.search1 +
                    "?page=" +
                    value;
                axios
                    .get(url)
                    .then((response) => {
                        let res = response.data;
                        this.cards = res.data;
                        this.currentPage = res.current_page;
                        this.lastPage = res.last_page;
                        this.itemsPerPage = res.per_page;
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            }
        },
        getSearch() {
            if (this.search == "") {
                alert("검색어를 입력해주세요.");
                return;
            }
            this.search1 = this.search;
            axios
                .get("http://localhost:8000/search/" + this.search1)
                .then((response) => {
                    let res = response.data;
                    this.cards = res.data;
                    this.currentPage = res.current_page;
                    this.lastPage = res.last_page;
                    this.itemsPerPage = res.per_page;
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
    },
};
</script>
