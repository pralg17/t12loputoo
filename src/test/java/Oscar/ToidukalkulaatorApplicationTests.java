package Oscar;

import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.test.context.junit4.SpringRunner;
import static org.junit.Assert.*;

@RunWith(SpringRunner.class)
@SpringBootTest
public class ToidukalkulaatorApplicationTests {

	@Test
	public void testToituaine(){
		Toituaine banaan = new Toituaine();
		banaan.Toituaine("banaan", 5,2,3,4);
		assertEquals("banaan", banaan.toiduaine);
		assertEquals(5, banaan.kalorid,0.01);
		assertEquals(2, banaan.valk,0.01);
		assertEquals(3, banaan.rasv,0.01);
		assertEquals(4, banaan.sysivesikud,0.01);
	}
	public void contextLoads() {
	}

}
