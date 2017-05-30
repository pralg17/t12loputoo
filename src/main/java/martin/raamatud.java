package martin;

import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.Table;

@Entity
@Table(name="raamatud")
public class raamatud{
  @Id
  public String title;
  public String author;
  public int year;
  public int isbn;
  public String binding;
  public String publisher;
  public String zanr;
  
}

