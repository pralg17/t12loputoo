import java.io.IOException;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

public class Veebiuurija {
	String sisu;
	String aadress;

	public Veebiuurija(String aadress) {
        this.aadress = aadress;
	}

	public void uuri() {
        uuriAadress(aadress);
	}

	public void uuriAadress(String url) {
		System.out.println("Uurib: "+url);
		aadress = url;

		try {
			Document doc = Jsoup.connect(aadress).get();
			sisu = doc.select(".eriline").toString();
            String otsinguSona = "sisalda";

	        if(sisu.contains(otsinguSona)) {
	        	System.out.println("Antud leht sisaldab sõna " + otsinguSona);
	        }

		} catch (IOException e) {
			e.printStackTrace();
		}
	}

	public static void main(String[] args) {
		Veebiuurija uurija = new Veebiuurija("http://www.tlu.ee/~brigid/veeb2016/");
		uurija.uuri();
	}
}

// javac -cp .;jsoup-1.8.2.jar Veebiuurija.java
// java -cp .;jsoup-1.8.2.jar Veebiuurija

// Uurib: http://www.tlu.ee/~brigid/veeb2016/
// Antud leht sisaldab sõna sisalda