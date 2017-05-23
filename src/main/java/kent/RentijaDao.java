package kent;
import javax.transaction.Transactional;
import org.springframework.data.repository.CrudRepository;
@Transactional
public interface RentijaDao extends CrudRepository<Rentija, String> {

}
