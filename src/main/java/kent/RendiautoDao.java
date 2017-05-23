package kent;
import javax.transaction.Transactional;
import org.springframework.data.repository.CrudRepository;
@Transactional
public interface RendiautoDao extends CrudRepository<Rendiauto, String> {

}
