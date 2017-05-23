package tanel;

import java.util.*;
import javax.persistence.*;

@Entity
@Table(name="e_tootaja")
public class tootaja{
    @Id
    public String nimi;
    public String amet;
    public float tunnipalk;
    @OneToMany(mappedBy="nimi")
    Set<tooaeg> tooaeg;
}