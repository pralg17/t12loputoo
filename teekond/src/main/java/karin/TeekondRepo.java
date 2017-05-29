package karin;

import java.util.*;        
import javax.transaction.Transactional;
import org.springframework.data.repository.CrudRepository;
//import org.springframework.data.repository.query.Param;


@Transactional
public interface TeekondRepo extends CrudRepository<Teekond, Integer>{
	List<Teekond> findAll();
	
}

//java\programmid\2kontrolltood15\kaugusedmaal