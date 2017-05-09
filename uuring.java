import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
 
public class uuring
{    
    public static void main(String[] args) throws IOException
    {    
        BufferedReader reader1 = new BufferedReader(new FileReader("geen1.txt"));
        BufferedReader reader2 = new BufferedReader(new FileReader("geen2.txt"));
         
        String line1 = reader1.readLine();
         
        String line2 = reader2.readLine();
         
        boolean areEqual = true;
         
        int lineNum = 1;
         
        while (line1 != null || line2 != null)
        {
            if(line1 == null || line2 == null)
            {
                areEqual = false;
                 
                break;
            }
            else if(! line1.equalsIgnoreCase(line2))
            {
                areEqual = false;
                 
                System.out.println("Neil on erinev järjestus. Neil on erinevad nukleiinhapped "+lineNum);
            }
             
            line1 = reader1.readLine();
             
            line2 = reader2.readLine();
             
            lineNum++;
        }
         
        if(areEqual)
        {
            System.out.println("Mõlemal on sama järjestus.");
        }
        else
        {
            System.out.println("Neil on erinev järjestus. Neil on erinevad nukleiinhapped "+lineNum);
             
            System.out.println("Geen 1-l on "+line1+" ja Geen 2-l on "+line2+" real "+lineNum);
        }
         
        reader1.close();
         
        reader2.close();
    }
}
	