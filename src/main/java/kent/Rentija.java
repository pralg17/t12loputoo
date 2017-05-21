
package kent;

import javax.persistence.*;

@Entity
@Table(name="rentijad")
public class Rentija{
  @Id
  public String email;
  public int rentimisi;

  @OneToMany(mappedBy="rentija")
  public java.util.Set<Rendiauto> rendiautod;

  @Override
  public String toString(){
    return email+"-"+rentimisi+"; ";
  }
}
