package baas;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.beans.factory.annotation.Autowired;

@SpringBootApplication
@RestController
public class Rakendus{

    private final KasutajaData data;
    private final MarkmedData mdata;

    @Autowired
    public Rakendus(KasutajaData data, MarkmedData mdata){
        this.data = data;
        this.mdata= mdata;

    }

  @RequestMapping("/login")
  public String login(){
      StringBuilder stringBuffer = new StringBuilder();
      stringBuffer.append("<form action='/avaleht'>Kasutajatunnus: <input type='text' name='kasutajatunnus'><br>Parool: <input type='text' name='parool'><br><input type='submit' value='Sisene'></form>");
      return stringBuffer.toString();
  }

  @RequestMapping("/avaleht")
  public String avaleht(String kasutajatunnus, String parool, String marge1){
    StringBuilder stringBuffer = new StringBuilder();

    for(Kasutaja kasutaja: data.findAll()){
        if(kasutaja.getKasutajanimi().equals(kasutajatunnus) && kasutaja.getParool().equals(parool)){
          stringBuffer.append("<p><h2>Tere "+ kasutajatunnus + "</h2></p><p>Siin on sinu märkmed: </p>");
          if(marge1 != null && !marge1.isEmpty()){
            Markmed m1 = new Markmed(kasutaja, marge1);
            mdata.save(m1);
          }
          for(Markmed marge: mdata.findAll()){
            if(marge.getKasutajanimi().getKasutajanimi().equals(kasutaja.getKasutajanimi())){
              stringBuffer.append("<p>"+ marge.getMarkmed() + "</p>");
            }
          }
          stringBuffer.append("<h3>Lisa endale mõni märge:</h3><form action='/avaleht'><input type='hidden' name='kasutajatunnus' value=" + kasutajatunnus + "><br><input type='hidden' name='parool' value="+ parool +"><br><input type='text'name='marge1'><input type='submit' value='Lisa'></form>");
        }else{
          stringBuffer.append("Palun kontrolli sisestatud andmeid");
        }
    }
      return stringBuffer.toString();
  }

  public static void main(String[] args) {
    System.getProperties().put("server.port", "1720");
    System.getProperties().put("spring.datasource.url", "jdbc:mysql://localhost:3306/if16_karroo?useSSL=false");
    System.getProperties().put("spring.datasource.maxActive", "2");
    System.getProperties().put("spring.datasource.username", "if16");
    System.getProperties().put("spring.datasource.password", "ifikad16");
		SpringApplication.run(Rakendus.class);
	}
}
