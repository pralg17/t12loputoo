package kent;

import javax.persistence.*;

@Entity
@Table(name="rendiautod")
public class Rendiauto{
  @Id
  @GeneratedValue
  public int id;
  public String autonumber;
  public String mark;
  public String mudel;
  public String rentija_email;


/*
  @ManyToOne
  @JoinColumn(name="rentija_email")
  public Rentija rentija;
*/
  @Override
  public String toString(){
    return id+"-"+autonumber+"-"+mark+"-"+mudel+"-"+rentija_email+"<br>; ";
  }
}
