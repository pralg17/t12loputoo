package martin;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.RequestMapping; 
import org.springframework.web.bind.annotation.RestController;
import org.springframework.beans.factory.annotation.Autowired;
import java.util.*;

@RestController
@SpringBootApplication

public class Rakendus{	
	@Autowired
	private BookManager bookmanager;
	
	
	//Otsingu koostamine
	@RequestMapping("/find")
	String find(String title){
		if(title == null){
			return "tyhi pealkiri";
		}
		raamatud raamat = bookmanager.findOne(title);
		if(raamat == null){
			return "sellist pealkirja pole";
		}
		return "pealkiri  " + title + "  author  " + raamat.author + "aasta"+ raamat.year +  "  ISBN  " + raamat.isbn + " koide "+ raamat.binding + " valjastaja " + raamat.publisher + " zanr "+ raamat.zanr;
	}	
	
	//Total 
	@RequestMapping("/total")
	public String total(){
		return "Andmebaasis on " + bookmanager.count() + " tulemust";
	}
	
	
	
	//K6igi raamatute n2gemine
	@RequestMapping("/showAll")
	public String all(){
		String data_string = "";
		int index = 0;
		for(raamatud raamat : bookmanager.findAll()){
			index += 1;
			data_string = data_string + index + " " + " " + raamat.title + " " + raamat.author +" " + raamat.year+ " " + raamat.isbn +" "+raamat.binding +" " + raamat.publisher + " " + raamat.zanr ;
			data_string += "</br>";
			}
			return data_string;
	}
	
	
	
	//Uue raamatu lisamine	
	@RequestMapping("/addNewBook")
	public String new_book(String title, String author, int year, int isbn, String binding, String publisher, String zanr){
		if(title == null || author == null || year ==0 || isbn == 0 || binding == null || publisher == null || zanr == null){
			return "t2ida detailid";
			}	
			raamatud n_raamatud = new raamatud();
			n_raamatud.title = title;
			n_raamatud.author = author;
			n_raamatud.year = year;
			n_raamatud.isbn = isbn;
			n_raamatud.binding = binding;
			n_raamatud.publisher = publisher;
			n_raamatud.zanr = zanr;
			bookmanager.save(n_raamatud);
			return "Lisatud on raamat " + title;
	}
	
	
	//raamatu kustutamine deleteBook?title=1984	
	@RequestMapping("/deleteBook")
	public String deleted_book(String title){
		if(title == null){
			return "sisesta pealkiri mida kustutada";
				
			}
			raamatud raamat = bookmanager.findOne(title);
			if(raamat == null){
				return "raamatut ei ole olemas";

			}
			bookmanager.delete(raamat);
			return title + " on eemaldatud andmebaasist";
	}
		
	//mysql ja port
	public static void main(String[] args){
		System.getProperties().put("server.port", 2459);
		System.getProperties().put("spring.datasource.url", "jdbc:mysql://localhost:3306/if16_martkasa");
		System.getProperties().put("spring.datasource.username", "if16");
		System.getProperties().put("spring.datasource.password", "ifikad16");
		SpringApplication.run(Rakendus.class);
	}
}



//http://greeny.cs.tlu.ee:2459/find
//&peakiri=pealkiri
//scl enable rh-maven33 bash
//mvn package
//java -jar target/boot-1.jar