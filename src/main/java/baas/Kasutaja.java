package baas;
import javax.persistence.*;

@Entity
@Table(name="kasutajad1")
public class Kasutaja{
	@Id
  @GeneratedValue
  public Integer id;
	public String kasutajanimi;
  public String parool;

	public Kasutaja(){}

  public String getKasutajanimi(){
    return kasutajanimi;
}

 	public String getParool(){
 		return parool;
 	}

	public Integer getId(){
 		return id;
 	}
}
