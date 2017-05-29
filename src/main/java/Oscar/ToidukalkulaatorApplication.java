package Oscar;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.RequestMapping; 
import org.springframework.web.bind.annotation.RestController;
import org.springframework.beans.factory.annotation.Autowired;

@RestController
@SpringBootApplication
public class ToidukalkulaatorApplication {

	@Autowired
	private ToituaineDao toituaineDao;

	@RequestMapping("/lisa")
	String lisa(String toiduaine, double kalorid, double valk, double rasv, double sysivesikud){
		Toituaine uustoit = new Toituaine();
        uustoit.Toituaine(toiduaine, kalorid ,valk ,rasv ,sysivesikud);
		toituaineDao.save(uustoit);
		return "Toit lisatud: "+ uustoit.toiduaine;
	}
	@RequestMapping("/leia")
	String leia(String toiduaine, double kogus){
		Toituaine toit = toituaineDao.findByToiduaine(toiduaine);
		if(toit != null ){
			Toidukogus uustoitkogus = new Toidukogus();
			uustoitkogus.Toidukogus(toiduaine, kogus, toit.valk*kogus, toit.sysivesikud*kogus, toit.rasv*kogus, toit.kalorid*kogus);
			return "Toiduaine "+toit.toiduaine+" sisaldab "+kogus+" grammi kohta: "+"<br>"+
			"Kaloreid: "+toit.kalorid*kogus+"<br>"+
			"Sysivesikuid: "+toit.sysivesikud*kogus+"<br>"+
			"Valke: "+toit.valk*kogus+"<br>"+
			"Rasve: "+toit.rasv*kogus+"<br>"+
			"Nimi: "+uustoitkogus+"<br>";
		}
		return "Sellist toiduainet ei ole andmebaasis";
	}

	public static void main(String[] args) {
		System.getProperties().put("server.port", 49891);
		SpringApplication.run(ToidukalkulaatorApplication.class, args);
	}
}

//scl enable rh-maven33 bash
//mvn package
//java -jar target/Toidukalkulaator-0.0.1-SNAPSHOT.jar
//greeny.cs.tlu.ee:49891/lisa?toiduaine=banaan&kalorid=21&valk=5&rasv=3&sysivesikud=6
//greeny.cs.tlu.ee:49891/leia?toiduaine=banaan&kogus=100
//greeny.cs.tlu.ee:49891/home.html