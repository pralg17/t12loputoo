package baas;

import javax.transaction.Transactional;
import org.springframework.data.repository.CrudRepository;
import java.util.*;
@Transactional
public interface MarkmedData extends CrudRepository<Markmed, String>{
}
