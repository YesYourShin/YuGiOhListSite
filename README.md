# YuGiOhListSite

## 目次
1. [YuGiOh Site](#1-yugioh-site)  
    1.1. [概要](#11-概要)  
    1.2. [Page](#12-page)  
    ㅤ1.2.1. [CardList](#121-cardlist)  
    ㅤ1.2.2. [MyCardList](#122-mycardlist)  
    ㅤ1.2.3. [OricaList](#123-oricalist)  
    ㅤ1.2.4. [MyOricaList](#124-myoricalist)  
    ㅤ1.2.5. [CardDetail](#125-carddetail)  
2. [YuGiOh-crawler](#2-yugioh-crawler)  
3. [DataInsert](#3-datainsert)  

---
## 1. YuGiOh Site

---
### 1.1. 概要
遊戯王カードの所持状況を簡単に把握＆管理できるサイト

---
### 1.2. Page

---
### 1.2.1. CardList
![image](https://user-images.githubusercontent.com/53047744/172505709-71cf2fd8-db1a-41b2-893d-2ebea0c39149.png)  
すべての遊戯王カードのリスト 

---
### 1.2.2. MyCardList
![image](https://user-images.githubusercontent.com/53047744/172506031-a7c7c2d2-3f9d-46f1-aa1f-5b8a87096f8d.png)  
自分が所持しているカードのリスト 

---
### 1.2.3. OricaList
![image](https://user-images.githubusercontent.com/53047744/172506385-c06f1de5-7565-4ee2-88e5-ddd2785293c0.png)  
すべてのオリジナルカードのリスト 

---
### 1.2.4. MyOricaList
![image](https://user-images.githubusercontent.com/53047744/172506431-6186211e-8cdc-459f-a338-1c70546b261f.png)  
自分が作ったオリジナルカードのリスト 

---
### 1.2.5 CardDetail 
![image](https://user-images.githubusercontent.com/53047744/172506644-fa65c0a3-3c60-4ba7-806d-4e233fa528ff.png)  
カードをクリックするとカードの情報ページに移動 

---
## 2. YuGiOh-crawler
YuGiOh公式 CARD DBサイトhttps://www.db.yugioh-card.com/yugiohdb/?request_locale=ja  

cheerioを利用して必要なデータだけを出力する  
ページのカードのidを出力  
カードのidを使ってカードの情報を出力  

---
## 3. DataInsert
YuGiOh-crawlerで出力されたデータをmysqlにInsert

---
