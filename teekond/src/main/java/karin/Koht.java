package karin;

import java.io.*;
import java.net.*;
import java.io.File;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.persistence.*;

import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;

@Entity
@Table(name="koht")
public class Koht{
	
	@Id                                    
	@GeneratedValue(strategy=GenerationType.AUTO)
	int koht_id;
	String nimi;
	double latKraadides;  
	double lonKraadides;   
	double lat;  //radiaanid
	double lon; //radiaanid
	@ManyToOne
	@JoinColumn(name="tk_id")
	Teekond teekond;
	
	//KONSTRUKTORID
	public Koht(){}
	
	public Koht(String nimi, double lat, double lon){  
		this.nimi = nimi;
		this.latKraadides = lat;
		this.lonKraadides = lon;
		this.lat = Math.toRadians(lat);
		this.lon = Math.toRadians(lon);
	}

	public Koht(String nimi){  //xml failist
		this(nimi, leiaKoordinaadid(nimi)[0], leiaKoordinaadid(nimi)[1]);
	}
	
	//setter
	public void setTeekond(Teekond t){
		teekond = t;
	}
	
	//getter
	public Teekond getTeekond(){
		return teekond;
	}
	
	//STATIC   lat ja lon veebidokumendist
	public static double[] leiaKoordinaadid(String kohaNimi){
		double[] koordinaadid = new double[2];
		String aadress = "http://maps.googleapis.com/maps/api/geocode/xml?address=";
		
		try{
			kohaNimi = URLEncoder.encode(kohaNimi, "UTF-8");
			URL url = new URL(aadress + kohaNimi);
			URLConnection yhendus = url.openConnection();
			InputStream in = new BufferedInputStream(yhendus.getInputStream());
			DocumentBuilderFactory dbFactory = DocumentBuilderFactory.newInstance();
			DocumentBuilder dBuilder = dbFactory.newDocumentBuilder();
			Document dokument = dBuilder.parse( in );
			dokument.getDocumentElement().normalize();
			NodeList location = dokument.getElementsByTagName("location");
			Node loc = location.item(0);
			Element e = (Element)loc;
			String lat = e.getElementsByTagName("lat").item(0).getTextContent();
			String lon = e.getElementsByTagName("lng").item(0).getTextContent();
			koordinaadid[0] = Double.parseDouble(lat);
			koordinaadid[1] = Double.parseDouble(lon);
		
		} catch (Exception ex){
			ex.printStackTrace();
		}
		return koordinaadid;
	}
	
	
	public String toString(){
		return nimi + " laiuskraadid: " + latKraadides + " pikkuskraadid " + lonKraadides;
	}	
}
