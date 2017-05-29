package karin;
import java.util.*;     //Date ja Calendar jaoks
import java.text.*;     //simpleDateFormat jaoks
import javax.persistence.*;

@Entity
@Table(name="teekond")
public class Teekond{
	
	static SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyy HH:mm");
	
	Date start;
	@Id 
	@Column(name = "tk_id", nullable = false)
    @GeneratedValue(strategy = GenerationType.AUTO)
	int tk_id;
	double teekonnaPikkus;
	String aeg_kokku;
	double kiirus;
	String kellIgasPunktis;
	@OneToMany(mappedBy="teekond", cascade=CascadeType.ALL)
	List<Koht> marsruut; 
	
	
	public Teekond() {}
	
	public Teekond(List<Koht> kohad){
		marsruut = kohad;
		
	}
	//setter
	
	public void setKoht(Koht k){
		marsruut.add(k);
	}
	
	public void setKiirus(double kiirus){
		this.kiirus = kiirus;
	}
	
	public void stardiAeg2(int aasta, int kuu, int kuupäev, int tund, int minut){
		Calendar kal = Calendar.getInstance();
		kal.set(aasta, kuu-1, kuupäev, tund, minut, 0); //stardi aeg
		this.start = kal.getTime();
	}
	
	public void setTeekonnaPikkus(){
		double km = 0;
		for(int i = 0; i < marsruut.size() - 1; i++){
			km += punktistPunktiVahemaa(marsruut.get(i), marsruut.get(i+1));
		}
		this.teekonnaPikkus = Math.round(km * Math.pow(10, 1)) / Math.pow(10, 1);
		
	}
	
	public void setAegKokku(){
		double aeg = getTeekonnaPikkus() / kiirus;  //double tunnid
		int tunnid = (int)aeg;
		aeg = (aeg - tunnid) * 60;    //double minutid
		int minutid = (int)aeg;
		aeg = Math.round((aeg - minutid) * 60);   //double sekundid
		int sekundid = (int)aeg;
		this.aeg_kokku = (tunnid + ":" + minutid + ":" + sekundid);
		
	}
	
	public void setKellaAjad(){                  //tallinn: 27/05/2017 17:34
		StringBuffer sb = new StringBuffer();
		Calendar kalender = Calendar.getInstance();
		sb.append(marsruut.get(0).nimi + ": " + sdf.format(start) + "<br>");   //<br />
		long ms = start.getTime();   //ms 1970...stardist
		for(int i = 0; i < (marsruut.size()) - 1; i++){
			double vahemaa = punktistPunktiVahemaa(marsruut.get(i), marsruut.get(i+1));  
			double kulunudSekundeid = vahemaa/kiirus * 60 * 60;
			long kulunudMillisekundid =(long)kulunudSekundeid * 1000;
			ms += kulunudMillisekundid;      //ms uues punktis  
			kalender.setTimeInMillis(ms);            
			sb.append(marsruut.get(i+1).nimi + ": " +  sdf.format(kalender.getTime()) + "<br>");
		}
		this.kellIgasPunktis = sb.toString();
	}
	
	//getter
	
	public int getId(){
		return tk_id;
	}
	
	public double getKiirus(){
		return kiirus;
	}
	
	public Koht getKoht(int i){
		return marsruut.get(i);
	}
	
	public String getKohad(){
		StringBuffer sb = new StringBuffer();
		for(int i = 0; i < marsruut.size(); i++){
			sb.append((marsruut.get(i)).nimi + "-> ");
			if(i == (marsruut.size()) - 1){
				sb.append((marsruut.get(i)).nimi);
			}
		}
		return (sb.toString());
	}
	
	public String getKellaAjad(){
		return kellIgasPunktis;
	}
	
	public String getAegKokku(){
		return aeg_kokku;
	}
	
	public double getTeekonnaPikkus(){
		return teekonnaPikkus;
	}
	
	public static double punktistPunktiVahemaa(Koht a, Koht b){
		double m = Math.acos(Math.sin(a.lat) * Math.sin(b.lat) + Math.cos(a.lat)* Math.cos(b.lat) * Math.cos(b.lon - a.lon) ) * 6371000;
		return	m / 1000;  //distants kilomeetrites
	}
}

