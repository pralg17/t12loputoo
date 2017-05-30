package martin;
import javax.transaction.Transactional;
import org.springframework.data.repository.CrudRepository;
@Transactional
public interface BookManager extends CrudRepository<raamatud, String> {
}