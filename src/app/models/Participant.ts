export class Participant {
  public nbParticipant: number;
  public pseudo: string;
  public lastName: string;
  public firstName: string;
  public phone: string;
  public mail: string;
  public admin: boolean;
  public active: boolean;
  public site: object;
  public registrations: object;
  // Only used in case of password update so there is no place in constructor for this
  public password: string;
}
