package kent;

import org.junit.*;
import static org.junit.Assert.*;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.test.context.junit4.SpringRunner;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.boot.test.context.SpringBootTest.WebEnvironment;
import org.springframework.boot.test.web.client.TestRestTemplate;


@RunWith(SpringRunner.class)
@SpringBootTest(webEnvironment=WebEnvironment.RANDOM_PORT)
public class AutorendiTest{
    @Autowired
    private TestRestTemplate restTemplate;

	@Test
	public void tervitustest(){
    String vastus = this.restTemplate.getForObject("/algus",String.class);
		//assertEquals("2", this.restTemplate.getForObject("/tähed?tekst=Tere mina olen Kalle",String.class));
    assertEquals("Ahoi!", vastus.substring(0));
	}

  @Test
	public void leidmistest(){
    String vastus = this.restTemplate.getForObject("/leia?email=juku@eesti.ee",String.class);
		//assertEquals("2", this.restTemplate.getForObject("/tähed?tekst=Tere mina olen Kalle",String.class));
    assertEquals("juku@eesti.ee rentimisi 14", vastus.substring(0));
	}

  @Test
  public void rentimistest(){
    String vastus = this.restTemplate.getForObject("/rent?email=kent@eesti.ee&autonumber=123BMH&mark=Opel&mudel=Astra",String.class);
    //assertEquals("2", this.restTemplate.getForObject("/tähed?tekst=Tere mina olen Kalle",String.class));
    assertEquals("kent@eesti.ee rentis auto 123BMH Opel Astra", vastus.substring(0));
  }


}
