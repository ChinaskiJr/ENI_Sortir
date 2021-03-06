import {Site} from './Site';
import {Registration} from './Registration';

export class Participant {
  public nbParticipant: number;
  public pseudo: string;
  public lastName: string;
  public firstName: string;
  public phone: string;
  public mail: string;
  public admin: boolean;
  public active: boolean;
  public site: Site;
  public registrations: Registration[];
  // Only used in case of password update so there is no place in constructor for this
  public password: string;
  public urlPicture: string;
}
