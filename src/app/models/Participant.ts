export class Participant {
  constructor(
    public pseudo: string,
    public lastName: string,
    public firstName: string,
    public phone: string,
    public mail: string,
    public admin: boolean,
    public active: boolean,
    public site: object,
    public registrations: object
  ) { }
}
