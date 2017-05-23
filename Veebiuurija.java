import java.io.IOException;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

public class Veebiuurija {
	String sisu;
	String aadress;
	int count = 0;

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
			sisu = doc.select("body").toString();
            String otsinguSona = "saab";

	        if(sisu.contains(otsinguSona)) {
                int count = sisu.length() - sisu.replaceAll(otsinguSona,"").length();
				//count / otsinguSona.length();
	        	System.out.println("Antud leht sisaldab tervet sõna või sõnaosa " + otsinguSona + " " + (count / otsinguSona.length()) + " korda.");
	        }
			
			else {
				System.out.println("Antud leht ei sisalda sõna sisalda " + otsinguSona);
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
