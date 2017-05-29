package baas;

import javax.transaction.Transactional;
import org.springframework.data.repository.CrudRepository;
import java.util.*;
@Transactional
public interface KasutajaData extends CrudRepository<Kasutaja, String>{
}
