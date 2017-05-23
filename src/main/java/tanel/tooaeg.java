package tanel;

import javax.persistence.*;
import java.util.Date;

@Entity
@Table(name="e_tooaeg")

public class tooaeg{
    @Id
    @GeneratedValue
    public int id;
    public String nimi;
    public Date kuupäev;
    public int tootunde;
    @ManyToOne
    @JoinColumn(name="nimi")
    public tootaja tootaja;
}
