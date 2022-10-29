import {
  BaseEntity,
  Column,
  Entity,
  PrimaryColumn,
  PrimaryGeneratedColumn,
} from 'typeorm';

@Entity()
export class Card extends BaseEntity {
  @PrimaryGeneratedColumn()
  id: number;

  @Column()
  title: string;

  @Column()
  title2: string;

  @Column()
  limited: string;

  @Column()
  icon: string;

  @Column()
  attribute: string;

  @Column()
  level: string;

  @Column()
  rank: string;

  @Column()
  link: string;

  @Column()
  atk: string;

  @Column()
  def: string;

  @Column()
  monsterType: string;

  @Column()
  cardType: string;

  @Column()
  pScale: string;

  @Column()
  pEffect: string;

  @Column()
  cardText: string;
}
