package baas;
import javax.persistence.*;

@Entity
@Table(name="markmed")
public class Markmed{
	@Id
  @GeneratedValue
  public Integer id;
  @ManyToOne
  @JoinColumn(name = "kasutajanimi")
	public Kasutaja kasutajanimi;
  public String markmed;

	public Markmed(){}

  public Markmed(Kasutaja kasutajanimi, String markmed){
    this.kasutajanimi = kasutajanimi;
    this.markmed = markmed;
  }

  public Kasutaja getKasutajanimi(){
    return kasutajanimi;
  }
  public String getMarkmed(){
    return markmed;
  }


}
