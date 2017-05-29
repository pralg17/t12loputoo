package Oscar;

import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.Table;

@Entity
@Table(name="toit")
public class Toituaine{
    @Id
    String toiduaine;
    double kalorid;
    double valk;
    double rasv;
    double sysivesikud;

    public void Toituaine(String toiduaine, double kalorid, double valk, double rasv, double sysivesikud){
        this.toiduaine = toiduaine;
        this.kalorid = kalorid; 
        this.valk = valk;
        this.rasv = rasv;
        this.sysivesikud = sysivesikud;
    }

    public double saakalorid(){
        return kalorid;
    }

}