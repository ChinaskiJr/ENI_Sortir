import {Participant} from './Participant';
import {Registration} from './Registration';

export class Pursuit {
  public nbPursuit: number;
  public name: string;
  public dateStart: Date;
  public duration: number;
  public dateEnd: Date;
  public nbMaxRegistrations: number;
  public description: string;
  public state: object;
  public urlPicture: string;
  public registrations: Registration[];
  public location: object;
  public site: object;
  public organizer: Participant;
}
