import {Participant} from './Participant';
import {Registration} from './Registration';
import {State} from './State';
import {Location} from './Location';
import {Site} from './Site';

export class Pursuit {
  public nbPursuit: number;
  public name: string;
  public dateStart: string;
  public duration: number;
  public dateEnd: string;
  public nbMaxRegistrations: number;
  public description: string;
  public state: State;
  public urlPicture: string;
  public registrations: Registration[];
  public location: Location;
  public site: Site;
  public organizer: Participant;
}
