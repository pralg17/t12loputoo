package karin;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.RequestMapping; 
import org.springframework.web.bind.annotation.RestController;
import org.springframework.beans.factory.annotation.Autowired;
import java.util.*;


@RestController
@SpringBootApplication
//@Controller
public class Veebirakendus {
	@Autowired
    private TeekondRepo haldur; 
	
	
	@RequestMapping("/algus")
    String tervitusfunktsioon() {
        return "Ahoi!";
    }

	@RequestMapping("/lisateekond")          //lisateekond
	int sisestaTeekond(){ 
		int id = 0;
		try{
			Teekond t = new Teekond();
			haldur.save(t);
			id = t.getId();	
		} catch (Exception ex){}
		return id;
	}
	
	@RequestMapping("/lisakiirus")          //lisakiirus?kiirus=100&id=1
	double sisestaAjaArvutamiseksKiirus(double kiirus, int id){
		Teekond t = haldur.findOne(id);
		if(t != null){
			t.setKiirus(kiirus);
			t.getKiirus();
			haldur.save(t);
			if(t.marsruut.size() > 1){
				t.setTeekonnaPikkus();
				t.getTeekonnaPikkus();
				haldur.save(t);
				t.setAegKokku();
				t.getAegKokku();
				haldur.save(t);
				t.setKellaAjad();
				t.getKellaAjad(); 
				haldur.save(t);	
			}
		} 
		return kiirus;
	}
	//lisastart2?id=2&aasta=2017&kuu=5&kuupäev=28&tund=13&minut=45
	@RequestMapping("/lisastart2")
	void teekonnaAlgusAeg(int id, int aasta, int kuu, int kuupäev, int tund, int minut){
		try{
			Teekond t = haldur.findOne(id);
				if(t != null){
					t.stardiAeg2(aasta, kuu, kuupäev, tund, minut);
					haldur.save(t);	
				}
		} catch (Exception ex){
			//return "Viga: "+ex.getMessage();
		}
	}
	
	@RequestMapping("/lisakoht")      //lisakoht?andmed=tallinn&id=2
	String sisestaKoht(String andmed, int id){  
		String kohaNimi = "";
		Koht k = null;
		Teekond t = haldur.findOne(id);  //koht lisatakse vastava id-ga teekonda
			if(t != null){
				String[] stringimassiiv = andmed.split(",");
				if(stringimassiiv != null && stringimassiiv.length > 0){         
					if(stringimassiiv.length == 1 && stringimassiiv[0].length() > 2){   
						k = new Koht(andmed);   // uus koht xml-st
					} 
					if(stringimassiiv.length == 3){       //kohanimi, lat, lot
						try{
							String nimetus = stringimassiiv[0].trim();
							double lat = Double.valueOf(stringimassiiv[1].trim());
							double lon = Double.valueOf(stringimassiiv[2].trim());
							if((lat > -91) && (lat < 91) && (lon > -181) && (lon < 180) ){
								k = new Koht(nimetus, lat, lon);  //uus koht koordinaatide järgi
							}
						} catch (Exception ex) {}	
					}
					if(k != null){
						kohaNimi = k.nimi;
						t.setKoht(k);    //OneToMany  lisab teekonna tabelis asukoha marsruudi listi
						k.setTeekond(t);  //ManyToOne, koha tabelis foreign key antud teekonna id
						
						
						t.setTeekonnaPikkus();
						t.getTeekonnaPikkus();
						t.setAegKokku();
						t.getAegKokku();
						t.setKellaAjad();
						t.getKellaAjad(); 
					
						haldur.save(t);
					} else {
						kohaNimi = "Koha andmed valesti lisatud.";
					}
				} 
			}else {
				kohaNimi = "Loo uus teekond alguses.";
			}
		return kohaNimi;
	}
	
	@RequestMapping("/andmed")
	public String kysiAndmed(){
		Iterable <Teekond> teekonnad = haldur.findAll();
		StringBuffer sb = new StringBuffer();
		for(Teekond t: teekonnad){
			sb.append("<tr><td><button onclick=\"kustuta(" + t.tk_id + ")\">X</button></td>");
			sb.append("<td>" + t.kiirus + " km/h </td>");
			if(t.teekonnaPikkus == 0){
				sb.append("<td>0 km </td>");
			}else {
			    sb.append("<td>" + t.teekonnaPikkus + " km </td>");
			}
			if(t.aeg_kokku == null){
				sb.append("<td>0</td>");
			} else {
				sb.append("<td>" + t.aeg_kokku + "</td>");
			}
			if(t.kellIgasPunktis == null){
				sb.append("<td>0</td>");
			} else {
				sb.append("<td>" + t.kellIgasPunktis + "</td>");
			}
			sb.append("<td><button onclick=\"muudaId(" + t.tk_id + ")\">Vali</button></td> </tr>");

		}
		return sb.toString();
	
	}
	
	@RequestMapping("/kustuta")
	public void kustutaTeekond(int id){
		Teekond t = haldur.findOne(id);
		if(t != null){
			haldur.delete(t);
		}
	}
	
	public static void main(String[] args) {
		System.getProperties().put("server.port", 2412);
        SpringApplication.run(Veebirakendus.class, args);
    }
}

//scl enable rh-maven33 bash
//mvn package && java -jar target/kaugused-1.0-SNAPSHOT.jar
//java -jar target/kaugused-1.0-SNAPSHOT.jar
