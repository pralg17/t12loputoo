package kent;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.beans.factory.annotation.Autowired;

@RestController
@SpringBootApplication
public class Rakendus {
    @Autowired
    private RentijaDao rentijaDao;
    @Autowired
    private RendiautoDao rendiautoDao;

	@RequestMapping("/algus")
    String tervitusfunktsioon() {
        return "Ahoi!";
    }
    @RequestMapping("/leia")
	String leia(String email){
	   Rentija isik=rentijaDao.findOne(email);
	   return email+" rentimisi "+isik.rentimisi;
	}

    @RequestMapping("/lisa")
	String lisa(String email){
	   Rentija isik=new Rentija();
	   isik.email=email;
	   isik.rentimisi=1;
	   rentijaDao.save(isik);
	   return "Lisatud "+email;
	}

    @RequestMapping("/suurenda")
	String suurenda(String email){
	   Rentija isik=rentijaDao.findOne(email);
	   isik.rentimisi++;
	   rentijaDao.save(isik);
	   return email+": "+isik.rentimisi;
	}

  @RequestMapping("/rent")
String rent(String email, String autonumber, String mark, String mudel){
   Rendiauto auto= new Rendiauto();
   Rentija isik=rentijaDao.findOne(email);
   isik.email=email;
   isik.rentimisi++;
   auto.autonumber=autonumber;
   auto.mark=mark;
   auto.mudel=mudel;
   rendiautoDao.save(auto);
   rentijaDao.save(isik);
   return isik.email+auto.autonumber;
}

	@RequestMapping("/loetelu2")
	public String loetelu2(){
	  StringBuffer sb=new StringBuffer();
	  for(Rentija isik: rentijaDao.findAll()){
	     sb.append(isik);
	  }
	  return sb.toString();
	}
/*
  @RequestMapping("/loetelu4")
	public String loetelu3(){
	  StringBuffer sb=new StringBuffer();
	  for(Rendiauto auto: rendiautoDao.findAll()){
	     sb.append(auto);
	  }
	  return sb.toString();
	}

  @RequestMapping("/loetelu")
	public String loetelu(){
	  StringBuffer sb=new StringBuffer();
	  for(Rentija isik: rentijaDao.findAll()){
	     sb.append(isik);
	  }
	  return sb.toString();
	}




/*
	@RequestMapping("/loetelu3")
	public Set<Rendiauto> loetelu3(String email){
       rentijaDao.findOne(email).Rendiauto();
	}



	@RequestMapping("/kustuta")
	public String kustuta(String email){
	    Lugeja isik=lugejaDao.findOne(email);
		lugejaDao.delete(isik);
		return email+" kustutatud";
	}
*/
	@RequestMapping("/kogus")
	public long kogus(String email){
	   return rentijaDao.count();
	}

    public static void main(String[] args) {
		System.getProperties().put("server.port", 4302);
        SpringApplication.run(Rakendus.class, args);
    }
}
