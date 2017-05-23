package tanel;

import java.util.*;
import javax.transaction.Transactional;
import org.springframework.data.repository.CrudRepository;
@Transactional
public interface tootajahaldur extends CrudRepository<tootaja, String>{

}