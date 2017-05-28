package kuznetsovatatjana;


import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@SpringBootApplication

public class Rakendus {

	
	@RequestMapping("/kuuppindala")
	public String kuuppindala(String a){
		double andmed = Double.parseDouble(a);
		IArvutused kuup = new Kuup(andmed);
		   return "Kuubi kant on "+andmed+" ja pindala on  " + kuup.arvutaPindala();
		}
	
	@RequestMapping("/kuupruumala")
	public String kuupruumala(String a){
		double andmed = Double.parseDouble(a);
		IArvutused kuup = new Kuup(andmed);
		   return "Kuubi kant on "+andmed+" ja ruumala on  " + kuup.arvutaRuumala();
		}
	
	@RequestMapping("/kerapindala")
	public String kerapindala(String a){
		double andmed = Double.parseDouble(a);
		IArvutused kera = new Kera(andmed);
		   return "Kera raadius on "+andmed+" ja pindala on  " + kera.arvutaPindala();
		}
	
	@RequestMapping("/keraruumala")
	public String keraruumala(String a){
		double andmed = Double.parseDouble(a);
		IArvutused kera = new Kera(andmed);
		   return "Kera raadius on "+andmed+" ja ruumala on  " + kera.arvutaRuumala();
		}
	

    public static void main(String[] args) {
		System.getProperties().put("server.port", 5678);
        SpringApplication.run(Rakendus.class);

	}

}
