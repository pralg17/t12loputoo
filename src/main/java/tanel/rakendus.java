package tanel;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@SpringBootApplication
@RestController
public class rakendus{
    @Autowired
    private tootajahaldur haldur;

    @RequestMapping("/tervitus")
    public String tervitus1(){
        return "Tere!";
    }


    public static void main(String[] args) {

        SpringApplication.run(rakendus.class);
    }
}