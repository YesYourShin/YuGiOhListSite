import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { AppController } from './app.controller';
import { AppService } from './app.service';
import { Card } from './card/card.entity';
// import { CardRepository } from './card/card.repository';
import { CardsController } from './card/cards.controller';
import { CardsService } from './card/cards.service';

@Module({
  imports: [
    TypeOrmModule.forRoot({
      type: 'mysql',
      host: 'localhost',
      port: 3306,
      username: 'root',
      password: 'rootuser',
      database: 'yugiohtest',
      entities: [Card],
      synchronize: false,
    }),
    TypeOrmModule.forFeature([Card]),
  ],
  controllers: [AppController, CardsController],
  providers: [AppService, CardsService],
})
export class AppModule {}
