import {
  EntityRepository,
  getConnection,
  getRepository,
  Repository,
} from 'typeorm';
import { Card } from './card.entity';

// @EntityRepository(Card)
// export class CardRepository extends Repository<Card> {
//   async getAllCards() {
//     // const query = getConnection()
//     //   .createQueryBuilder()
//     //   .from(Card, 'c')
//     //   .select(['*']);

//     // return await query.getMany();
//     return 'success';
//   }
// }

// const cardRepository = DataSource.getRepository(Card)
