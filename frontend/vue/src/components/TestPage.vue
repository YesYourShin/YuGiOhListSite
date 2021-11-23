<template>
  <v-container fluid>
    <v-data-iterator
      :items="cards"
      :items-per-page.sync="itemsPerPage"
      :page.sync="currentPage"
      :search="search"
      :sort-by="sortBy.toLowerCase()"
      :sort-desc="sortDesc"
      hide-default-footer
    >
      <template v-slot:header>
        <v-toolbar
          dark
          color="blue darken-3"
          class="mb-1"
        >
          <v-text-field
            v-model="search"
            clearable
            flat
            solo-inverted
            hide-details
            prepend-inner-icon="mdi-magnify"
            label="Search"
          ></v-text-field>
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
            <v-btn-toggle
              v-model="sortDesc"
              mandatory
            >
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
            :key="card.title"
            cols="12"
            sm="6"
            md="4"
            lg="3"
          >
            <v-card>
                            <v-card-title><router-link to="/">{{ card.title }}</router-link></v-card-title>
<v-divider></v-divider>

              <v-list dense>
                <v-list-item
                  v-for="(key, index) in filteredKeys"
                  :key="index"
                >
                  <v-list-item-content :class="{ 'blue--text': sortBy === key }">
                    {{ key }}:
                  </v-list-item-content>
                  <v-list-item-content
                    class="align-end"
                    :class="{ 'blue--text': sortBy === key }"
                  >
                    {{ card[key.toLowerCase()] }}
                  </v-list-item-content>
                </v-list-item>
              </v-list>
            </v-card>
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
</template>

<script>

import axios from 'axios';
  export default {
    data () {
      return {
         cards : [],
            currentPage : null,
            lastPage : 0,
            itemsPerPage : null,
            search: '',
            filter: {},
            sortBy: 'title',
            sortDesc: false,
            keys: ['title', 'effect']
      }
    },
    computed: {
      filteredKeys () {
        return this.keys.filter(key => key !== 'Name')
      },
    },
    mounted() {
        axios.get('http://localhost:8000/show')
        .then(response=>{
            console.log(response.data.cards.data);
            this.cards = response.data.cards.data
            this.currentPage = response.data.cards.current_page
            this.lastPage = response.data.cards.last_page
            this.itemsPerPage = response.data.cards.per_page
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
    },
  }
</script>