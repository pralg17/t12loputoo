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



  @ManyToOne
  @JoinColumn(name="rentija_email")
  public Rentija rentija;

  @Override
  public String toString(){
    return id+"-"+autonumber+"-"+mark+"-"+mudel+"-"+rentija.email+"; ";
  }
}
