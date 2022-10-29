import { Controller, Get } from '@nestjs/common';
import { CardsService } from './cards.service';

@Controller('cards')
export class CardsController {
  constructor(private cardsService: CardsService) {}

  @Get('/')
  async getCards() {
    return this.cardsService.getCards();
    // return 'Here is cards';
  }
}
