package karin;

import org.junit.*;
import static org.junit.Assert.*;

public class EsimeneTest{

     
	 @Test
	 public void test1(){
		 assertEquals(24.7406368, 24.7406368, 0.01);
	 }
	 
	
    @Test                             
    public void test2(){
		Koht tallinn = new Koht("Tallinn", 59.4306, 24.7406368);
		assertEquals("Tallinn", tallinn.nimi);
        assertEquals(59.4306, tallinn.latKraadides, 0.01);
        assertEquals(24.7406368, tallinn.lonKraadides, 0.01);  
		assertEquals(1.03725964, tallinn.lat, 0.01);
        assertEquals(0.431805571, tallinn.lon, 0.01); 
         
    }
	
	
}