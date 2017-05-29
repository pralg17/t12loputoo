import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;


public class KontrollTest {
	private final WebDriver driver;

	public KontrollTest(WebDriver driver) {

	    this.driver = driver;
	}

	public void loginAs(String user, String password) {
	    driver.get("https://www.twitter.com/");

	}

	public static void main(String[] args) throws InterruptedException{
	    WebDriver driver;
	    System.setProperty("webdriver.gecko.driver", "/Users/Karoliina/Downloads/geckodriver");
	    driver =new FirefoxDriver();
	    KontrollTest login = new KontrollTest(driver);

	    login.loginAs("jaansandersillar@gmail.com", "parool123");

	}
}
