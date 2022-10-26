<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                カードの詳細ページ
            </h2>
        </template>
        <v-card class="mx-auto my-12" max-width="374">
            <template slot="progress">
                <v-progress-linear
                    color="deep-purple"
                    height="10"
                    indeterminate
                ></v-progress-linear>
            </template>
            <v-card-text>
                <div>{{ card.title2 }}</div>

                <v-card-title>{{ card.title }}</v-card-title>

                <!-- <v-card-text> -->
                <div v-if="card.icon">
                    {{ card.icon }}
                </div>
                <div v-if="card.attribute">属性 : {{ card.attribute }}</div>
                <div v-if="card.level"><br />レベル : {{ card.level }}</div>
                <div v-if="card.rank"><br />ランク : {{ card.rank }}</div>
                <div v-if="card.pScale">
                    <br />ペンデュラムスケール : {{ card.pScale }}
                </div>
                <div v-if="card.link"><br />リンク : {{ card.link }}</div>
                <div v-if="card.pEffect">
                    <br />ペンデュラム効果 <br />
                    {{ card.pEffect }}
                </div>
                <div class="my-4 text-subtitle-1" v-if="card.cardType">
                    {{ card.monsterType }} • {{ card.cardType }}
                </div>
                <div>テキスト : <br />{{ card.cardText }}</div>

                <v-divider class="mx-4"></v-divider>

                <div v-if="card.atk">攻撃力 {{ card.atk }}</div>
                <div v-if="card.def">守備力 {{ card.def }}</div>
            </v-card-text>

            <v-card-text v-if="card.limited">
                <v-chip>{{ card.limited }}</v-chip>
            </v-card-text>

            <v-card-actions>
                <v-form ref="form" v-model="valid">
                    <v-text-field
                        v-model="number"
                        :counter="5"
                        label="所持枚数"
                        :rules="numberRules"
                        required
                    ></v-text-field>
                </v-form>

                <v-btn
                    v-if="check == false"
                    :disabled="!valid"
                    color="deep-purple lighten-2"
                    text
                    @click="addCollection"
                >
                    追加する
                </v-btn>
                <v-btn
                    v-if="check == true"
                    :disabled="!valid"
                    color="deep-purple lighten-2"
                    text
                    @click="editCollection"
                >
                    変更する
                </v-btn>
                <v-btn
                    v-if="check == true"
                    color="deep-purple lighten-2"
                    text
                    @click="deleteCollection"
                >
                    削除する
                </v-btn>
            </v-card-actions>
        </v-card>
    </app-layout>
</template>

<script>
import axios from "axios";
import AppLayout from "@/Layouts/AppLayout";
export default {
    components: { AppLayout },
    props: ["response", "id"],
    data() {
        return {
            valid: true,
            card: "",
            number: "",
            number1: "",
            check: false,
            numberRules: [
                (v) => !!v || "",
                (v) => v != this.number1 || "",
                (v) =>
                    v.length <= 5 ||
                    v.length == undefined ||
                    "5桁を超えることはできません。",
                (v) => v > 0 || "有効な値を入力してください。",
            ],
        };
    },
    mounted() {
        this.card = this.response;
        axios
            .get("http://localhost:8000/collectionshow/" + this.card.id)
            .then((response) => {
                if (response.data.collection) {
                    this.number = response.data.collection.number;
                    this.number1 = response.data.collection.number;
                    this.check = true;
                }
            })
            .catch(function (error) {
                console.error(error);
            });
    },
    methods: {
        addCollection() {
            if (this.number == null) {
                alert("所持しているカードの枚数を入力してください。");
                return;
            }
            this.number1 = this.number;
            axios
                .post("http://localhost:8000/collectioninsert", {
                    title: this.card.title,
                    number: this.number,
                    card_id: this.card.id,
                })
                .then((response) => {
                    alert("カードを追加しました。");
                    location.href =
                        "http://localhost:8000/show/" + this.card.id;
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
        editCollection() {
            axios
                .patch(
                    "http://localhost:8000/collectionupdate/" + this.card.id,
                    { number: this.number, card_id: this.card.id }
                )
                .then((response) => {
                    alert("カードの枚数を変更しました。");
                    location.href =
                        "http://localhost:8000/show/" + this.card.id;
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
        deleteCollection() {
            axios
                .delete(
                    "http://localhost:8000/collectiondestroy/" + this.card.id
                )
                .then((response) => {
                    alert("カードを削除しました。");
                    location.href =
                        "http://localhost:8000/show/" + this.card.id;
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
    },
};
</script>
